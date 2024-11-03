<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExpenseHead;
use App\Models\ExpenseSubhead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExpenseSubHeadController extends Controller
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
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Only authorised user can access to get this data!!!',
                ], 401);
            }
            $subheads = $this->subHead->latest()->with('expenseHead')->get();
            if (!$subheads) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Not Found',
                ], 404);
            }
            $subheadData = [];

            foreach ($subheads as $subhead) {
                $subheadData[] = [
                    'id' => $subhead->id,
                    'title' => $subhead->title,
                    'slug' => $subhead->slug,
                    'status' => $subhead->status,
                    'expense_head' => [
                        'id' => $subhead->expenseHead->id,
                        'name' => $subhead->expenseHead->title,
                    ],
                ];
            }

            return response()->json([
                'status' => true,
                'expense_subhead_list' => $subheadData,
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
                        'expense_head_id' => 'required|exists:expense_heads,id',
                        'title' => 'required',
                        'status' => 'required',
                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            'errors' => $validator->errors(),
                        ], 400);
                    }
                    $slug = strtolower(str_replace(' ', '-', $request->title));
                    $subheads = $this->subHead->create([
                        'expense_head_id' => $request->expense_head_id,
                        'title' => $request->title,
                        'slug' => $slug,
                        'status' => $request->status,
                    ]);

                    $subheads->load('expenseHead');

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Expense Sub Head data store successfully!',
                        'expense_subhead' => [
                            'id' => $subheads->id,
                            'title' => $subheads->title,
                            'slug' => $subheads->slug,
                            'status' => $subheads->status,
                            'expense_head' => [
                                'id' => $subheads->expenseHead->id,
                                'name' => $subheads->expenseHead->title,
                            ]
                        ],
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

            $subHead = $this->subHead->with('expenseHead')->find($id);

            if (!$subHead) {
                return response()->json([
                    'status' => false,
                    'message' => 'Expense Sub Head not found!',
                ], 404);
            }

            return response()->json([
                'status' => true,
                'expense_subhead' => $subHead,
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
                        'title' => 'required',
                        'status' => 'required'
                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            'errors' => $validator->errors(),
                        ], 400);
                    }
                    $subhead = $this->subHead->find($id);

                    if (!$subhead) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Subhead not found!',
                        ], 404);
                    }

                    $slug = strtolower(str_replace(' ', '-', $request->title));

                    $subhead->expense_head_id = $request->expense_head_id;
                    $subhead->title = $request->title;
                    $subhead->slug = $slug;
                    $subhead->status = $request->status;



                    if ($subhead->save()) {
                        return response()->json([
                            'status' => true,
                            'message' => 'Subhead data updated successfully!',
                            'expense_subhead' => $subhead,
                        ], 200);
                    } else {
                        return response()->json(['error' => 'Failed to update Subhead'], 500);
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
                    $subhead = $this->subHead->find($id);

                    if (!$subhead) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Expense Sub Head not found!',
                        ], 404);
                    }

                    $subhead->delete();

                    return response()->json([
                        'status' => true,
                        'message' => 'Expense Sub Head data deleted successfully!',
                        'expense_subhead'=> $subhead,
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
            $subHead = $this->subHead->find($id);
            $subHead->status = 1;

            if (!$subHead) {
                return response()->json([
                    'status' => false,
                    'message' => 'Expense Sub Head not found!',
                ], 404);
            }

            $subHead->save();

            return response()->json([
                'status' => true,
                'message' => 'Expense Sub Head data approved successfully!',
                'expense_subhead' => $subHead,
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
            $subHead = $this->subHead->find($id);


            if (!$subHead) {
                return response()->json([
                    'status' => false,
                    'message' => 'Expense Head not found!',
                ], 404);
            }
            $subHead->status = 0;
            $subHead->save();

            return response()->json([
                'status' => true,
                'message' => 'Expense Head data pending successfully!',
                'expense_subhead' => $subHead,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
