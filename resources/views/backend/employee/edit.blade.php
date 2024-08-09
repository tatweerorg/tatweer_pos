@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">تعديل الموظف</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">نموذج تعديل الموظف</h4><br>

                        <form method="post" action="{{ route('employee.update', $employee->id) }}">
                            @csrf

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">اسم الموظف</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="name" value="{{ $employee->name }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">الرصيد</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="number" step="0.01" name="balance" value="{{ $employee->balance }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">نوع العمل</label>
                                <div class="col-sm-10">
                                    <select name="worktype" class="form-select" required>
                                        <option value="hours" {{ $employee->worktype == 'hours' ? 'selected' : '' }}>ساعات</option>
                                        <option value="days" {{ $employee->worktype == 'days' ? 'selected' : '' }}>أيام</option>
                                        <option value="months" {{ $employee->worktype == 'months' ? 'selected' : '' }}>شهور</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">تاريخ البدء</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="date" name="startdate" value="{{ $employee->startdate }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">نوع الوظيفة</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="jobtype" rows="3" required>{{ $employee->jobtype }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">تحديث الموظف</button>
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