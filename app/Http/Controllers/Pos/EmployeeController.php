<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allData = Employee::get();

        return view(
        'backend.employee.index', compact('allData'));

    }
    public function create()
    {
        return view('backend.employee.create');
    }

    // Store a newly created employee in storage
    public function store(Request $request)
    {
        $employee = new Employee();
        $employee->name = $request->name;
        $employee->balance = $request->balance;
        $employee->worktype = $request->worktype;
        $employee->startdate = $request->startdate;
        $employee->jobtype = $request->jobtype;
        $employee->save();

        return redirect()->route('employee.index')->with('success', 'Employee added successfully');
    }

    // Show the form for editing the specified employee
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('backend.employee.edit', compact('employee'));
    }

    // Update the specified employee in storage
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->name = $request->name;
        $employee->balance = $request->balance;
        $employee->worktype = $request->worktype;
        $employee->startdate = $request->startdate;
        $employee->jobtype = $request->jobtype;
        $employee->save();

        return redirect()->route('employee.index')->with('success', 'Employee updated successfully');
    }

    // Remove the specified employee from storage
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('employee.index')->with('success', 'Employee deleted successfully');
    }

    public function salare()
    {
        $allData = Employee::all();

        // Calculate the sum of all balances
        $totalBalance = Employee::sum('balance');
        $balancesByWorktype = Employee::select('worktype', \DB::raw('SUM(balance) as total_balance'))
        ->groupBy('worktype')
        ->get();

        // Pass data to the view
        return view( 'backend.employee.salares', compact('allData',
        'totalBalance', 'balancesByWorktype'));
    }
    public function presenceabsence()
    {
        return view('backend.employee.presenceabsence');
    }
    public function report()
    {
        return view('backend.employee.report');
    }

  
    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

  
}
