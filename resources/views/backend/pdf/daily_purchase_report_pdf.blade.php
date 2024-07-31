@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">تقرير المشتريات اليومية</h4>

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
                                    <h3>
                                        <img src="{{ asset('backend/assets/images/logo-light.png') }}" alt="logo" height="100" />
                                    </h3>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <address>
                                            <strong>Tatweer.</strong><br>
                                            Nuba , Hebron<br>
                                            +970 568096370
                                        </address>
                                    </div>
                                    <div class="col-6 mt-4 text-end">
                                        <address>

                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <div class="p-2">
                                        <h3 class="font-size-16"><strong>تقرير المشتريات اليومية<span class="btn btn-info" style="margin-left: 10px;">{{ date('d-m-Y',strtotime($start_date)) }}</span> - <span class="btn btn-success">{{ date('d-m-Y',strtotime($end_date)) }}</span></strong></h3>
                                    </div>
                                </div>

                            </div>
                        </div> <!-- end row -->

                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <div class="p-2">
                                        <h3 class="font-size-16"><strong>Iعناصر الفاتورة</strong></h3>
                                    </div>
                                    <div class="">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <td><strong># </strong></td>
                                                        <td class="text-center"><strong>رقم المشتريات</strong></td>
                                                        <td class="text-center"><strong>التاريخ</strong>
                                                        </td>
                                                        <td class="text-center"><strong>اسم المنتج</strong>
                                                        </td>
                                                        <td class="text-center"><strong>الكيمة</strong>
                                                        </td>
                                                        <td class="text-center"><strong>سعر الوحدة</strong>
                                                        </td>
                                                        <td class="text-center"><strong>المبلغ الاجمالي</strong>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                                    @php
                                                    $total_sum = '0';
                                                    @endphp
                                                    @foreach($allData as $key => $item)
                                                    <tr>
                                                        <td class="text-center">{{ $key+1 }}</td>
                                                        <td class="text-center">{{ $item->purchase_no }}</td>
                                                        <td class="text-center">{{ date('d-m-Y',strtotime($item->date)) }}</td>
                                                        <td class="text-center">{{ $item['product']['name'] }}</td>
                                                        <td class="text-center">{{ $item->buying_qty }} {{ $item['product']['unit']['name'] }}</td>
                                                        <td class="text-center">{{ $item->unit_price }}</td>
                                                        <td class="text-center">{{ $item->buying_price }}</td>
                                                    </tr>
                                                    @php
                                                    $total_sum += $item->buying_price;
                                                    @endphp
                                                    @endforeach
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center">
                                                            <strong>المبلغ الاجمالي</strong>
                                                        </td>
                                                        <td class="no-line text-end">
                                                            <h4 class="m-0">${{ $total_sum }}</h4>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

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
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>

@endsection