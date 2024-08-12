<?php

namespace App\Http\Controllers\pos;

use Illuminate\Http\Request;


use App\Http\Controllers\Controller;

use App\Models\Employee;
use App\Models\EmployeeAttendance;


class EmployeeAttendanceController extends Controller
{
    public function index()
    {
        $attendanceData = EmployeeAttendance::with('employee')->get();
        return view('backend.attendance.index', compact('attendanceData'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('backend.attendance.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'arrival_time' => 'nullable|date_format:H:i',
            'departure_time' => 'nullable|date_format:H:i',
            'status' => 'required|in:present,absent,late,excused',
        ]);
  


        EmployeeAttendance::create($request->all());

        return redirect()->route('attendance.index')->with('success', 'Attendance recorded successfully.');
    }
}
