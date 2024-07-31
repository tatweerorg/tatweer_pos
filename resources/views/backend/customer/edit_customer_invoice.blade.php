@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">فاتورة زبون</h4>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <a href="{{route('credit.customer')}}" class="btn btn-secondary waves-effect waves-light" style="float:right;"><i class="fas fa-angle-left"></i> للخلف</a>


                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <div class="p-2">
                                        <h3 class="font-size-16"><strong>فاتورة زبون (رقم الفاتورة :#{{ $payment->invoice_id }})</strong></h3>
                                    </div>
                                    <div class="">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <td><strong>اسم الزبون</strong></td>
                                                    <td class="text-center"><strong>رقم الهاتف</strong></td>
                                                    <td class="text-center"><strong>الايميل</strong>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>{{ $payment['customer']['name'] }}</td>
                                                    <td class="text-center">{{ $payment['customer']['mobile_no'] }}</td>
                                                    <td class="text-center">{{ $payment['customer']['email'] }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end row -->

                        <div class="row">
                            <div class="col-12">
                                <form action="{{ route('customer.update.invoice',$payment->invoice_id) }}" method="post">
                                @csrf
                                <div>
                                    <div class="p-2">
                                        <h3 class="font-size-16"><strong>عناصر الفاتورة</strong></h3>
                                    </div>
                                    <div class="">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <td><strong>Sl </strong></td>
                                                    <td class="text-center"><strong>الفئة</strong></td>
                                                    <td class="text-center"><strong>اسم المنتج</strong>
                                                    </td>
                                                    <td class="text-center"><strong>المخزون الحالي</strong>
                                                    </td>
                                                    <td class="text-center"><strong>الكمية</strong>
                                                    </td>
                                                    <td class="text-center"><strong>سعر المنتج </strong>
                                                    </td>
                                                    <td class="text-center"><strong>المبلع الاجمالي</strong>
                                                    </td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                                @php
                                                $total_sum = '0';
                                                $invoice_details = App\Models\InvoiceDetail::where('invoice_id',$payment->invoice_id)->get();
                                                @endphp
                                                @foreach($invoice_details as $key => $details)
                                                <tr>
                                                    <td class="text-center">{{ $key+1 }}</td>
                                                    <td class="text-center">{{ $details['category']['name'] }}</td>
                                                    <td class="text-center">{{ $details['product']['name'] }}</td>
                                                    <td class="text-center">{{ $details['product']['quantity'] }}</td>
                                                    <td class="text-center">{{ $details->selling_qty }}</td>
                                                    <td class="text-center">{{ $details->unit_price }}</td>
                                                    <td class="text-center">{{ $details->selling_price }}</td>

                                                </tr>
                                                @php
                                                $total_sum += $details->selling_price;
                                                @endphp
                                                @endforeach

                                                <tr>
                                                    <td class="thick-line"></td>
                                                    <td class="thick-line"></td>
                                                    <td class="thick-line"></td>
                                                    <td class="thick-line"></td>
                                                    <td class="thick-line"></td>
                                                    <td class="thick-line text-center">
                                                        <strong>المجموع الفرعي</strong></td>
                                                    <td class="thick-line text-end">${{ $total_sum }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line text-center">
                                                        <strong>الخصم</strong></td>
                                                    <td class="no-line text-end">${{ $payment->discount_amount }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line text-center">
                                                        <strong>المبلغ المدفوع</strong></td>
                                                    <td class="no-line text-end">${{ $payment->paid_amount }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line text-center">
                                                        <strong>المبلغ المستحق</strong></td>
                                                        <input type="hidden" name="new_paid_amount" value="{{ $payment->due_amount }}">
                                                    <td class="no-line text-end">${{ $payment->due_amount }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line text-center">
                                                        <strong>المبلغ الاجمالي</strong></td>
                                                    <td class="no-line text-end"><h4 class="m-0">${{ $payment->total_amount }}</h4></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label> حالة الدفع </label>
                                                <select name="paid_status" id="paid_status" class="form-select">
                                                    <option value="">اختر الحالة</option>
                                                    <option value="full_paid">كامل</option>
                                                    <option value="partial_paid">جزئي </option>
                                                </select>
                                                <input type="text" name="paid_amount" class="form-control paid_amount" placeholder="Enter Paid Amount" style="display:none;">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <div class="md-3">
                                                    @php
                                                        date_default_timezone_set('Asia/Dhaka');
                                                        $date = date('Y-m-d');
                                                    @endphp
                                                    <label for="example-text-input" class="form-label">التاريخ</label>
                                                    <input class="form-control example-date-input" value="{{ $date }}" name="date" type="date"  id="date">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <div class="md-3" style="padding-top:30px;">
                                                    <button type="submit" class="btn btn-info">تعديل الفاتورة</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>

<script type="text/javascript">
    // Paid amount For Partial Pay
    $(document).on('change','#paid_status', function(){
        var paid_status = $(this).val();
        if (paid_status == 'partial_paid') {
            $('.paid_amount').show();
        }else{
            $('.paid_amount').hide();
        }
    });
</script>

@endsection
