@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">إضافة حضور</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">سجل حضور الموظف</h4><br>

                        <form method="POST" action="{{ route('attendance.store') }}">
                            @csrf

                            <div class="mb-3 row">
                                <label for="employee_id" class="col-sm-2 col-form-label">الموظف</label>
                                <div class="col-sm-10">
                                    <select name="employee_id" class="form-select">
                                        <option selected disabled>اختر موظفاً</option>
                                        @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="date" class="col-sm-2 col-form-label">التاريخ</label>
                                <div class="col-sm-10">
                                    <input type="date" name="date" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="status" class="col-sm-2 col-form-label">الحالة</label>
                                <div class="col-sm-10">
                                    <select name="status" class="form-select">
                                        <option value="present">حاضر</option>
                                        <option value="absent">غائب</option>
                                        <option value="late">متأخر</option>
                                        <option value="excused">مُعذر</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>

@endsection