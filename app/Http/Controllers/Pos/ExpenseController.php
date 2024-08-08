<?php

namespace App\Http\Controllers\Pos;

use App\Models\User;

use App\Models\Expense;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ExpenseCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function ExpenseAll(){
        $allData=Expense::with('category')->orderBy('date','desc')->get();
        return view('backend.expense.expense_all',compact('allData'));
    }
   
    public function category()
    {
        $categories  = ExpenseCategory::withCount('expenses')->get();
        return view('backend.expense.categort_expense',compact('categories'));
    }
    public function printList()
    {
        $allData= Expense::with('category')->orderBy('date','desc')->get();
        return view('backend.expense.print_list',compact('allData'));
    }
    public function printExpense($id){
        $expense=Expense::with('category')->FindOrFail($id);
        $createdById= $expense->created_by;
        $creator=User::find($createdById);
        $creatorName=$creator->name;
        return view('backend.pdf.Expense_pdf',compact('expense', 'creatorName'));

    }
    public function report()
    {
        return view('backend.expense.report');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $categories=ExpenseCategory::all();
        return view ('backend.expense.create',compact('categories'));

    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
            'date'=>'required|date',
            'refrence'=>'required|string',
            'amount'=>'required|integer',
            'detials'=>'nullable|string',
            'category_id'=>'nullable|integer|exists:categories,id',
        ]);
        Expense::insert([
            'name'=>$request->name,
            'date'=>$request->date,
            'refrence'=>$request->refrence,
            'amount'=>$request->amount,
            'detials'=>$request->detials,
            'category_id' => $request->category_id,
            'created_at'=>Carbon::now(),
            'created_by' => Auth::user()->id

        ]);
        $notification = array(
            'message'=>'Expense Inserted Successfully',
            'alert-type'=>'success'
        );

        return redirect()->route('expense.all')->with($notification);
    }
    public function createcategory()
    {
        return view('backend.expense.create_catogery');
    }

    public function storecategory(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'nullable|string|max:255'
        ]);
        ExpenseCategory::insert([
            'name'=>$request->name,
            'description'=>$request->description,
            'created_at'=>Carbon::now(),

        ]);

        $notification=array(
            'message'=>'Category Inserted Successfully',
            'alert-type'=>'success'
        );

        return redirect()->route('expense.category')->with($notification);
    }

    public function editcategory($id){
        $category = ExpenseCategory::findOrFail($id);
        return view('backend.expense.edit_category',compact('category'));
    }
    public function updatecategory(Request $request ,$id){
        $request->vaidate([
            'name'=>'required|string|max:255',
            'description'=>'nullable|string|max:255'
        ]);
        $category=ExpenseCategory::findOrFail($id);
        $category ->update([
            'name'=> $request->name,
            'description'=> $request->description,
            'updated_at'=> Corbon::now(),
        ]);
        $notification = array(
            'message' => 'Category Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('expenses.category')->with($notification);
    }
    public function deletecategory($id){
        $category = ExpenseCategory::findOrFail($id);
        $category->delete();
        $notification=array(
            'message'=>'Category Deleted Successfully',
            'alert-type'=>'success',
        );
        return redirect()->route('expense.all')->with($notification);
    }
    /**
     * Store a newly created resource in storage.
     */
    

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
