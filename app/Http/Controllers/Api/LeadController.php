<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Project;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $lead;
    protected $setting;
    protected $project;
    public function __construct()
    {
        $this->lead = new Lead();
        $this->setting = new Setting();
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
            $leads = $this->lead->where('is_customer', '=', 0)->select('id', 'lead_name','lead_phone', 'email','priority')->latest()->get();

            if (!$leads) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Not found!',
                ], 404);
            }
            return response()->json([
                'status' => true,
                'leadList' => $leads,
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
        //dd('Request', $request->all());
        try {
            if ($request->isMethod('post')) {
                $user = Auth::user();
                if ($user)
                {
                    $validator = Validator::make($request->all(), [
                        'lead_name' => 'required|unique:leads,lead_name',
                        'lead_phone' => 'required|numeric|digits:11|unique:leads,lead_phone',
                        'address' => 'required',
                        'priority' => 'required',
                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            'errors' => $validator->errors(),
                        ], 400);
                    }
                    $lead = $this->lead->create([
                        'lead_name' => $request->lead_name,
                        'lead_phone' => $request->lead_phone,
                        'email' => $request->email,
                        'address' => $request->address,
                        'priority' => $request->priority,
                        'description' => $request->description,
                        'is_customer' => 0,
                        'status' => 0,
                        'created_by' => $user->name,
                    ]);

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Lead data store successfully!',
                        'lead' => $lead,
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
    public function show($id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Only authorised user can access to get this data!!!',
                ], 401);
            }
            //$lead = $this->lead->with('created_by')->find($id);
            $lead = $this->lead->find($id);

            if (!$lead) {
                return response()->json([
                    'status' => false,
                    'message' => 'Lead not found!',
                ], 404);
            }

            return response()->json([
                'status' => true,
                'leadDetails' => $lead,
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
                    $lead = $this->lead->find($id);
                    $validator = Validator::make($request->all(), [
                        'lead_name' => 'required|unique:leads,lead_name,' . $lead->id,
                        'lead_phone' => 'required|numeric|digits:11|unique:leads,lead_phone,' . $lead->id,
                        'address' => 'required',
                        'priority' => 'required',
                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            'errors' => $validator->errors(),
                        ], 400);
                    }
                    $lead = $this->lead->find($id);

                    if (!$lead) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Lead not found',
                        ], 404);
                    }

                    $lead->update([
                        'lead_name' => $request->lead_name,
                        'lead_phone' => $request->lead_phone,
                        'email' => $request->email,
                        'address' => $request->address,
                        'priority' => $request->priority,
                        'description' => $request->description,
                        'created_by' => $user->name,
                    ]);

                    return response()->json([
                        'status' => true,
                        'message' => 'Lead data Update successfully!',
                        'lead' => $lead,
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
    public function destroy(Request $request,string $id)
    {
        try {
            if ($request->isMethod('delete')) {
                $user = Auth::user();

                if ($user) {
                    $lead = $this->lead->find($id);
                    if (!$lead) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Lead not found!',
                        ], 404);
                    }
                    $lead->delete();

                    return response()->json([
                        'status' => true,
                        'message' => 'Lead data deleted successfully!',
                        'lead' => $lead,
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
            $lead = $this->lead->find($id);

            if (!$lead) {
                return response()->json([
                    'status' => false,
                    'message' => 'Lead not found',
                ], 404);
            }

            $lead->status = 1;
            $lead->save();

            return response()->json([
                'status' => true,
                'message' => 'Customer Approved successfully!',
                'lead' => $lead,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

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
            $lead = $this->lead->find($id);

            if (!$lead) {
                return response()->json([
                    'status' => false,
                    'message' => 'Lead not found',
                ], 404);
            }

            $lead->status = 0;
            $lead->save();

            return response()->json([
                'status' => true,
                'message' => 'Customer pending successfully!',
                'lead' => $lead,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function makeCustomer($id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Only authorised user can access to get this data!!!',
                ], 401);
            }
            $customer = $this->lead->find($id);

            if (!$customer) {
                return response()->json([
                    'status' => false,
                    'message' => 'Lead not found',
                ], 404);
            }

            if ($customer->is_customer == 0) {
                $customer->is_customer = 1;
            }

            $customer->save();

            return response()->json([
                'status' => true,
                'message' => 'Customer generate successfully!',
                'customer' => $customer,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function customerList()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Only authorised user can access to get this data!!!',
                ], 401);
            }
            $leads = $this->lead->where('is_customer', '=', 1)->select('id', 'lead_name', 'lead_phone')->latest()->get();

            if (!$leads) {
                return response()->json([
                    'status' => false,
                    'message' => 'Customer not found',
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Leads data fetch successfully!',
                'customers' => $leads,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function customerDetails($id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Only authorised user can access to get this data!!!',
                ], 401);
            }

            $customer = $this->lead->where('is_customer', '=', 1)->with('project')->find($id);
            //dd('Customer Details', $customer);
            if (!$customer) {
                return response()->json([
                    'status' => false,
                    'message' => 'Customer Data Not Found'
                ], 404);
            }


            return response()->json([
                'status' => true,
                'customer' => $customer,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

}
