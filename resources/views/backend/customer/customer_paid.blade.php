@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">جميع دفوعات الزبائن</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                    <a href="{{route('paid.customer.print.pdf')}}" class="btn btn-secondary waves-effect waves-light" style="float:right;"><i class="fas fa-print"></i> طباعة مدفوعات الزبائن</a>
                    <br><br>

                        <h4 class="card-title">بيانات جميع المدفوعات</h4><br>

                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>رقم الفاتورة</th>
                                <th>المبلغ المدفوع</th>
                                <th>المبلغ المتبقي</th>
                                <th>حالة الدفع</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($allData as $key => $invoice)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $invoice->invoice_id }}</td>
                                    <td>{{ $invoice->paid_amount }}</td>
                                    <td>{{ $invoice->due_amount }}</td>
                                    <td>{{ $invoice->paid_status }}</td>
                                    <td>
                                        <a href="{{ route('customer.invoice.details.pdf', $invoice->id) }}" class="btn btn-info sm" title="عرض التفاصيل">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
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
