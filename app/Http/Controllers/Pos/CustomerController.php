<?php

namespace App\Http\Controllers\Pos;

use Auth;
use Image;
use App\Models\Payment;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\PaymentDetail;
use App\Models\PartialPayment;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class CustomerController extends Controller
{
    public function CustomerAll(){
        $customers = Customer:: latest()->get();
        return view('backend.customer.customer_all',compact('customers'));
    }

    public function CustomerAdd(){
        return view('backend.customer.customer_add');
    }

    public function CustomerStore(Request $request){
        if ($request->hasFile('customer_image')) {

        $image=$request->file('customer_image');
        $name_gen=hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

        Image::make($image)->resize(200,200)->save('upload/customer/'.$name_gen);
        $save_url = 'upload/customer/'.$name_gen;
                Customer::insert([
            'customer_image'=>$save_url,
            ]);

        }
        Customer::insert([
            'name'=>$request->name,
            'mobile_no'=>$request->mobile_no,
            'email'=>$request->email,
            'address'=>$request->address,
            'created_by'=>Auth::user()->id,
            'created_at'=>Carbon::now(),
        ]);

        $notification=array(
            'message'=>'Customer Inserted Successfully',
            'alert-type'=>'success'
        );

        return redirect()->route('customer.all')->with($notification);
    }

    public function CustomerEdit($id){
        $customer = Customer::FindOrFail($id);
        return view('backend.customer.customer_edit',compact('customer'));
    }
    public function CustomerView($id){
        $customer = Customer::FindOrFail($id);
        $Payments= Payment::where('customer_id',$id)
                                -> whereIn('paid_status',['full_due','partial_paid', 'full_paid'])
                                ->get();
        
        return view('backend.customer.customer_view',compact('customer', 'Payments'));
    }
    public function CustomerUpdate(Request $request){
        $customer_id=$request->id;
        if($request->file('customer_image')){
            $image=$request->file('customer_image');
            $name_gen=hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::make($image)->resize(200,200)->save('upload/customer/'.$name_gen);
            $save_url = 'upload/customer/'.$name_gen;
            Customer::FindOrFail($customer_id)->update([
                'name'=>$request->name,
                'mobile_no'=>$request->mobile_no,
                'email'=>$request->email,
                'address'=>$request->address,
                'customer_image'=>$save_url,
                'updated_by'=>Auth::user()->id,
                'updated_at'=>Carbon::now(),
            ]);

            $notification=array(
                'message'=>'Customer Updated With Image Successfully',
                'alert-type'=>'success'
            );

            return redirect()->route('customer.all')->with($notification);
        }else{
            Customer::FindOrFail($customer_id)->update([
                'name'=>$request->name,
                'mobile_no'=>$request->mobile_no,
                'email'=>$request->email,
                'address'=>$request->address,
                'updated_by'=>Auth::user()->id,
                'updated_at'=>Carbon::now(),
            ]);

            $notification=array(
                'message'=>'Customer Updated Without Image Successfully',
                'alert-type'=>'success'
            );

            return redirect()->route('customer.all')->with($notification);
        }
    }

    public function DeleteCustomer($id){
        $customers=Customer::FindOrFail($id);
        if($customers->customer_image){

            $img = $customers->customer_image;
            unlink($img);
        }

        Customer::FindOrFail($id)->delete();

        $notification = array(
            'message' => 'Customer Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function CreditCustomer(){
        $allData = Payment::whereIn('paid_status',['full_due','partial_paid'])->get();
        return view('backend.customer.customer_credit',compact('allData'));
    }

    public function CreditCustomerPdf(){
        $allData = Payment::whereIn('paid_status',['full_due','partial_paid'])->get();
        return view('backend.pdf.customer_credit_pdf',compact('allData'));
    }

    public function CustomerEditInvoice($invoice_id){
        $payment = Payment::where('invoice_id',$invoice_id)->first();
        return view('backend.customer.edit_customer_invoice',compact('payment'));
    }

    public function CustomerUpdateInvoice(Request $request,$invoice_id){
        if($request->new_paid_amount < $request->paid_amount){
            $notification = array(
                'message' => 'Sorry You Paid Maximum Value',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }else{
            $payment = Payment::where('invoice_id',$invoice_id)->first();
            $payment_details = new PaymentDetail();
            $payment->paid_status=$request->paid_status;

            if($request->paid_status == 'full_paid'){
                $payment->paid_amount = Payment::where('invoice_id',$invoice_id)->first()['paid_amount']+$request->new_paid_amount;
                $payment->due_amount = '0';
                // $payment->paid_status = 'full_paid';
                $payment_details->current_paid_amount = $request->nwe_paid_amount;
            }elseif($request->paid_status == 'partial_paid'){
                $payment->paid_amount = Payment::where('invoice_id',$invoice_id)->first()['paid_amount'] + $request->paid_amount;
                $payment->due_amount = Payment::where('invoice_id',$invoice_id)->first()['due_amount'] - $request->paid_amount;
                $payment_details->current_paid_amount = $request->paid_amount;
            }else{
                $notification = array(
                    'message' => 'Invalid Data',
                    'alert-type' => 'error'
                );

                return redirect()->back()->with($notification);
                dd('Invalid Data');
            }
            // dd(Payment::where('invoice_id',$invoice_id)->first()['due_amount']);
            $payment->save();
            $payment_details->invoice_id = $invoice_id;
            $payment_details->date = date('Y-m-d',strtotime($request->date));
            $payment_details->updated_by = Auth::user()->id;
            $payment_details->save();

            $notification = array(
                'message' => 'Invoice Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('credit.customer')->with($notification);
        }
    }

    public function CustomerInvoiceDetails($invoice_id){
        $payment = Payment::where('invoice_id',$invoice_id)->first();
        return view('backend.pdf.invoice_details_pdf',compact('payment'));
    }

    public function PaidCustomer() {
        $allData = Payment::where('paid_status', '!=', 'full_due')
                          ->with(['Customer', 'paymentDetails']) 
                          ->get();
    
        return view('backend.customer.customer_paid', compact('allData'));
    }
    
    public function PaidCustomerPrintPdf()
    {
        $allData = Customer::with('partialPayments')->get();
    
        return view('backend.pdf.customer_paid_pdf', compact('allData'));
    }
    

    public function CustomerWiseReport(){
        $customers = Customer::all();
        return view('backend.customer.customer_wise_report',compact('customers'));
    }

    public function CustomerWiseCreditReport(Request $request){
        $allData = Payment::where('customer_id',$request->customer_id)->whereIn('paid_status',['full_due','partial_paid'])->with('invoice')->get();
        $customer = Customer::where('id', $request->customer_id)->first();


        return view('backend.pdf.customer_wise_credit_pdf',compact('allData', 'customer'));
    }

    public function CustomerWisePaidReport(Request $request) {
        $allData = PartialPayment::where('customer_id', $request->customer_id)->get();
    
        $customer = Customer::where('id', $request->customer_id)->first();
    
        return view('backend.pdf.customer_wise_paid_pdf', compact('allData', 'customer'));
    }
    
}
