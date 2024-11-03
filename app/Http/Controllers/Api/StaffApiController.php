<?php

namespace App\Http\Controllers\Api;

use App\Helper\UploadImage;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class StaffApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $user;
    protected $staff;
    protected $project;
    public function __construct()
    {
        $this->user = new User();
        $this->staff = new Staff();
        $this->project = new Project();
    }


    public function index()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Only authorised user can access to get this data!!!!',
                ], 401);
            }

            $staff = $this->staff->with(['user', 'role'])->latest()->get();

            if ($staff->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Not Found',
                ], 404);
            }

            $staffList = $staff->map(function ($staffMember) {
                return [
                    'id' => $staffMember->id,
                    'name' => $staffMember->user->name,
                    'email' => $staffMember->user->email,
                    'phone' => $staffMember->user->phone,
                    'role' => $staffMember->role->name,
                ];
            });

            return response()->json([
                'status' => true,
                'staff_list' => $staffList,
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
                        'name'=>'required',
                        'email'=>'required|email|unique:users,email',
                        'phone'=>'required|numeric|digits:11|unique:users,phone',
                        'password'=>'required|min:8',
                        'roles_id'=>'required|exists:roles,id'
                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            'errors'=>$validator->errors(),
                        ], 400);
                    }

                    $requestData = $request->except(['image', 'user_role', 'password']);
                    $requestData['image'] = UploadImage::imageUpload($request->file('image'), 'backend/assets/images/staff/');
                    $requestData['user_role'] = 2;
                    $requestData['password'] = bcrypt($request->input('password'));
                    $userData = $this->user->create($requestData);


                    $staff = $this->staff->create([
                       'user_id' =>$userData->id,
                       'roles_id'=>$request->roles_id,
                    ]);

                    return response()->json([
                        'status'=> true,
                        'message'=> "User and Staff Data Created Successfully",
                        'user' => $userData,
                        'staff' => $staff,
                    ], 201);
                } else {
                    return response()->json([
                        'status'=>false,
                        'message' =>'Only authorised user can access to create this data!!!',
                    ], 401);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Invalid Token",
                ], 405);
            }
        }
        catch (\Exception $e) {
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
                    'message' => 'Only authorised user can access to get this data!!!!',
                ], 401);
            }

                $staff = $this->staff->with(['user', 'role'])->find($id);
                $project = $this->project->where('created_by', $staff->user->name)
                    ->select('id','customer_name','customer_phone',
                        'project_name','project_value','advance','status')->get();
                if (!$staff)
                {
                    return response()->json([
                        'status'=>false,
                        'message'=>"Staff Not Found"
                    ], 404);
                }

                $staff_details =  [
                       'id' => $staff->id,
                       'name' => $staff->user->name,
                       'role' => $staff->role->name,
                       'email' => $staff->user->email,
                       'phone' => $staff->user->phone,
                       'image' => $staff->user->image,
                       'address' => $staff->user->address,
                        'projects' => $project


                   ];
                return response()->json([
                    'status'=> true,
                    'staff_details' => $staff_details,
                ], 200);

        }
        catch (\Exception $e) {
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
            if ($request->isMethod('post')) {
                $user = Auth::user();

                if ($user) {

                    $staff = $this->staff->find($id);

                    if (!$staff) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Staff not found'
                        ], 404);
                    }

                    // Validation
                    $validator = Validator::make($request->all(), [
                        'name'=>'required',
                        'phone'=>'required|numeric|digits:11',
                        'roles_id'=>'required|exists:roles,id'
                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            'errors' => $validator->errors(),
                        ], 400);
                    }

                    // Update user data
                    $userData = $this->user->where('user_role', 2)->where('id', $staff->user_id)->first();
                     $userData->update([
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'phone' => $request->input('phone'),
                        'user_role' => 2,
                        'password' => $request->filled('password') ? bcrypt($request->input('password')) : $userData->password,
                        'address' => $request->input('address'),
                        'image' => UploadImage::imageUpload($request->file('image'), 'backend/assets/images/staff/', isset($id) ? $userData->image:''),
                    ]);

                    // Update staff data
                    $staff->update([
                        'roles_id' => $request->input('roles_id'),
                    ]);

                    return response()->json([
                        'status' => true,
                        'message' => "User & Staff Data Updated Successfully",
                        'user' => $userData,
                        'staff' => $staff,
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Only authorised user can access to update this data',
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
    public function destroy(Request $request,string $id)
    {
        try {
            if ($request->isMethod('delete')) {
                $user = Auth::user();

                if ($user) {
                    $staff = $this->staff->with(['user', 'role'])->find($id);

                    if (!$staff)
                    {
                        return response()->json([
                            'status'=>false,
                            'message'=>"Staff Not Found"
                        ], 404);
                    }

                    $userData = $this->user->where('id', $staff->user_id)->first();
                    $image = public_path($userData->image);
                    if (File::exists($image)) {
                        File::delete($image);
                    }
                    if ($userData)
                    {
                        $userData->delete();
                    }

                    $staff->delete();


                    return response()->json([
                        'status'=> true,
                        'message'=> "User and Staff Data Deleted Successfully",
                        'user' => $userData,
                        'staff' => $staff,
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Only authorised user can access to delete this data',
                    ], 401);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Invalid HTTP Method",
                ], 405);
            }
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
