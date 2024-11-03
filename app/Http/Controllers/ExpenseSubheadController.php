<?php

namespace App\Http\Controllers;

use App\Models\ExpenseHead;
use App\Models\ExpenseSubhead;
use Illuminate\Http\Request;

class ExpenseSubheadController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $head;
    protected $subHead;
    public function __construct()
    {
        $this->head = new ExpenseHead();
        $this->subHead = new ExpenseSubhead();
    }

    public function index()
    {
        $subheads = $this->subHead->latest()->get();
        return view('admin.expense-sub-head.index', compact('subheads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $heads = $this->head->latest()->get();
        return view('admin.expense-sub-head.create', compact('heads'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'expense_head_id' => 'required|exists:expense_heads,id',
            'title' => 'required',
        ]);

        $slug = strtolower(str_replace(' ', '-', $request->title));
        $this->subHead->create([
            'expense_head_id' => $request->expense_head_id,
            'title' => $request->title,
            'slug' => $slug,
            'status' => $request->status,
        ]);

        return redirect()->route('expense-sub-head.index')->with([
            'message' => 'Expense SubHead Created Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $heads = $this->head->latest()->get();
        $subHead = $this->subHead->find($id);
        return view('admin.expense-sub-head.edit', compact('heads', 'subHead'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subheads = $this->subHead->find($id);
        $request->validate([
            'title' => 'required',
            'status' => 'required'
        ]);

        $slug = strtolower(str_replace(' ', '-', $request->title));

        $subheads->Update([
            'expense_head_id' => $request->expense_head_id,
            'title' => $request->title,
            'slug' => $slug,
            'status' => $request->status,
        ]);

        return redirect()->route('expense-sub-head.index')->with([
            'message' => 'Expense Subhead Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subhead = $this->subHead->find($id);
        $subhead->delete();
        return redirect()->route('expense-sub-head.index');
    }


    public function subHeadactive($id)
    {
        $subHead = $this->subHead->find($id);
        $subHead->status = 1;
        $subHead->save();

        return redirect()->route('expense-sub-head.index')->with([
            'message' => 'Expense Subhead Active Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function subHeadinactive($id)
    {
        $subHead = $this->subHead->find($id);
        $subHead->status = 0;
        $subHead->save();

        return redirect()->route('expense-sub-head.index')->with([
            'message' => 'Expense Subhead Inactive Successfully',
            'alert-type' => 'success'
        ]);
    }
}
