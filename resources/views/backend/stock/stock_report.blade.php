@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">تقرير المخزن</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                    <a href="{{route('stock.report.pdf')}}" target="_black" class="btn btn-secondary waves-effect waves-light" style="float:right;"><i class="fa fa-print"> Stock Report Print</i></a>
                    <br><br>

                        <h4 class="card-title">تقرير المخزن</h4><br>

                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>الوحدة</th>
                                <th>الفئة</th>
                                <th>اسم المنتج</th>
                                <th>الكمية الخارجة</th>
                                <th>المخزن</th>
                            </tr>
                            </thead>


                            <tbody>
                            @foreach($allData as $key =>$item)

                            @php
                                $buying_total = App\Models\Purchase::where('category_id',$item->category_id)->where('product_id',$item->id)->where('status','1')->sum('buying_qty');

                                $selling_total = App\Models\InvoiceDetail::where('category_id',$item->category_id)->where('product_id',$item->id)->where('status','1')->sum('selling_qty');
                            @endphp
                            <tr>
                                <td>{{( $key+1 )}}</td>
                                <td>{{( $item['unit']['name'] )}}</td>
                                <td>{{( $item['category']['name'] )}}</td>
                                <td>{{( $item->name )}}</td>
                               <td><span class="btn btn-info">{{( $selling_total )}}</span></td>
                                <td><span class="btn btn-danger">{{( $item->quantity )}}</span></td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->


    </div> <!-- container-fluid -->
</div>

@endsection
