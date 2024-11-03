<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepositRequest;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $deposit;

    public function __construct()
    {
        $this->deposit = new Deposit();
    }

    public function depositRequest()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Only authorised user can access to get this data!!!',
                ], 401);
            }
            $deposits = $this->deposit->where('status', 0)->latest()->get();
            if (!$deposits) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Not Found',
                ], 404);
            }
            return response()->json([
                'status' => true,
                'deposit_request_list' => $deposits,
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
            $deposits = $this->deposit->where('status', 1)->latest()->get();
            if (!$deposits) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Not Found',
                ], 404);
            }
            return response()->json([
                'status' => true,
                'deposit_lists' => $deposits,
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
    public function store(DepositRequest $request)
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
                    $deposit = $this->deposit->create([
                        'date' => $request->date,
                        'amount' => $request->amount,
                        'purpose' => $request->purpose,
                        'status' => 0,
                    ]);

                    return response()->json([
                        'status' => true,
                        'message' => 'Deposit data store successfully!',
                        'deposit' => $deposit,
                    ], 201);
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
            $deposit = $this->deposit->find($id);
            if (!$deposit) {
                return response()->json([
                    'status' => false,
                    'message' => 'Deposit not found!',
                ], 404);
            }

            return response()->json([
                'status' => true,
                'deposit' => $deposit,
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
    public function update(DepositRequest $request, string $id)
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
                    $deposit = $this->deposit->find($id);

                    if (!$deposit) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Deposit not found!',
                        ], 404);
                    }

                    $deposit->date = $request->date;
                    $deposit->amount = $request->amount;
                    $deposit->purpose = $request->purpose;
                    $deposit->status = 0;

                    if (!$deposit->save()) {
                        return response()->json(['error' => 'Failed to update deposit'], 500);
                    }

                    return response()->json([
                        'status' => true,
                        'message' => 'Deposit data update successfully!',
                        'deposit' => $deposit,
                    ], 200);
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
                    $deposit = $this->deposit->find($id);
                    if (!$deposit) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Deposit not found!',
                        ], 404);
                    }

                    $deposit->delete();

                    return response()->json([
                        'status' => true,
                        'message' => 'Deposit data deleted successfully!',
                        'deposit'=>$deposit,
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
            $deposit = $this->deposit->find($id);

            if (!$deposit) {
                return response()->json([
                    'status' => false,
                    'message' => 'Deposit not found!',
                ], 404);
            }
            $deposit->status = 1;
            $deposit->save();

            return response()->json([
                'status' => true,
                'message' => 'Deposit data approved successfully!',
                'deposit' => $deposit,
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
            $deposit = $this->deposit->find($id);
            if (!$deposit) {
                return response()->json([
                    'status' => false,
                    'message' => 'Deposit not found!',
                ], 404);
            }
            $deposit->status = 0;
            $deposit->save();

            return response()->json([
                'status' => true,
                'message' => 'Deposit data pending successfully!',
                'deposit' => $deposit,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
