@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">تفاصيل المشتريات</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                      
                        <h4 class="card-title">حالة الدفع</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>تاريخ الدفع</th>
                                    <th>المبلغ المدفوع</th>
                                    <th>المبلغ المتبقي</th>
                                    <th>حالة الدفع</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $key => $payment)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $purchases[0]->date }}</td>
                                    <td>{{ $payment->paid_amount }}</td>
                                    <td>{{ $payment->due_amount }}</td>
                                    <td>{{ $payment->paid_status }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <a href="{{ route('purchase.all') }}" class="btn btn-secondary">العودة</a>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
        
    </div> <!-- container-fluid -->
</div>

@endsection
