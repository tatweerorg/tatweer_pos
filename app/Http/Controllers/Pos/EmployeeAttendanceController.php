<?php

namespace App\Http\Controllers\pos;

use Carbon\Carbon;


use App\Models\Salary;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\EmployeeAttendance;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


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

        $employee = Employee::find($request->employee_id);
        $workType = $employee->work_type;

        $workHours = 0;
        if ($request->arrival_time && $request->departure_time) {
            $arrival = Carbon::createFromFormat('H:i', $request->arrival_time);
            $departure = Carbon::createFromFormat('H:i', $request->departure_time);
            $workHours = $departure->diffInHours($arrival);
        }

        $month = Carbon::parse($request->date)->format('m-Y'); 
        $monthstore = Carbon::parse($request->date)->format('m'); 
        $year = Carbon::parse($request->date)->format('Y');

        $totalWorkHoursForMonth = EmployeeAttendance::where('employee_id', $request->employee_id)
                                                    ->whereYear('date', $year)
                                                    ->whereMonth('date', $monthstore)
                                                    ->sum(DB::raw('TIMESTAMPDIFF(HOUR, arrival_time, departure_time)'));
    
        $salaryRecord = Salary::where('employee_id', $request->employee_id)
                            ->where('month', $month)
                            ->first();
        
        $salary_value=0;
        if($employee->worktype == 'hours'){
            $salary_value=$totalWorkHoursForMonth * $employee->balance;
        }else if ($employee->worktype == 'days'){
            $totalWorkDaysForMonth = EmployeeAttendance::where('employee_id', $request->employee_id)
            ->whereYear('date', $year)
            ->whereMonth('date', $monthstore)
            ->count(); 
            $totalworkDaysForMonth = EmployeeAttendance::where('employee_id', $request->employee_id)
                                                        ->whereYear('date',$year)
                                                        ->whereMonth('date',$monthstore)
                                                        ->count();
            $salary_value = $totalWorkDaysForMonth * $employee->balance;
        }else if ($employee->worktype == 'months'){
            $salary_value = $employee->balance;
        }else if ($employee->worktype == 'Contractor'){
            $salary_value = $employee->balance;
        }
       
        if ($salaryRecord) {
 
            $salaryRecord->update([
                'work_hours' => $totalWorkHoursForMonth,
                'salary_status' => $salaryRecord->salary_status, 
                'salary_value' =>  $salary_value ,
                'advance' => $salaryRecord->advance, 
                'salarypaid_value'=> $salaryRecord->salarypaid_value,
                'salaryremaning_value' => $salary_value - $salaryRecord->salarypaid_value,

            ]);
        } else {
            $salaryStatus = 'unPaid'; 
            $advance = 0; 
            $salarypaid_value=0;
            $slaryremaning_value= 0;
            Salary::create([
                'employee_id' => $request->employee_id,
                'month' => $month,
                'work_hours' => $totalWorkHoursForMonth,
                'salary_value' => $salary_value,
                'salary_status' => $salaryStatus,
                'advance' => $advance,
                'salarypaid_value' => $salarypaid_value,
                'salaryremaning_value' => $salary_value - $salarypaid_value ,
            ]);
        }

        return redirect()->route('attendance.index')->with('success', 'Attendance recorded successfully.');
    }


}
