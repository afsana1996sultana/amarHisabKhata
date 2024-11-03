<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExpenseHead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExpenseHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $expenseHead;

    public function __construct()
    {
        $this->expenseHead = new ExpenseHead();
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
            $expenseHead = $this->expenseHead->latest()->get();
            if (!$expenseHead) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Not Found',
                ], 404);
            }
            return response()->json([
                'status' => true,
                'expense_head_list' => $expenseHead,
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
    public function store(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $user = Auth::user();
                if ($user)
                {
                    $validator = Validator::make($request->all(), [
                        'title' => 'required',
                        'status' => 'required',
                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            'errors' => $validator->errors(),
                        ], 400);
                    }
                    $slug = strtolower(str_replace(' ', '-', $request->title));
                    $expenseHead = $this->expenseHead->create([
                        'title' => $request->title,
                        'slug' => $slug,
                        'status' => $request->status,
                    ]);

                    return response()->json([
                        'status' => true,
                        'message' => 'Expense Head data store successfully!',
                        'expense_head' => $expenseHead,
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
            $expenseHead = $this->expenseHead->find($id);

            if (!$expenseHead) {
                return response()->json([
                    'status' => false,
                    'message' => 'Expense Head not found!',
                ], 404);
            }

            return response()->json([
                'status' => true,
                'expense_head' => $expenseHead,
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
    public function update(Request $request, string $id)
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
                    $expenseHead = $this->expenseHead->find($id);

                    if (!$expenseHead) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Expense Head not found!',
                        ], 404);
                    }

                    $expenseHead->title = $request->title;
                    $expenseHead->status = 1;

                    if ($expenseHead->save()) {
                        return response()->json([
                            'status' => true,
                            'message' => 'Expense data updated successfully!',
                            'expense_head' => $expenseHead,
                        ], 200);
                    } else {
                        return response()->json(['error' => 'Failed to update Expense'], 500);
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
                    $expenseHead = $this->expenseHead->find($id);
                    if (!$expenseHead) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Top Up not found!',
                        ], 404);
                    }
                    $expenseHead->delete();

                    return response()->json([
                        'status' => true,
                        'message' => 'Expense head deleted successfully!',
                        'expense_head'=>$expenseHead,
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
            $expenseHead = $this->expenseHead->find($id);
            $expenseHead->status = 1;

            if (!$expenseHead) {
                return response()->json([
                    'status' => false,
                    'message' => 'Expense Head not found!',
                ], 404);
            }

            $expenseHead->save();

            return response()->json([
                'status' => true,
                'message' => 'Expense Head data approved successfully!',
                'expense_head' => $expenseHead,
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
            $expenseHead = $this->expenseHead->find($id);

            if (!$expenseHead) {
                return response()->json([
                    'status' => false,
                    'message' => 'Expense Head not found!',
                ], 404);
            }
            $expenseHead->status = 0;
            $expenseHead->save();

            return response()->json([
                'status' => true,
                'message' => 'Expense Head data pending successfully!',
                'expense_head' => $expenseHead,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
