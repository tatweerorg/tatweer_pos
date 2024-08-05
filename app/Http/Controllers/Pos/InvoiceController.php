<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Customer;
use App\Models\User;

use Auth;
use Illuminate\Support\Carbon;
use DB;



class InvoiceController extends Controller
{
    public function InvoiceAll(){
        $allData = Invoice::orderBy('date','desc')->orderBy('id','desc')->where('status','1')->get();
        return view('backend.invoice.invoice_all',compact('allData'));
    }

    public function InvoiceAdd(){
        $category=Category::all();
        $customer=Customer::all();
        $invoice_data=Invoice::orderBy('id','desc')->first();
        if($invoice_data == null){
            $firstReg = '0';
            $invoice_no = $firstReg+1;
        }else{
            $invoice_data=Invoice::orderBy('id','desc')->first()->invoice_no;
            $invoice_no = $invoice_data+1;
        }

        date_default_timezone_set('Asia/Hebron');
        $date = date('Y-m-d');
        return view('backend.invoice.invoice_add',compact('invoice_no','category','date','customer'));
    }

    public function InvoiceStore(Request $request){
        if($request->category_id == null){
            $notification = array(
                'message' => 'Sorry No Category information found',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }else{
            if($request->paid_amount > $request->estimated_amount){
                $notification = array(
                    'message' => 'Sorry Paid Amount is bigger then total price',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }else{
                $invoice = new Invoice();
                $invoice->invoice_no = $request->invoice_no;
                $invoice->date = date('Y-m-d',strtotime($request->date));
                $invoice->description = $request->description;
                $invoice->status = '0';
                $invoice->created_by = Auth::user()->id;

                DB::transaction(function() use($request,$invoice){
                    if($invoice->save()){
                        $count_category = count($request->category_id);
                        for($i=0;$i<$count_category;$i++){

                            if($request->selling_qty[$i]==null && $request->unit_price[$i]==null){
                                $notification = array(
                                    'message' => 'Null value detected',
                                    'alert-type' => 'error'
                                );

                                return redirect()->back()->with($notification);
                            }else{

                            $invoice_details = new InvoiceDetail();
                            $invoice_details->date = date('Y-m-d',strtotime($request->date));
                            $invoice_details->invoice_id = $invoice->id;
                            $invoice_details->category_id = $request->category_id[$i];
                            $invoice_details->product_id = $request->product_id[$i];
                            $invoice_details->selling_qty = $request->selling_qty[$i];
                            $invoice_details->unit_price = $request->unit_price[$i];
                            $invoice_details->selling_price = $request->selling_price[$i];
                            $invoice_details->status = '0';
                            $invoice_details->save();
                            }
                        }

                        if($request->customer_id == '0'){
                            $customer = new Customer();
                            $customer->name = $request->name;
                            $customer->mobile_no = $request->mobile_no;
                            $customer->email = $request->email;
                            $customer->save();
                            $customer_id = $customer->id;
                        } else{
                            $customer_id = $request->customer_id;
                        }

                        $payment = new Payment();
                        $payment_details = new PaymentDetail();

                        $payment->invoice_id = $invoice->id;
                        $payment->customer_id = $customer_id;
                        $payment->paid_status = $request->paid_status;
                        $payment->discount_amount = $request->discount_amount;
                        $payment->total_amount = $request->estimated_amount;

                        if ($request->paid_status == 'full_paid') {
                            $payment->paid_amount = $request->estimated_amount;
                            $payment->due_amount = '0';
                            $payment_details->current_paid_amount = $request->estimated_amount;
                        } elseif ($request->paid_status == 'full_due') {
                            $payment->paid_amount = '0';
                            $payment->due_amount = $request->estimated_amount;
                            $payment_details->current_paid_amount = '0';
                        }elseif ($request->paid_status == 'partial_paid') {
                            $payment->paid_amount = $request->paid_amount;
                            $payment->due_amount = $request->estimated_amount - $request->paid_amount;
                            $payment_details->current_paid_amount = $request->paid_amount;
                        }
                        $payment->save();

                        $payment_details->invoice_id = $invoice->id;
                        $payment_details->date = date('Y-m-d',strtotime($request->date));
                        $payment_details->save();
                    }
                });
            }
        }
        $notification = array(
            'message' => 'Invoice Data Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('invoice.pending')->with($notification);
    }
    public function InvoiceDelete($invoice_no){
        DB::transication(function() use ($invoice_no){
            $invoice = Invoice::where('invoice_no',$invoice_no)->first();
            if($invoice){
                InvoiceDetial::where('invoice_id',$invoice->id)->delete();
                Payment::where('invoice_id', $invoice->id)->delete();
                PaymentDetail::where('invoice_id', $invoice->id)->delete();
                $invoice->delete();
                $notification=array(
                    'message'=>'Invoice Deleted Successfully',
                    'alert-type'=>'success',
                );

            }else {
                $notification=array(
                    'message'=>'Invoice Not Found',
                    'alert-type'=>'error',
                );
            }
            return redirect()->route('invoice.pending')->with($notification);

        });
    }

    public function PendingList(){
        $allData = Invoice::orderBy('date','desc')->orderBy('id','desc')->where('status','0')->get();
        return view('backend.invoice.invoice_pending',compact('allData'));
    }

    public function DeleteInvoice($id){
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        InvoiceDetail::where('invoice_id',$invoice->id)->delete();
        Payment::where('invoice_id',$invoice->id)->delete();
        PaymentDetail::where('invoice_id',$invoice->id)->delete();

        $notification = array(
            'message' => 'Invoice Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function InvoiceApprove($id){
        $invoice=invoice::with('invoice_details')->FindOrFail($id);
        return view('backend.invoice.invoice_approve',compact('invoice'));
    }

    public function ApprovalStore(Request $request, $id){
        foreach($request->selling_qty as $key => $val){
            $invoice_details = InvoiceDetail::where('id',$key)->first();
            $product = Product::where('id',$invoice_details->product_id)->first();

            if($product->quantity < $request->selling_qty[$key]){
                $notification = array(
                    'message' => 'Sorry you are approving Maximum value',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
        }

        $invoice = Invoice::FindOrFail($id);
        $invoice->updated_by = Auth::user()->id;
        $invoice->status = '1';

        DB::transaction(function() use($request,$invoice,$id){
            foreach($request->selling_qty as $key => $val){
                $invoice_details = InvoiceDetail::where('id',$key)->first();
                $invoice_details->status = '1';
                $invoice_details->save();

                $product = Product::where('id',$invoice_details->product_id)->first();

                $product->quantity = ((float)$product->quantity) - ((float)$request->selling_qty[$key]);
                $product->save();
            }

            $invoice->save();
        });

        $notification = array(
            'message' => 'Invoice Approved Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('invoice.pending')->with($notification);
    }

    public function PrintInvoiceList(){
        $allData = Invoice::orderBy('date','desc')->orderBy('id','desc')->where('status','1')->get();
        return view('backend.invoice.invoice_print_list',compact('allData'));
    }

    public function PrintInvoice($id){
        $invoice=invoice::with('invoice_details')->FindOrFail($id);
        // الحصول على معرف المستخدم الذي أنشأ الفاتورة
$createdById = $invoice->created_by;

// استرجاع المستخدم الذي أنشأ الفاتورة
$creator = User::find($createdById);

// الحصول على اسم المستخدم
$creatorName =  $creator->name;
        return view('backend.pdf.invoice_pdf',compact('invoice', 'creatorName'));
    }

    public function DailyInvoiceReport(){
        return view('backend.invoice.daily_invoice_report');
    }

    public function DailyInvoicePdf(Request $request){
        $start_date = date('Y-m-d',strtotime($request->start_date));
        $end_date = date('Y-m-d',strtotime($request->end_date));
        $allData = Invoice::whereBetween('date',[$start_date,$end_date])->where('status','1')->get();
        return view('backend.pdf.daily_invoice_report_pdf',compact('allData','start_date','end_date'));
    }
}
