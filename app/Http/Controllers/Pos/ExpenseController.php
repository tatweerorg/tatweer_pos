<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.expense.index');
        }
    public function category()
    {
        return view('backend.expense.categort_expense');
    }
    public function print()
    {
        return view('backend.expense.print');
    }
    public function report()
    {
        return view('backend.expense.report');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.expense.create');

    }

    public function createcategort()
    {
        return view('backend.expense.create_catogery');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        //
    }
}
