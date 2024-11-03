<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Payment;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProjectApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $customer;
    protected $project;
    protected $payment;

    public function __construct()
    {
        $this->customer = new Lead();
        $this->project = new Project();
        $this->payment = new Payment();
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
            $project = $this->project->select('id', 'customer_name', 'customer_phone', 'project_name', 'project_value', 'advance','paid', 'due', 'status')->latest()->get();
            if (!$project) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Not Found',
                ], 404);
            }


            $projects = $project->map(function ($current_project) {
                return [
                    'id' => $current_project->id,
                    'customer_name' => $current_project->customer_name,
                    'customer_phone' => $current_project->customer_phone,
                    'project_name' => $current_project->project_name,
                    'project_value' => $current_project->project_value,
                    'advance' => $current_project->advance,
                    'paid' => $current_project->paid,
                    'due' => $current_project->due,
                    'status' => $current_project->status == 0 ? 'Current Project' : '',
                ];
            });

            return response()->json([
                'status' => true,
                'project_lists' => $projects,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function currentProjectList()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Only authorised user can access to get this data!!!',
                ], 401);
            }
            $projects = $this->project->where('is_approve', 1)->where('status', '=', 0)->latest()->get();
            if (!$projects) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Not Found',
                ], 404);
            }


            $current_project_lists = $projects->map(function ($current_project) {
                return [
                    'id' => $current_project->id,
                    'customer_name' => $current_project->customer_name,
                    'customer_phone' => $current_project->customer_phone,
                    'project_name' => $current_project->project_name,
                    'project_value' => $current_project->project_value,
                    'advance' => $current_project->advance,
                    'status' => $current_project->status == 0 ? 'Current Project' : 'Complete Project',
                ];
            });


            return response()->json([
                'status' => true,
                'current_project_lists' => $current_project_lists,
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
                if ($user) {
                    $validator = Validator::make($request->all(), [
                        'lead_id' => 'required|exists:leads,id',
                        'project_name' => 'required|unique:projects,project_name',
                        'project_value' => 'required|numeric',
                        'date'=>'required',
                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            'errors' => $validator->errors(),
                        ], 400);
                    }
                    $customer = $this->customer->where('id', $request->lead_id)->where('is_customer', '=', 1)->first();

                    if (!$customer) {
                        return response()->json([
                            'status' => false,
                            'message' => 'customer not found.'
                        ], 404);
                    }

                    $project = $this->project->create([
                        'lead_id' => $customer->id,
                        'customer_name' => $customer->lead_name,
                        'customer_phone' => $customer->lead_phone,
                        'customer_email' => $customer->email,
                        'address' => $customer->address,
                        'description' => $request->description ?? $customer->description,
                        'project_name' => $request->project_name,
                        'project_value' => $request->project_value,
                        'advance' => $request->advance,
                        'paid' => $request->advance,
                        'due' => $request->project_value - $request->advance,
                        'project_duration' => $request->project_duration,
                        'date' => $request->date,
                        'status' => 0,
                        'is_approve' => 0,
                        'created_by' => $user->name,
                    ]);

                    // Prepare SMS content
                    $sms_body = "Hello {$customer->lead_name}, your project {$request->project_name} has been created successfully on " . env('APP_NAME') . ".
                    See your invoice here: " . route('invoice.download', ['id' => $project->id]);

                    // Format customer and admin phone numbers
                    $phone = $this->formatPhoneNumber($customer->lead_phone);
                    $adminPhone = $this->formatPhoneNumber(Auth::user()->phone);

                    // SMS API credentials
                    $user_id = "108403";
                    $password = "tushar108403";

                    // Prepare SMS API URLs
                    $customer_sms_url = $this->prepareSmsUrl($user_id, $password, $phone, $sms_body);
                    $admin_sms_url = $this->prepareSmsUrl($user_id, $password, $adminPhone, "A new project has been created for {$customer->lead_name} which name is {$request->project_name} on " . env('APP_NAME'));

                    // Send SMS to customer and admin
                    $resultCustomer = $this->sendSms($customer_sms_url);
                    $resultAdmin = $this->sendSms($admin_sms_url);

                    // Check for success status in both SMS responses
                    if ($resultCustomer && $resultCustomer['status'] == 'success' && $resultAdmin && $resultAdmin['status'] == 'success') {
                        return response()->json([
                            'status' => true,
                            'message' => 'Project created and SMS sent successfully.',
                            'project' => $project,
                        ], 201);
                    } else {
                        // Log errors for debugging
                        Log::error('Failed to send SMS', [
                            'customer_sms' => $resultCustomer,
                            'admin_sms' => $resultAdmin
                        ]);

                        return response()->json([
                            'status' => false,
                            'message' => 'Project created but failed to send SMS.',
                        ], 401);
                    }
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Only authorised user can access to create this data!!!',
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


    // Helper function to format phone numbers
    private function formatPhoneNumber($phone)
    {
        if (substr($phone, 0, 3) == "+88") {
            return $phone;
        } elseif (substr($phone, 0, 2) == "88") {
            return '+' . $phone;
        } else {
            return '+88' . $phone;
        }
    }

    // Helper function to prepare SMS URL
    private function prepareSmsUrl($user_id, $password, $phone, $message)
    {
        return "https://sms.rapidsms.xyz/request.php?user_id={$user_id}&password={$password}&number={$phone}&message=" . urlencode($message);
    }

    // Function to send SMS via cURL
    private function sendSms($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        $result = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        if ($error) {
            Log::error("SMS sending failed: {$error}");
            return null;
        }

        return json_decode($result, true);
    }

    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        try {
            $user = Auth::user();

            if ($user) {
                $project = $this->project->find($id);

                if (!$project) {
                    return response()->json([
                        'status' => false,
                        'message' => "Project Data Not Found"
                    ], 404);
                }


                $project_details = [
                    'id' => $project->id,
                    'lead_id' => $project->lead_id,
                    'customer_name' => $project->customer_name,
                    'customer_phone' => $project->customer_phone,
                    'customer_email' => $project->customer_email,
                    'address' => $project->address,
                    'description' => $project->description,
                    'project_name' => $project->project_name,
                    'project_value' => $project->project_value,
                    'advance' => $project->advance,
                    'project_duration' => $project->project_duration,
                    'paid' => $project->paid,
                    'due' => $project->due,
                    'date' => $project->date,
                    'status' => $project->status == 0 ? 'Current Project' : 'Complete Project',
                    'is_approve' => $project->is_approve == 0 ? 'Not Approved' : 'Approved',
                    'created_by' => $project->created_by,
                ];


                $payments = $this->payment->where('project_id', $project->id)->get();

                $totalPaid = $project->advance;
                $calculatedPayments = [];

                foreach ($payments as $payment) {

                    $totalPaid += $payment->amount;

                    $calculatedPayments[] = [
                        'id' => $payment->id,
                        'project_id' => $payment->project_id,
                        'customer_name' => $payment->customer_name,
                        'customer_phone' => $payment->customer_phone,
                        'project_name' => $payment->project_name,
                        'project_value' => $payment->project_value,
                        'total_paid' => $totalPaid,
                        'current_amount' => $payment->amount,
                        'previous_due' => $payment->due,
                        'current_due' => $payment->next_due,
                        'payment_type' => $payment->payment_type,
                        'payment_proof_image' => $payment->payment_image,
                        'date' => $payment->date,
                        'note' => $payment->note,
                        'status' => $payment->is_approve == 0 ? 'Inactive' : 'Active',
                        'is_approve' => $payment->is_approve == 0 ? 'Not Approved' : 'Approved',
                        'created_by' => $payment->user->name ?? '',
                        'created_at' => $payment->created_at ?? '',
                    ];
                }

                return response()->json([
                    'status' => true,
                    'project_detail' => $project_details,
                    'payments' => $calculatedPayments,
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Only authorized users can access this data!',
                ], 401);
            }
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
                if ($user) {

                    $project = $this->project->find($id);
                    if (!$project) {
                        return response()->json([
                            'status' => false,
                            'message' => "Project Data Not Found"
                        ], 404);
                    }

                    $validator = Validator::make($request->all(), [
                        'lead_id' => 'required|exists:leads,id',
                        'project_name' => 'required',
                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            'errors' => $validator->errors(),
                        ], 400);
                    }


                    $customer = $this->customer->where('id', $request->lead_id)->where('is_customer', '=', 1)->first();
                    if (!$customer) {
                        return response()->json([
                            'status' => false,
                            'message' => 'customer(lead_id) not found.'
                        ], 404);
                    }

                    $project->Update([
                        'lead_id' => $customer->id,
                        'customer_name' => $customer->lead_name,
                        'customer_phone' => $customer->lead_phone,
                        'customer_email' => $customer->email,
                        'address' => $customer->address,
                        'description' => $request->description ?? $customer->description,
                        'project_name' => $request->project_name,
                        'project_duration' => $request->project_duration,
                        'date' => $request->date,
                    ]);

                    return response()->json([
                        'status' => true,
                        'message' => "Project Data Updated Successfully",
                        'project' => $project,
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Only authorised user can access to update this data!!!!',
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
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            if ($request->isMethod('delete')) {
                $user = Auth::user();

                if ($user) {
                    $project = $this->project->find($id);
                    if (!$project) {
                        return response()->json([
                            'status' => true,
                            'message' => "Project Data Not Found"
                        ], 404);
                    }

                    $payments = $this->payment->where('project_id', $project->id)->get();
                    foreach ($payments as $payment) {
                        if ($payment) {
                            $payment->delete();
                        }
                    }
                    $project->delete();

                    return response()->json([
                        'status' => true,
                        'message' => "Project Data Deleted Successfully",
                        'project' => $project,
                        'payment' => $payment,
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
}
