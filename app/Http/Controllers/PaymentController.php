<?php

namespace App\Http\Controllers;

use App\Helper\UploadImage;
use App\Models\Lead;
use App\Models\Payment;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $payments;
    protected $projects;
    public function __construct()
    {
        $this->payments = new Payment();
        $this->projects = new Project();
    }

    public function index()
    {
        if(Auth::user()->user_role == 1 || in_array('21', json_decode(Auth::user()->staff->role->permissions))) {
            $payments = $this->payments->where('is_approve', 1)->latest()->get();
            return view('admin.payment.index', compact('payments'));
        }
        else{
            return redirect()->back()->with([
                'message' => 'You have no permission to Access the page!!',
                'alert-type' => 'error'
            ]);
        }
    }



    public function requestindex()
    {
        if(Auth::user()->user_role == 1) {
            $payments = $this->payments->where('is_approve', 0)->latest()->get();
            return view('admin.payment.request-index', compact('payments'));
        }
        else{
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
        if(Auth::user()->user_role == 1 || in_array('22', json_decode(Auth::user()->staff->role->permissions))) {
            $projects = $this->projects->where('is_approve', 1)->where('status', 0)->latest()->get();
            return view('admin.payment.create', compact('projects'));
        }
        else{
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
        $request->validate([
            'payment_image' => 'required_if:payment_type,Bkash,Bank|mimes:jpeg,png,jpg|max:2048',
        ]);
        //dd($request->all());
        if ($request->due != 0) {
            $paymentData = [
                'project_id' => $request->project_id,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'project_name' => $request->project_name,
                'project_value' => $request->project_value,
                'paid' => $request->paid,
                'due' => $request->due,
                'amount' => $request->amount,
                'next_due' => $request->next_due,
                'payment_type' => $request->payment_type,
                'date' => $request->date,
                'note' => $request->note,
                'is_approve' => 0,
                'created_by' => Auth::user()->id,
            ];


            if ($request->hasFile('payment_image')) {

                $paymentData['payment_image'] = UploadImage::imageUpload($request->file('payment_image'), 'backend/assets/images/payment-images/');
            }


            $payment = $this->payments->create($paymentData);

            $updateProject = $this->projects->find($payment->project_id);
            $updateProject->paid += $payment->amount;
            $updateProject->due -= $payment->amount;
            $updateProject->save();

            return redirect()->route('payment.request-list')->with([
                'message' => 'Payment Info Created Successfully!',
                'alert-type' => 'success'
            ]);
        } else {
            return redirect()->route('payments.create')->with([
                'message' => 'Payment not created as due amount is zero...Please Select another Customer!!',
                'alert-type' => 'error'
            ]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payment = $this->payments->find($id);
        return view('admin.payment.view', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payment = $this->payments->find($id);
        return view('admin.payment.edit', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payments = $this->payments->findOrFail($id);
          $payments->update([
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'project_name' => $request->project_name,
            'paid' => $request->paid,
            'due' => $request->due,
            'amount' => $request->amount,
            'next_due' => $request->next_due,
            'payment_type' => $request->payment_type,
            'date' => $request->date,
            'note' => $request->note,
        ]);

        return redirect()->route('payments.index')->with([
            'message' => 'Payment Info Updated Successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $payment = $this->payments->find($id);
        $payment->delete();
        return redirect()->route('payments.index');
    }


    /**
     *  get Search Name by Ajax
     */


    public function getProjectPayment($project_name)
    {
        $project = $this->projects->where('project_name', $project_name)->first();

        if ($project) {
            $payment = $this->payments->where('project_id', $project->id)->latest()->first();
            $currentPaid = $project->paid;

            $currentDue = $project->project_value - $project->paid;

//            if ($payment) {
//                $currentPaid = $payment->paid + $payment->amount;
//                $currentDue = $payment->next_due;
//            }
            return response()->json([
                'project_id' => $project->id,
                'customer_name' => $project->customer_name,
                'customer_phone' => $project->customer_phone,
                'project_value' => $project->project_value,
                'advance' => $project->advance,
                'paid' => $currentPaid,
                'due' => $currentDue,
            ]);


        }

        return response()->json([], 404);
    }


    public function changeApprove($id)
    {
        $changeapprove = $this->payments->find($id);
        if ($changeapprove->is_approve == 0)
        {
            $changeapprove->is_approve = 1;
        }
        $changeapprove->save();

        return redirect()->route('payments.index')->with([
            'message' => 'Payment Approved Successfully!',
            'alert-type' => 'success'
        ]);
    }


}
