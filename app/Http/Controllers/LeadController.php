<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Project;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $lead;
    protected $project;
    protected $setting;
    public function __construct()
    {
        $this->lead = new Lead();
        $this->project = new Project();
        $this->setting = new Setting();
    }

    public function index()
    {
        $leads = $this->lead->where('is_customer', '=', 0)->latest()->get();
        return view('admin.leads.index', compact('leads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.leads.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return $request->all();
        $request->validate([
            'lead_name' => 'required|unique:leads,lead_name',
            'lead_phone' => 'required|numeric|digits:11|unique:leads,lead_phone',
            'address' => 'required',
            'priority' => 'required',
        ]);


        $this->lead->create([
            'lead_name' => $request->lead_name,
            'lead_phone' => $request->lead_phone,
            'email' => $request->email,
            'address' => $request->address,
            'priority' => $request->priority,
            'description' => $request->description,
            'is_customer' => 0,
            'status' => 0,
            'created_by' => Auth::user()->id,
        ]);

        return redirect()->route('lead.index')->with([
            'message' => 'Lead Data Created Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $lead = $this->lead->find($id);
        return view('admin.leads.edit', compact('lead'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lead = $this->lead->find($id);
        $request->validate([
            'lead_name' => 'required|unique:leads,lead_name,' . $lead->id,
            'lead_phone' => 'required|numeric|digits:11|unique:leads,lead_phone,' . $lead->id,
            'address' => 'required',
            'priority' => 'required',
        ]);

        $lead->update([
            'lead_name' => $request->lead_name,
            'lead_phone' => $request->lead_phone,
            'email' => $request->email,
            'address' => $request->address,
            'priority' => $request->priority,
            'description' => $request->description,
        ]);

        return redirect()->route('lead.index')->with([
            'message' => 'Lead Data Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lead = $this->lead->find($id);
        $lead->delete();
        return redirect()->back();
    }

    public function statusActive($id)
    {
        $statusChange = $this->lead->find($id);
        $statusChange->status = 1;
        $statusChange->save();

        return redirect()->back()->with([
            'message' => 'Status Changed Successfully!',
            'alert-type' => 'success'
        ]);
    }


    public function statusInactive($id)
    {
        $statusChange = $this->lead->find($id);
        $statusChange->status = 0;
        $statusChange->save();

        return redirect()->back()->with([
            'message' => 'Status Changed Successfully!',
            'alert-type' => 'success'
        ]);
    }

    public function makeCustomer($id)
    {
        $customer = $this->lead->find($id);
        if ($customer->is_customer == 0) {
            $customer->is_customer = 1;
        }
        $customer->save();

        return redirect()->route('lead.index')->with([
            'message' => 'Customer generate successfully!',
            'alert-type' => 'success'
        ]);
    }

    public function customerList()
    {
        $leads = $this->lead->where('is_customer', '=', 1)->latest()->get();
        return view('admin.leads.customer', compact('leads'));
    }

    public function customerDetails($id)
    {
        $setting = $this->setting->first();
        $customer = $this->lead->where('is_customer', '=', 1)->find($id);
        $project = $this->project->where('lead_id', $customer->id)->get();
        return view('admin.leads.customer-details', compact('customer', 'setting', 'project'));
    }

    public function customerEdit(string $id)
    {
        $customer = $this->lead->find($id);
        return view('admin.leads.customerEdit', compact('customer'));
    }

    public function customerUpdate(Request $request, string $id)
    {
        $customer = $this->lead->find($id);
        $request->validate([
            'lead_name' => 'required|unique:leads,lead_name,' . $customer->id,
            'lead_phone' => 'required|numeric|digits:11|unique:leads,lead_phone,' . $customer->id,
            'address' => 'required',
            'priority' => 'required',
        ]);

        $customer->update([
            'lead_name' => $request->lead_name,
            'lead_phone' => $request->lead_phone,
            'email' => $request->email,
            'address' => $request->address,
            'priority' => $request->priority,
            'description' => $request->description,
        ]);

        return redirect()->route('customer.index')->with([
            'message' => 'Customer Updated Successfully',
            'alert-type' => 'success'
        ]);
    }
}
