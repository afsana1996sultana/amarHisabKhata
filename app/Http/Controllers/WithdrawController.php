<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Payment;
use App\Models\Deposit;
use App\Models\Withdraw;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WithdrawController extends Controller
{
    protected $withdraw;

    public function __construct()
    {
        $this->withdraw = new Withdraw();
    }

    public function requestIndex()
    {
        $withdraws = $this->withdraw->where('status', 0)->latest()->get();
        return view('admin.withdrawRequest.index', compact('withdraws'));
    }

    public function index()
    {
        $withdraws = $this->withdraw->where('status', 1)->latest()->get();
        return view('admin.withdraw.index', compact('withdraws'));
    }

    public function create()
    {
        return view('admin.withdraw.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required',
            'purpose' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        $projectIncome = Project::where('is_approve', 1)->sum('advance');
        $paymentIncome = Payment::where('is_approve', 1)->sum('amount');
        $totalIncome = $projectIncome + $paymentIncome;

        $totalDeposit = Deposit::where('status', 1)->sum('amount');
        $totalExpense = Expense::where('is_approve', 1)->sum('amount');
        $totalwithdraw = Withdraw::where('status', 1)->sum('amount');
        $SumOfIncome = $totalIncome + $totalDeposit;
        $SumOfExpense = $totalExpense + $totalwithdraw;
        $Balance = $SumOfIncome - $SumOfExpense;

        if($request->amount <= $Balance){
            $this->withdraw->create([
                'date' => $request->date,
                'amount' => $request->amount,
                'purpose' => $request->purpose,
                'status' => 0,
            ]);

            return redirect()->route('withdraw.request-list')->with([
                'message' => 'Withdraw Created Successfully',
                'alert-type' => 'success'
            ]);
        }else{
            return redirect()->back()->with([
                'message' => 'Withdraw Amount is Insufficent!',
                'alert-type' => 'error'
            ]);
        }
    }

    public function edit($id)
    {
        $withdraw = $this->withdraw->find($id);
        return view('admin.withdrawRequest.edit', compact('withdraw'));
    }


    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'date' => 'required',
                'purpose' => 'required|string|max:255',
                'amount' => 'required|numeric|min:0',
            ]);

            $withdraw = $this->withdraw->find($id);
            if (!$withdraw) {
                return redirect()->back()->withErrors(['error' => 'Withdraw not found.']);
            }

            $projectIncome = Project::where('is_approve', 1)->sum('advance');
            $paymentIncome = Payment::where('is_approve', 1)->sum('amount');
            $totalIncome = $projectIncome + $paymentIncome;

            $totalDeposit = Deposit::where('status', 1)->sum('amount');
            $totalExpense = Expense::where('is_approve', 1)->sum('amount');
            $totalwithdraw = Withdraw::where('status', 1)->sum('amount');
            $SumOfIncome = $totalIncome + $totalDeposit;
            $SumOfExpense = $totalExpense + $totalwithdraw;
            $Balance = $SumOfIncome - $SumOfExpense;

            if($request->amount <= $Balance){
                $withdraw->update([
                    'date' => $request->date,
                    'amount' => $request->amount,
                    'purpose' => $request->purpose,
                ]);

                return redirect()->route('withdraw.request-list')->with([
                    'message' => 'Withdraw Update Successfully',
                    'alert-type' => 'success'
                ]);
            }
            else{
                return redirect()->back()->with([
                    'message' => 'Withdraw Amount is Insufficent!',
                    'alert-type' => 'error'
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()->withInput()->withErrors([
                'error' => 'An error occurred while updating the withdraw. Please try again.'
            ]);
        }
    }

    public function destroy($id)
    {
        $deposit = $this->withdraw->find($id);
        $deposit->delete();
        return redirect()->back();
    }

    public function active($id)
    {
        $deposit = $this->withdraw->find($id);
        $deposit->status = 1;
        $deposit->save();

        return redirect()->route('withdraw.index')->with([
            'message' => 'Withdraw Request Approved Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function inactive($id)
    {
        $deposit = $this->withdraw->find($id);
        $deposit->status = 0;
        $deposit->save();

        return redirect()->back()->with([
            'message' => 'Withdraw Request Pending Successfully',
            'alert-type' => 'success'
        ]);
    }
}
