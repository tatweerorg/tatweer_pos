<?php

namespace App\Http\Controllers\pos;

use App\Http\Controllers\Controller;

use App\Models\Salary;
use Illuminate\Http\Request;
use App\Models\Employee;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
 

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // التحقق من وجود الموظف
        $employee = Employee::findOrFail($id);

        // جلب تفاصيل الرواتب الخاصة بالموظف
        $salaryDetails = Salary::where('employee_id', $id)->get();

        // عرض الصفحة مع تمرير بيانات الموظف وتفاصيل الراتب
        return view('backend.employee.employeesalary', [
            'salaryDetails' => $salaryDetails,
            'employeeId' => $id
        ]);
    }

    /**
     * تسجيل سلفة جديدة.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'advance_amount' => 'required|numeric',
            'advance_month' => 'required|date_format:Y-m',
        ]);

        // إنشاء سجل سلفة جديدة
        Salary::create([
            'employee_id' => $request->input('employee_id'),
            'month' => $request->input('advance_month'),
            'work_hours' => 0, // يمكن تعديل هذه القيمة إذا لزم الأمر
            'advance' => $request->input('advance_amount'),
            'salary_status' => 'Partial', // يمكن تغيير الحالة وفقًا للمتطلبات
        ]);

        // إعادة توجيه إلى الصفحة السابقة مع رسالة نجاح
        return redirect()->back()->with('success', 'تم تسجيل السلفة بنجاح.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salary $salary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Salary $salary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salary $salary)
    {
        //
    }
}
