@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">لوحة القيادة</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">

            <div class="col-xl-2 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                @php
                                $customerCount = App\Models\Customer::count();
                                @endphp
                                <p class="text-truncate font-size-22 mb-2">الزبائن</p>
                                <h4 class="mb-2">{{ $customerCount }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="ri-user-3-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-2 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                @php
                                $supplierCount = App\Models\Supplier::count();
                                @endphp
                                <p class="text-truncate font-size-22 mb-2">الموردين</p>
                                <h4 class="mb-2">{{ $supplierCount }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="ri-archive-line font-size-24" style="color: rgb(88, 201, 88);"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-2 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                @php
                                $productCount = App\Models\Product::count();
                                @endphp
                                <p class="text-truncate font-size-22 mb-2">المنتجات</p>
                                <h4 class="mb-2">{{ $productCount }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="ri-dropbox-fill font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-2 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                @php
                                $totalBuyingPrice = App\Models\Purchase::where('status', 1)->sum('buying_price');
                                @endphp
                                <p class="text-truncate font-size-22 mb-2">إجمالي المشتريات</p>
                                <h4 class="mb-2">{{ $totalBuyingPrice }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="mdi mdi-currency-usd font-size-24" style="color: rgb(88, 201, 88);"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-2  col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                @php
                                $totalBuyingPrice = App\Models\Invoice::where('status', 1)
                                ->with('invoice_details') // تحميل تفاصيل الفاتورة المرتبطة
                                ->get()
                                ->reduce(function ($carry, $invoice) {
                                // جمع أسعار الشراء من تفاصيل الفاتورة
                                return $carry + $invoice->invoice_details->sum('selling_price');
                                }, 0);
                                @endphp
                                <p class="text-truncate font-size-22 mb-2">إجمالي المبيعات</p>
                                <h4 class="mb-2">{{ $totalBuyingPrice }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="mdi mdi-currency-usd font-size-24" style="color: rgb(88, 201, 88);"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-2  col-md-6">
                <div class="card" >
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                @php
                                $allData = App\Models\Payment::whereIn('paid_status',['full_due','partial_paid'])->get();
                                $totalDueAmount = $allData->sum('due_amount');

                                @endphp
                                <p class="text-truncate font-size-22 mb-2">إجمالي الديون</p>

                                <h4 class="mb-2">{{ $totalDueAmount}}</h4>
                            </div>
                            <div class="avatar-sm">
                                <a href="{{ route('credit.customer.pdf') }}" class="avatar-title bg-light text-primary rounded-3">
                                    <i class="mdi mdi-currency-usd font-size-24" style="color: rgb(88, 201, 88);"></i>
                                </a>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->


        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-4">كل الحركات المالية</h4>

                        <div class="table-responsive">
                            <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th>اسم الزبون</th>
                                        <th>رقم الفاتورة</th>
                                        <th>التاريخ</th>
                                        <th>الوصف</th>
                                        <th>المبلغ</th>
                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                    @php
                                    $allData = App\Models\Invoice::orderBy('date','desc')->orderBy('id','desc')->where('status','1')->get();
                                    @endphp
                                    @foreach($allData as $item)
                                    <tr>
                                        <td>
                                            <h6 class="mb-0"> {{ $item['payment']['customer']['name'] ?? 'N/A' }}
                                            </h6>
                                        </td>
                                        <td>#{{( $item->invoice_no )}}</td>
                                        <td>{{ date('d-m-Y',strtotime($item->date)) }}</td>
                                        <td>{{( $item->description )}}</td>

                                        <td>ILS {{( $item['payment']['total_amount'] ?? 'N/A')}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table> <!-- end table -->
                        </div>
                    </div><!-- end card -->
                </div><!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-4">كل المنتجات في المخزن</h4>

                        <div class="table-responsive">
                            <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th>اسم المنتج</th>
                                        <th> الكمية</th>

                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                    @php
                                    $allData = App\Models\Product::orderBy('category_id','asc')->get();
                                    @endphp
                                    @foreach($allData as $item)
                                    <tr>

                                        <td>{{( $item->name )}}</td>
                                        <td>{{( $item->quantity )}}</td>


                                    </tr>
                                    @endforeach
                                </tbody>
                            </table> <!-- end table -->
                        </div>
                    </div><!-- end card -->
                </div><!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>

</div>

@endsection