<?php

namespace App\Http\Controllers;
use App\Helper\UploadImage;
use App\Models\ExpenseHead;
use App\Models\ExpenseSubhead;
use App\Models\Expense;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ExpenseController extends Controller
{
    protected $head;
    protected $subHead;
    protected $expense;
    protected $project;
    public function __construct()
    {
        $this->head = new ExpenseHead();
        $this->subHead = new ExpenseSubhead();
        $this->expense = new Expense();
        $this->project = new Project();
    }


    public function index()
    {
        $expenses = $this->expense->with(['expenseHead', 'expenseSubHead'])->latest()->get();
        return view('admin.expense.index', compact('expenses'));
    }

    public function requestIndex()
    {
        $expenses = $this->expense->with(['expenseHead', 'expenseSubHead'])->where('is_approve', 0)->latest()->get();
        return view('admin.expense.indexRequest', compact('expenses'));
    }

    public function create()
    {
        $expenses = $this->expense->latest()->get();
        $heads = $this->head->all();
        $subHeads = $this->subHead->all();
        $projects = $this->project->where('is_approve', 1)->where('status', '=', 0)->latest()->get();
       // return view('admin.expense.create', compact('expenses', 'heads', 'subHeads', 'projects'));

        return view('admin.expense.create-new', compact('expenses', 'heads', 'subHeads', 'projects'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'project_id' => 'required|exists:projects,id',
            'expense_head_id' => 'required|exists:expense_heads,id',
        ]);

        $this->expense->create([
            'project_id' => $request->project_id,
            'expense_head_id' => json_encode($request->expense_head_id),
            'expense_subhead_id' => json_encode($request->expense_subhead_id),
            'amount_head' => json_encode($request->amount_head),
            'quantity' => json_encode($request->quantity),
            'amount' => $request->amount,
            'purpose' => $request->purpose,
            'status' => 0,
            'is_approve' => 0,
            'created_by' => Auth::user()->id,
            'voucher_image' => UploadImage::imageUpload($request->file('voucher_image'), 'backend/assets/images/expenses/'),
        ]);

        return redirect()->route('expense.request.list')->with([
            'message' => 'Expense Created Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function edit(string $id)
    {
        $expenses = $this->expense->find($id);
        $heads = $this->head->all();
        $subHeads = $this->subHead->all();
        $projects = $this->project->where('is_approve', 1)->where('status', '=', 0)->latest()->get();
        return view('admin.expense.edit', compact('expenses', 'heads', 'subHeads', 'projects'));
    }


    public function update(Request $request, string $id)
    {
        $expenses = $this->expense->find($id);
        $this->validate($request, [
            'project_id' => 'required|exists:projects,id',
            'expense_head_id' => 'required',
        ]);

        $expenses->update([
            'project_id' => $request->project_id,
            'expense_head_id' => json_encode($request->expense_head_id),
            'expense_subhead_id' => json_encode($request->expense_subhead_id),
            'amount_head' => json_encode($request->amount_head),
            'quantity' => json_encode($request->quantity),
            'amount' => $request->amount,
            'purpose' => $request->purpose,
            'created_by' => Auth::user()->id,
            'voucher_image' => UploadImage::imageUpload($request->file('voucher_image'), 'backend/assets/images/expenses/', isset($id) ? $expenses->voucher_image : ''),
        ]);

        return redirect()->route('expense.request.list')->with([
            'message' => 'Expense Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function destroy(string $id)
    {
        $expenses = $this->expense->find($id);
        $image = public_path($expenses->voucher_image);
        if (File::exists($image)) {
            File::delete($image);
        }
        $expenses->delete();
        return redirect()->route('expense.request.list');
    }


    public function changeApprove($id)
    {
        $changeApprove = $this->expense->find($id);
        if ($changeApprove->is_approve == 0) {
            $changeApprove->is_approve = 1;
            $changeApprove->status = 1;
        }
        $changeApprove->save();

        return redirect()->route('expense.index')->with([
            'message' => 'Expense Approved Successfully!',
            'alert-type' => 'success'
        ]);
    }


    public function getSubHeads($expense_head_id)
    {
        $subHeads = $this->subHead->where('expense_head_id', $expense_head_id)->get();
        return response()->json(['sub_heads' =>$subHeads]);
    }

}
