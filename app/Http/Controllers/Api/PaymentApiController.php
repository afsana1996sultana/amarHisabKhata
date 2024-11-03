<?php

namespace App\Http\Controllers\Api;

use App\Exports\PaymentsExport;
use App\Helper\UploadImage;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class PaymentApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $payments;
    protected $projects;

    public function __construct()
    {
        $this->projects = new Project();
        $this->payments = new Payment();
    }

    public function index()
    {
        try{
            $user = Auth::user();
            if (!$user)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Only authorised user can access to get this data',
                ], 401);
            }
            $payment = $this->payments->with('project')->latest()->get();
            if (!$payment)
            {
                return response()->json([
                    'status'=>false,
                    'message'=>'Data not found',
                ], 404);
            }



            $totalPaid = 0;
            $calculatedPayments = [];

            foreach ($payment as $index => $pay) {
                $project = $this->projects->find($pay->project_id);
                $paymentPaid = $project->advance ?? 0;

                $paid = $pay->paid;
                $amount = $pay->amount;


                if ($index === $payment->count() - 1) {
                    $totalPaid = $paymentPaid + $amount;
                } else {
                    $totalPaid = $paid + $amount;
                }

                $calculatedPayments[] = [
                    'id' => $pay->id,
                    'project_id' => $pay->project_id,
                    'customer_name' => $pay->customer_name,
                    'customer_phone' => $pay->customer_phone,
                    'project_name' => $pay->project_name,
                    'project_value' => $pay->project_value,
                    'total_paid' => $totalPaid,
                    'current_amount' => $pay->amount,
                    'previous_due' => $pay->due,
                    'current_due' => $pay->next_due,
                    'payment_type' => $pay->payment_type,
                    'payment_proof_image' => $pay->payment_image,
                    'date' => $pay->date,
                    'note' => $pay->note,
                    'status' => $pay->is_approve == 0 ? 'Inactive' : 'Active',
                    'is_approve' => $pay->is_approve == 0 ? 'Not Approved' : 'Approved',
                    'created_by' => $pay->user->name ?? '',
                    'created_at' => $pay->created_at ?? '',
                ];
            }

            return response()->json([
               'status'=>true,
               'payments' =>$calculatedPayments,
            ], 200);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'status'=>false,
                'message'=>'Server Error: ' .$e->getMessage(),
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
                if ($user) {
                    $validator = Validator::make($request->all(), [
                        'project_id' => 'required|exists:projects,id',
                        'payment_type' => 'required',
                        'payment_image' => 'required_if:payment_type,bkash,bank|mimes:jpeg,png,jpg|max:2048',
                        'date' =>'required',
                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            'errors' => $validator->errors(),
                        ], 400);
                    }

                    $project = $this->projects->where('id', $request->project_id)->where('is_approve', 1)->where('status', 0)->first();
                    if ($project) {
                        $currentPaid = $project->paid;
                        $currentDue = $project->project_value - $project->paid;

                        if ($request->amount > $currentDue) {
                            return response()->json([
                                'status' => false,
                                'message' => 'Payment amount exceeds the due amount. Payment amount is not greater than the due... Please enter a valid amount.',
                            ], 400);
                        }

                        $nextDue = $currentDue - $request->amount;
                    }

                    if ($currentDue != 0) {
                        $paymentData = [
                            'project_id' => $project->id,
                            'customer_name' => $project->customer_name,
                            'customer_phone' => $project->customer_phone,
                            'project_name' => $project->project_name,
                            'project_value' => $project->project_value,
                            'paid' => $currentPaid,
                            'due' => $currentDue,
                            'amount' => $request->amount,
                            'next_due' => $nextDue,
                            'payment_type' => $request->payment_type,
                            'date' => $request->date,
                            'note' => $request->note,
                            'created_by' => Auth::user()->id,
                        ];


                        if (in_array($request->payment_type, ['bkash', 'bank']) && $request->hasFile('payment_image')) {

                            $paymentData['payment_image'] = UploadImage::imageUpload($request->file('payment_image'), 'backend/assets/images/payment-images/');
                        }


                        $payment = $this->payments->create($paymentData);


                        $updateProject = $this->projects->find($payment->project_id);
                        $updateProject->paid += $payment->amount;
                        $updateProject->due -= $payment->amount;
                        $updateProject->save();

                        return response()->json([
                            'status' => true,
                            'message' => 'Payment Created Successfully',
                            'payment' => $payment,
                        ], 201);
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'Payment not created as due amount is zero... Please Select another Customer!!',
                        ], 400);
                    }
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Only authorised user can access to create this data',
                    ], 401);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Token'
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


}
