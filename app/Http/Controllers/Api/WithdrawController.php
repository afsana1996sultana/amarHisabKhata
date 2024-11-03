<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WithdrawRequest;
use App\Models\Project;
use App\Models\Payment;
use App\Models\Deposit;
use App\Models\Withdraw;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $withdraw;

    public function __construct()
    {
        $this->withdraw = new Withdraw();
    }

    public function withdrawRequest()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Only authorised user can access to get this data!!!',
                ], 401);
            }
            $withdraws = $this->withdraw->where('status', 0)->latest()->get();
            if (!$withdraws) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Not Found',
                ], 404);
            }
            return response()->json([
                'status' => true,
                'withdraw_request_lists' => $withdraws,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Only authorised user can access to get this data!!!',
                ], 401);
            }
            $withdraws = $this->withdraw->where('status', 1)->latest()->get();
            if (!$withdraws) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Not Found',
                ], 404);
            }
            return response()->json([
                'status' => true,
                'withdraw_lists' => $withdraws,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(WithdrawRequest $request)
    {
        try {
            if ($request->isMethod('post')) {
                $user = Auth::user();
                if ($user)
                {
                    $validator = Validator::make($request->all(), [
                        'date'=>'required',
                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            'errors' => $validator->errors(),
                        ], 400);
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
                        $withdraw = $this->withdraw->create([
                            'date' => $request->date,
                            'amount' => $request->amount,
                            'purpose' => $request->purpose,
                            'status' => 0,
                        ]);

                        return response()->json([
                            'status' => true,
                            'message' => 'Withdraw data store successfully!',
                            'withdraw' => $withdraw,
                        ], 201);
                    }
                    else{
                        return response()->json([
                            'status' => false,
                            'message' => 'Withdraw Amount is Insufficent!',
                        ], 401);
                    }
                }
                else {
                    return response()->json([
                        'status'=>false,
                        'message'=>'Only authorised user can access to create this data!!!',
                    ], 401);
                }

            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Invalid Token",
                ], 405);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Only authorised user can access to get this data!!!',
                ], 401);
            }
            $withdraw = $this->withdraw->find($id);
            if (!$withdraw) {
                return response()->json([
                    'status' => false,
                    'message' => 'Withdraw not found!',
                ], 404);
            }

            return response()->json([
                'status' => true,
                'withdraw' => $withdraw,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(WithdrawRequest $request, string $id)
    {
        try {
            if ($request->isMethod('put')) {
                $user = Auth::user();
                if ($user)
                {
                    $validator = Validator::make($request->all(), [

                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            'errors' => $validator->errors(),
                        ], 400);
                    }
                    $withdraw = $this->withdraw->find($id);

                    if (!$withdraw) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Withdraw not found!',
                        ], 404);
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
                        $withdraw->date = $request->date;
                        $withdraw->amount = $request->amount;
                        $withdraw->purpose = $request->purpose;

                        if (!$withdraw->save()) {
                            return response()->json(['error' => 'Failed to update withdraw'], 500);
                        }

                        return response()->json([
                            'status' => true,
                            'message' => 'Withdraw data update successfully!',
                            'withdraw' => $withdraw,
                        ], 200);
                    }
                    else{
                        return response()->json([
                            'status' => false,
                            'message' => 'Withdraw Amount is Insufficent!',
                        ], 401);
                    }
                }
                else {
                    return response()->json([
                        'status'=>false,
                        'message'=>'Only authorised user can access to Update this data!!!',
                    ], 401);
                }

            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Invalid Token",
                ], 405);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            if ($request->isMethod('delete')) {
                $user = Auth::user();

                if ($user) {
                    $withdraw = $this->withdraw->find($id);
                    if (!$withdraw) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Withdraw not found!',
                        ], 404);
                    }

                    $withdraw->delete();
                    return response()->json([
                        'status' => true,
                        'message' => 'Withdraw data deleted successfully!',
                        'withdraw'=> $withdraw,
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Only authorised user can access to delete this data!!!!',
                    ], 401);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Invalid HTTP Method",
                ], 405);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Approved the specified resource from storage.
     */
    public function active($id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Only authorised user can access to get this data!!!',
                ], 401);
            }
            $withdraw = $this->withdraw->find($id);
            $withdraw->status = 1;

            if (!$withdraw) {
                return response()->json([
                    'status' => false,
                    'message' => 'Withdraw not found!',
                ], 404);
            }

            $withdraw->save();

            return response()->json([
                'status' => true,
                'message' => 'Withdraw data approved successfully!',
                'withdraw' => $withdraw,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Pending the specified resource from storage.
     */
    public function inactive($id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Only authorised user can access to get this data!!!',
                ], 401);
            }
            $withdraw = $this->withdraw->find($id);
            if (!$withdraw) {
                return response()->json([
                    'status' => false,
                    'message' => 'Withdraw not found!',
                ], 404);
            }
            $withdraw->status = 0;
            $withdraw->save();

            return response()->json([
                'status' => true,
                'message' => 'Withdraw data pending successfully!',
                'withdraw' => $withdraw,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
