@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">تقرير المخزون حسب الموردين</h4>

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
                                        <!-- <img src="{{ asset('backend/assets/images/logo-light.png') }}" alt="logo" height="100" /> -->
                                        فحم الزين
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

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <div class="p-2">
                                        <h3 class="font-size-16"><strong>عناصر الفاتورة</strong></h3>
                                    </div>
                                    <div class="">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <td class="text-center"><strong># </strong></td>
                                                        <td class="text-center"><strong>الوحدة</strong>
                                                        </td>
                                                        <td class="text-center"><strong>الفئة</strong>
                                                        </td>
                                                        <td class="text-center"><strong>اسم المنتج</strong>
                                                            <!--  <td class="text-center"><strong>الكمية الداخلة </strong> -->
                                                        <td class="text-center"><strong>الكمية الخارجة</strong>
                                                        </td>
                                                        <td class="text-center"><strong>المخزن</strong>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                                    @foreach($allData as $key => $item)
                                                    @php
                                                    $buying_total = App\Models\Purchase::where('category_id',$item->category_id)->where('product_id',$item->id)->where('status','1')->sum('buying_qty');

                                                    $selling_total = App\Models\InvoiceDetail::where('category_id',$item->category_id)->where('product_id',$item->id)->where('status','1')->sum('selling_qty');
                                                    @endphp
                                                    <tr>
                                                        <td class="text-center">{{( $key+1 )}}</td>
                                                        <td class="text-center">{{( $item['unit']['name'] )}}</td>
                                                        <td class="text-center">{{( $item['category']['name'] )}}</td>
                                                        <td class="text-center">{{( $item->name )}}</td>
                                                        <!-- <td class="text-center">{{( $buying_total )}}</td> -->
                                                        <td class="text-center">{{( $selling_total )}}</td>
                                                        <td class="text-center">{{( $item->quantity )}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        @php
                                        $date = new DateTime('now',new DateTimeZone('Asia/Dhaka'));
                                        @endphp
                                        <i>Printing Time : {{ $date->format('F j, Y, g:i a') }}</i>

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