@extends('admin.admin_master')

@section('admin')
<div class="page-content">
    <div class="container-fluid">
        <!-- Page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">تفاصيل راتب الموظف</h4>
                </div>
            </div>
        </div>

        <!-- Salary Details Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">تفاصيل الرواتب</h4><br>
                        <table class="table table-bordered dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>الشهر</th>
                                    <th>ساعات العمل</th>
                                    <th>السلفة</th>
                                    <th>حالة الراتب</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salaryDetails as $detail)
                                <tr>
                                    <td>{{ $detail->month }}</td>
                                    <td>{{ $detail->work_hours }}</td>
                                    <td>{{ $detail->advance }}</td>
                                    <td>
                                        @if($detail->salary_status == 'Delayed')
                                        <span class="text-danger">مؤجل</span>
                                        @elseif($detail->salary_status == 'Partial')
                                        <span class="text-warning">جزئي</span>
                                        @else
                                        <span class="text-success">مدفوع بالكامل</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Advance Form -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">تسجيل سلفة جديدة</h4><br>
                        <form action="{{ route('salary-details.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="advance_amount" class="form-label">مبلغ السلفة</label>
                                <input type="number" name="advance_amount" id="advance_amount" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="advance_month" class="form-label">الشهر</label>
                                <input type="month" name="advance_month" id="advance_month" class="form-control" required>
                            </div>
                            <input type="hidden" name="employee_id" value="{{ $employeeId }}">
                            <button type="submit" class="btn btn-success">تسجيل السلفة</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection