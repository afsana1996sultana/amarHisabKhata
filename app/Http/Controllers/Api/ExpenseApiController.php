<?php

namespace App\Http\Controllers\Api;

use App\Helper\UploadImage;
use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseHead;
use App\Models\ExpenseSubhead;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ExpenseApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $expense;
    protected $ex_head;
    protected $ex_subhead;
    protected $project;
    public function __construct()
    {
        $this->expense = new Expense();
        $this->ex_head = new ExpenseHead();
        $this->ex_subhead = new ExpenseSubhead();
        $this->project = new Project();
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
            $expenses = $this->expense->latest()->get();
            if (!$expenses)
            {
                return response()->json([
                    'status'=> false,
                    'message'=> 'Not Found'
                ], 404);
            }
            $expenseList = $expenses->map(function ($expense) {
                $expenseHeads = json_decode($expense->expense_head_id, true) ?? [];
                $expenseSubHeads = json_decode($expense->expense_subhead_id, true) ?? [];
                $amountHeads = json_decode($expense->amount_head, true) ?? [];
                $quantities = json_decode($expense->quantity, true) ?? [];

                $expenseHeadTitles = implode(', ', array_map(function ($head) {
                    return $this->ex_head->find($head)?->title ?? 'N/A';
            }, $expenseHeads));

                $expenseSubheadTitles = implode(', ', array_map(function ($subhead) {
                    return $this->ex_subhead->find($subhead)?->title ?? 'N/A';
            }, $expenseSubHeads));

                return [
                    'id' => $expense->id,
                    'project_name' => $expense->project->project_name ?? '',
                    'total_amount' => $expense->amount ?? '',
                    'status' => $expense->status == 0 ? 'Inactive' : 'Active',
                    'is_approve' => $expense->is_approve == 0 ? 'Not Approve' : 'Approved',
                ];
            });

            return response()->json([
                'status' => true,
                'expenseList' => $expenseList,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function requestIndex()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Only authorised user can access to get this data!!!',
                ], 401);
            }
            $expenses = $this->expense->where('is_approve', '=', 0)->latest()->get();
            if (!$expenses)
            {
                return response()->json([
                    'status'=> false,
                    'message'=> 'Not Found'
                ], 404);
            }
            $expenseList = $expenses->map(function ($expense) {
                $expenseHeads = json_decode($expense->expense_head_id, true) ?? [];
                $expenseSubHeads = json_decode($expense->expense_subhead_id, true) ?? [];
                $amountHeads = json_decode($expense->amount_head, true) ?? [];
                $quantities = json_decode($expense->quantity, true) ?? [];

                $expenseHeadTitles = implode(', ', array_map(function ($head) {
                    return $this->ex_head->find($head)?->title ?? 'N/A';
            }, $expenseHeads));

                $expenseSubheadTitles = implode(', ', array_map(function ($subhead) {
                    return $this->ex_subhead->find($subhead)?->title ?? 'N/A';
            }, $expenseSubHeads));

                return [
                    'id' => $expense->id,
                    'project_name' => $expense->project->project_name ?? '',
                    'expense_head' => $expenseHeadTitles,
                    'expense_subhead' => $expenseSubheadTitles,
                    'amount_head' => implode(', ', $amountHeads),
                    'quantity' => implode(', ', $quantities),
                    'total_amount' => $expense->amount ?? '',
                    'status' => $expense->status == 0 ? 'Inactive' : 'Active',
                    'is_approve' => $expense->is_approve == 0 ? 'Not Approve' : 'Approved',
                ];
            });

            return response()->json([
                'status' => true,
                'expenseList' => $expenseList,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server: ' . $e->getMessage(),
            ], 500);
        }
    }



    public function approveExpense($id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Only authorised user can access to get this data!!!',
                ], 401);
            }

            $expense = $this->expense->where('is_approve', '=', 0)->find($id);
            if (!$expense)
            {
                return response()->json([
                    'status'=> false,
                    'message'=> 'Not Found'
                ], 404);
            }
            if ($expense->is_approve == 0)
            {
                $expense->is_approve = 1;
                $expense->status = 1;
            }
            $expense->save();

            return response()->json([
                'status' => true,
                'message' => 'Expense Approved Successfully!!',
                'expense' => $expense,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        try {
            if ($request->isMethod('post'))
            {
                $user = Auth::user();
                if ($user)
                {
                    $validator = Validator::make($request->all(), [
                        'project_id' => 'required|exists:projects,id',
                        'expense_head_id' => 'required|exists:expense_heads,id',
                        'amount_head' => 'required|array',
                        'quantity' => 'required|array',

                    ]);


                    if ($validator->fails()) {
                        return response()->json([
                            'errors' => $validator->errors()
                        ], 422);
                    }


                    $project = $this->project->find($request->project_id);
                    if (($project->status != 0) || ($project->is_approve != 1)) {
                        return response()->json([
                            'message' => 'The project status is Completed Or Not approved. Please check project status or approval. Otherwise no new expense is created for this project!'
                        ], 403);
                    }

                    $amountHead = $request->amount_head;
                    $quantity = $request->quantity;

                    $totalAmount = 0;
                    foreach ($amountHead as $index => $amount) {
                        $numericAmount = (float) $amount;
                        $numericQuantity = (float) $quantity[$index];

                        $totalAmount += $numericAmount * $numericQuantity;
                    }


                    $voucherImage = $request->hasFile('voucher_image')
                        ? UploadImage::imageUpload($request->file('voucher_image'), 'backend/assets/images/expenses/')
                        : null;


                    $expense = $this->expense->create([
                        'project_id' => $project->id,
                        'expense_head_id' => json_encode($request->expense_head_id),
                        'expense_subhead_id' => json_encode($request->expense_subhead_id),
                        'amount_head' => json_encode($amountHead),
                        'quantity' => json_encode($quantity),
                        'amount' => $totalAmount,
                        'purpose' => $request->purpose,
                        'status' => 0,
                        'is_approve' => 0,
                        'created_by' => Auth::user()->id,
                        'voucher_image' => $voucherImage,
                    ]);


                    return response()->json([
                        'message' => 'Expense created successfully',
                        'expense' => $expense,
                    ], 201);
                }
                else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Only authorised user can access to create this data!!!',
                    ], 401);
                }

            }
            else {
                return response()->json([
                   'status' => false,
                   'message'=> 'Invalid token'
                ], 405);
            }
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error creating expense',
                'error' => $e->getMessage()
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
            if ($user)
            {
                $expense = $this->expense->find($id);

                if (!$expense)
                {
                    return response()->json([
                        'status'=> false,
                        'message' => 'Expense Not Found'
                    ], 404);
                }

                $expenseHeads = json_decode($expense->expense_head_id, true) ?? [];
                $expenseSubHeads = json_decode($expense->expense_subhead_id, true) ?? [];
                $amountHeads = json_decode($expense->amount_head, true) ?? [];
                $quantities = json_decode($expense->quantity, true) ?? [];


                // Build expense details list
                $expense_details_list = [];
                foreach ($expenseHeads as $index => $head) {
                    $expenseSubHead = $expenseSubHeads[$index] ?? null;
                    $amountHead = $amountHeads[$index] ?? null;
                    $quantity = $quantities[$index] ?? null;

                    if ($head && $expenseSubHead && $amountHead && $quantity) {
                        $expenseHeadDetails = $this->ex_head->find($head);
                        $expenseSubHeadDetails = $this->ex_subhead->find($expenseSubHead);

                        if ($expenseHeadDetails && $expenseSubHeadDetails) {
                            $expense_details_list[] = [
                                'expense_head' => $expenseHeadDetails->title,
                                'expense_subhead' => $expenseSubHeadDetails->title,
                                'amount_head' => (int) $amountHead,
                                'quantity' => (int) $quantity,
                            ];
                        }
                    }
                }

                $expense_details = [
                    'id' => $expense->id,
                    'project_id' => (int) $expense->project_id ?? '',
                    'expense_details_list' => $expense_details_list ?? '',
                    'total_amount' => $expense->amount ?? '',
                    'voucher_image' => $expense->voucher_image ?? '',
                    'purpose' => $expense->purpose ?? '',
                    'status' => $expense->status == 0 ? 'Inactive' : 'Active',
                    'is_approved' => $expense->is_approve == 0 ? 'Not Approved' : 'Approved',
                    'created_by' => $expense->createdBy->name,
                    'project' => $expense->project->project_name ?? '',
                ];

                return response()->json([
                    'status' => true,
                    'expense_details' => $expense_details,
                ], 200);
            }
            else {
                return response()->json([
                    'status' => false,
                    'message' => 'Only authorised user can access to get this data!!!',
                ], 401);
            }
        }
        catch(\Exception $e)
        {
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
            if ($request->isMethod('put'))
            {
                $user = Auth::user();
                if ($user)
                {
                    $expense = $this->expense->where('is_approve', '=', 0)->find($id);

                    if (!$expense)
                    {
                        return response()->json([
                            'status' => false,
                            'message'=>'Expense Not Found'
                        ], 404);
                    }

                    $validator = Validator::make($request->all(), [
                        'project_id' => 'required|exists:projects,id',
                        'expense_head_id' => 'required',
                        'amount_head' => 'required|array',
                        'quantity' => 'required|array',

                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            'errors' => $validator->errors()
                        ], 422);
                    }


                    $project = $this->project->find($request->project_id);
                    if (($project->status != 0) || ($project->is_approve != 1)) {
                        return response()->json([
                            'message' => 'The project status is Completed Or Not approved. Please check project status or approval. Otherwise no new expense is created for this project!'
                        ], 403);
                    }


                    $amountHead = $request->amount_head;
                    $quantity = $request->quantity;

                    $totalAmount = 0;
                    foreach ($amountHead as $index => $amount) {
                        $numericAmount = (float) $amount;
                        $numericQuantity = (float) $quantity[$index];

                        $totalAmount += $numericAmount * $numericQuantity;
                    }



                    $expense->update([
                        'project_id' => $project->id,
                        'expense_head_id' => json_encode($request->expense_head_id),
                        'expense_subhead_id' => json_encode($request->expense_subhead_id),
                        'amount_head' => json_encode($amountHead),
                        'quantity' => json_encode($quantity),
                        'amount' => $totalAmount,
                        'purpose' => $request->purpose,
                        'created_by' => Auth::user()->id,
                        'voucher_image' => UploadImage::imageUpload($request->file('voucher_image'), 'backend/assets/images/expenses/', isset($id) ? $expense->voucher_image : '')
                    ]);


                    return response()->json([
                        'message' => 'Expense Updated successfully',
                        'expense' => $expense,
                    ], 200);
                }
                else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Only authorised user can access to update this data!!!',
                    ], 401);
                }

            }
            else {
                return response()->json([
                    'status' => false,
                    'message'=> 'Invalid Method'
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
            if ($request->isMethod('delete'))
            {
                $user = Auth::user();
                if ($user)
                {
                    $expense = $this->expense->find($id);
                    if (!$expense)
                    {
                        return response()->json([
                            'status'=>false,
                            'message'=> 'Expense Not Found',
                        ], 404);
                    }

                    $voucher_image = public_path($expense->voucher_image);
                    if (File::exists($voucher_image))
                    {
                        File::delete($voucher_image);
                    }

                    $expense->delete();
                    return response()->json([
                        'status'=> true,
                        'message' => 'Expense Deleted Successfully',
                        'expense' => $expense,
                    ], 200);

                }
                else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Only authorised user can access to delete this data!!!',
                    ], 401);
                }
            }
            else {
                return response()->json([
                    'status' => false,
                    'message'=>'Invalid Method Called',
                ], 405);
            }
        }
        catch (\Exception $e)
        {
            return response()->json([
                'status' => false,
                'message'=> 'Server Error: ' .$e->getMessage(),
            ], 500);
        }
    }
}
