<?php

namespace App\Http\Controllers;
use App\Models\ExpenseHead;
use Illuminate\Http\Request;

class ExpenseheadController extends Controller
{
    protected $expensehead;
    public function __construct()
    {
        $this->expensehead = new ExpenseHead();
    }

    public function index()
    {
        $expenseheads = $this->expensehead->latest()->get();
        return view('admin.expensehead.index', compact('expenseheads'));
    }

    public function create()
    {
        $expenseheads = $this->expensehead->all();
        return view('admin.expensehead.create', compact('expenseheads'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'status' => 'required',
        ]);

        $slug = strtolower(str_replace(' ', '-', $request->title));
        $this->expensehead->create([
            'title' => $request->title,
            'slug' => $slug,
            'status' => $request->status,
        ]);

        return redirect()->route('expense-head.index')->with([
            'message' => 'Expense Head Created Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function edit(string $id)
    {
        $expenseheads = $this->expensehead->find($id);
        return view('admin.expensehead.edit', compact('expenseheads'));
    }


    public function update(Request $request, string $id)
    {
        $expenseheads = $this->expensehead->find($id);
        $request->validate([
            'title' => 'required',
            'status'=>'required'
        ]);

        $slug = strtolower(str_replace(' ', '-', $request->title));
        $expenseheads->update([
            'title' => $request->title,
            'slug' => $slug,
            'status' => $request->status,
        ]);

        return redirect()->route('expense-head.index')->with([
            'message' => 'Expense Head Updated Successfully',
            'alert-type' => 'success'
        ]);
    }


    public function destroy(string $id)
    {
        $expenseheads = $this->expensehead->find($id);
        $expenseheads->delete();
        return redirect()->route('expense-head.index');
    }


    public function active($id){
        $expenseheads = $this->expensehead->find($id);
        $expenseheads->status = 1;
        $expenseheads->save();

        return redirect()->route('expense-head.index')->with([
            'message' => 'Expense Head Active Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function inactive($id){
        $expenseheads = $this->expensehead->find($id);
        $expenseheads->status = 0;
        $expenseheads->save();

        return redirect()->route('expense-head.index')->with([
            'message' => 'Expense Head Inactive Successfully',
            'alert-type' => 'success'
        ]);
    }

}
