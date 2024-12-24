@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">تقرير دفع الزبون</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">
                                <div class="invoice-title">
                                    <h3>فحم الزين</h3>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <address>
                                            نوبا و الخليل<br>
                                            حسن الطرمان :0568190719<br>
                                            تحسين الطرمان :0595109779
                                        </address>
                                    </div>
                                    <div class="col-6 mt-4 text-end">
                                        <address>
                                            <!-- معلومات إضافية إن وجدت -->
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <div class="p-2">
                                        <h3 class="font-size-16"><strong>عناصر الفاتورة</strong></h3>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center"><strong>اسم الزبون</strong></th>
                                                    <th class="text-center"><strong>رقم الفاتورة</strong></th>
                                                    <th class="text-center"><strong>التاريخ</strong></th>
                                                    <th class="text-center"><strong>المبلغ المستحق</strong></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $total_due = 0;
                                                @endphp
                                                @foreach($allData as $customer)
                                                    @foreach($customer->partialPayments as $payment)
                                                        <tr>
                                                            <td class="text-center">{{ $customer->name }}</td>
                                                            <td class="text-center">#{{ $payment->id }}</td>
                                                            <td class="text-center">{{ date('d-m-Y', strtotime($payment->payment_date)) }}</td>
                                                            <td class="text-center">{{ $payment->amount }}</td>
                                                        </tr>
                                                        @php
                                                        $total_due += $payment->amount;
                                                        @endphp
                                                    @endforeach
                                                @endforeach
                                                <tr>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line text-center"><strong>اجمالي المبلغ المدفوع</strong></td>
                                                    <td class="no-line text-end"><h4 class="m-0">₪{{ $total_due }}</h4></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    @php
                                    $date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
                                    @endphp
                                    <i>وقت الطباعة: {{ $date->format('F j, Y, g:i a') }}</i>

                                    <div class="d-print-none">
                                        <div class="float-end">
                                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>

@endsection