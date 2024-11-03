<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Lead;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Setting;
//use Barryvdh\DomPDF\Facade\Pdf;
use Cassandra\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $project;
    protected $customer;
    protected $payment;
    protected $setting;
    public function __construct()
    {
        $this->project = new Project();
        $this->customer = new Lead();
        $this->payment = new Payment();
        $this->setting = new Setting();
    }


    public function index()
    {
        if (Auth::user()->user_role == 1 || in_array('17', json_decode(Auth::user()->staff->role->permissions))) {
            $projects = $this->project->latest()->get();
            return view('admin.project.index', compact('projects'));
        } else {
            return redirect()->back()->with([
                'message' => 'You have no permission to Access the page!!',
                'alert-type' => 'error'
            ]);
        }
    }

    public function requestindex()
    {
        if (Auth::user()->user_role == 1) {
            $projects = $this->project->where('is_approve', 0)->latest()->get();
            return view('admin.project.request-index', compact('projects'));
        } else {
            return redirect()->back()->with([
                'message' => 'You have no permission to Access the page!!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->user_role == 1 || in_array('18', json_decode(Auth::user()->staff->role->permissions))) {
            $customers = $this->customer->where('is_customer', '=', 1)->latest()->get();
            return view('admin.project.create', compact('customers'));
        } else {
            return redirect()->back()->with([
                'message' => 'You have no permission to Access the page!!',
                'alert-type' => 'error'
            ]);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|numeric|digits:11',
            'customer_email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'project_name' => 'required|unique:projects,project_name',
            'project_value' => 'required|numeric',
            'advance' => 'nullable|numeric',
            'project_duration' => 'nullable|string|max:50',
            'date' => 'nullable|date',
        ]);

        // Create the project
        $project = $this->project->create([
            'lead_id' => $request->lead_id,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'address' => $request->address,
            'description' => $request->description,
            'project_name' => $request->project_name,
            'project_value' => $request->project_value,
            'advance' => $request->advance,
            'paid' => $request->advance,
            'due' => $request->project_value - $request->advance,
            'project_duration' => $request->project_duration,
            'date' => $request->date,
            'status' => 0,
            'is_approve' => 0,
            'created_by' => Auth::user()->id,
        ]);

        // Prepare SMS content
        $sms_body = "Hello {$request->customer_name}, your project {$request->project_name} has been created successfully on " . env('APP_NAME') . ".
        See your invoice here: " . route('invoice.download', ['id' => $project->id]);

        // Format customer and admin phone numbers
        $phone = $this->formatPhoneNumber($request->customer_phone);
        $adminPhone = $this->formatPhoneNumber(Auth::user()->phone);

        // SMS API credentials
        $user_id = "108403";
        $password = "tushar108403";

        // Prepare SMS API URLs
        $customer_sms_url = $this->prepareSmsUrl($user_id, $password, $phone, $sms_body);
        $admin_sms_url = $this->prepareSmsUrl($user_id, $password, $adminPhone, "A new project has been created for {$request->customer_name} which name is {$request->project_name} on " .  env('APP_NAME'));

        // Send SMS to customer and admin
        $resultCustomer = $this->sendSms($customer_sms_url);
        $resultAdmin = $this->sendSms($admin_sms_url);

        // Check for success status in both SMS responses
        if ($resultCustomer && $resultCustomer['status'] == 'success' && $resultAdmin && $resultAdmin['status'] == 'success') {
            return redirect()->route('project.index')->with([
                'message' => 'Project created and SMS sent successfully.',
                'alert-type' => 'success'
            ]);
        } else {
            // Log errors for debugging
            Log::error('Failed to send SMS', [
                'customer_sms' => $resultCustomer,
                'admin_sms' => $resultAdmin
            ]);

            return redirect()->route('project.index')->with([
                'message' => 'Project created but failed to send SMS.',
                'alert-type' => 'error'
            ]);
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
        $setting = $this->setting->first();
        $project = $this->project->find($id);
        $payment = $this->payment->where('project_id', $project->id)->get();
        return view('admin.project.show', compact('project', 'setting', 'payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Auth::user()->user_role == 1 || in_array('19', json_decode(Auth::user()->staff->role->permissions))) {
            $project = $this->project->find($id);
            $customers = $this->customer->where('is_customer', '=', 1)->latest()->get();
            return view('admin.project.edit', compact('project', 'customers'));
        } else {
            return redirect()->back()->with([
                'message' => 'You have no permission to Access the page!!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $projects = $this->project->find($id);
        $request->validate([
            'customer_name' => 'required',
            'customer_phone' => 'required|numeric|digits:11',
            'project_name' => 'required|unique:projects,project_name,' . $projects->id,
        ]);

        $projects->update([
            'lead_id' => $request->lead_id,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'address' => $request->address,
            'description' => $request->description,
            'project_name' => $request->project_name,
            'project_duration' => $request->project_duration,
            'date' => $request->date,
        ]);
        return redirect()->route('project.index')->with([
            'message' => 'Project Data Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function delete(string $id)
    {
        if (Auth::user()->user_role == 1 || in_array('20', json_decode(Auth::user()->staff->role->permissions))) {
            $project = $this->project->find($id);
            $payments = $this->payment->where('project_id', $project->id)->get();
            foreach ($payments as $payment)
            {
                if ($payment)
                {
                    $payment->delete();
                }
            }
            $project->delete();
            return redirect()->route('project.index');
        } else {
            return redirect()->back()->with([
                'message' => 'You have no permission to Access the page!!',
                'alert-type' => 'error'
            ]);
        }
    }

    public function getCustomerInfo($customer_name)
    {
        $customer = $this->customer->where('lead_name', $customer_name)->where('is_customer', '=', 1)->latest()->first();
            return response()->json([
                'lead_id' => $customer->id,
                'customer_name' => $customer->lead_name,
                'customer_phone' =>  $customer->lead_phone,
                'customer_email' => $customer->email,
                'address' => $customer->address,
                'description' => $customer->description,
            ]);

    }

    public function changeStatus($id)
    {
        $statusChange = $this->project->find($id);
        if ($statusChange->status == 0) {
            $statusChange->status = 1;
        }
        $statusChange->save();

        return redirect()->route('project.index')->with([
            'message' => 'Project Status Changed Successfully!',
            'alert-type' => 'success'
        ]);
    }

    public function changeApprove($id)
    {
        $changeApprove = $this->project->find($id);
        if ($changeApprove->is_approve == 0) {
            $changeApprove->is_approve = 1;
        }
        $changeApprove->save();

        return redirect()->route('project.index')->with([
            'message' => 'Project Approved Successfully!',
            'alert-type' => 'success'
        ]);
    }

    public function invoice_download($id)
    {
        $project = $this->project->findOrFail($id);
        $pdf = PDF::loadView('admin.project.invoice', compact('project'))->setPaper('a4');
        //dd('PDF Download', $pdf);
        return $pdf->download('invoice.pdf');
    }
}
