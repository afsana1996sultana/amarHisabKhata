<?php

namespace App\Http\Controllers\Api;

use App\Helper\UploadImage;
use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Lead;
use App\Models\Project;
use App\Models\Setting;
use App\Models\User;
use App\Models\Staff;
use App\Models\Payment;
use App\Models\Deposit;
use App\Models\Withdraw;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdminApiController extends Controller
{
    public function login(Request $request)
    {
        $loginUserData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|min:8',
        ]);

        $user = User::where('email', $loginUserData['email'])->first();

        if (!$user || !Hash::check($loginUserData['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid Credentials',
            ], 401);
        }

        $user->tokens()->delete();
        $token = $user->createToken('myApp', ['*'], now()->addHours(10));
        $success['name'] = $user->name;
        $success['token'] = $token->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login successfully',
            'success' => $success
        ]);
    }



    public function getProfile()
    {
        try {
            $user = Auth::user();
            if ($user) {
                $get_user = User::where('id', $user->id)->first();
                if ($get_user->user_role == 2) {
                    $staff = Staff::where('user_id', $get_user->id)->first();
                    if ($staff) {
                        $role = Roles::where('id', $staff->roles_id)->first();
                        if ($role) {
                            $get_user->user_role = $role->name;
                        } else {
                            return response()->json([
                                'status' => false,
                                'message' => 'Role not found',
                            ], 404);
                        }
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'Staff not found',
                        ], 404);
                    }
                }

                return response()->json([
                    'status' => true,
                    'get_user' => $get_user,
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized',
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }



    public function updateProfile(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $user = Auth::user();
                if ($user) {
                    $validator = Validator::make($request->all(), [
                        'name' => 'required',
                        'email' => 'required|email',
                        'phone' => 'required',
                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            'errors' => $validator->errors(),
                        ], 400);
                    }

                    $auth_id = $user->id;
                    $user = User::where('id', $auth_id)->first();
                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->phone = $request->phone;
                    $user->address = $request->address;
                    if ($request->hasFile('image')) {
                        if ($user->image)
                        {
                            File::delete($user->image);
                        }
                        $user->image = UploadImage::imageUpload($request->file('image'), 'backend/assets/images/profile/');
                    }

                    $user->save();

                    return response()->json([
                        'status' => true,
                        'message' => "Profile Updated Successfully",
                        'user' => $user,
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Unauthorized',
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


    public function updatePassword(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $user = Auth::user();
                if ($user) {
                    $validator = Validator::make($request->all(), [
                        'current_password' => 'required',
                        'new_password' => 'required|min:6|max:30',
                        'confirm_password' => 'required|same:new_password',
                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            'errors' => $validator->errors(),
                        ], 400);
                    }

                    if (Hash::check($request->current_password, $user->password)) {
                        $user = User::where('id', $user->id)->first();
                        $user->password = Hash::make($request->new_password);
                        $user->save();

                        return response()->json([
                            'status' => true,
                            'message' => 'Your Password Updated Successfully',
                        ], 200);
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'Current Password does not match',
                        ], 405);
                    }
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Unauthorized',
                    ], 401);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Token',
                ], 405);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function  create(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $user = Auth::user();
                if ($user->user_role != 1) {
                    return response()->json([
                        'status' => false,
                        'message' => 'You are not an admin...Only admin can access to create this data!!!',
                    ], 401);
                }

                $setting = Setting::first();
                $setting->site_name = $request->site_name;
                $setting->site_title = $request->site_title;
                $setting->contact_number = $request->contact_number;
                $setting->email = $request->email;
                $setting->address = $request->address;
                $setting->fax = $request->fax;
                $setting->prefix = $request->prefix;
                if ($request->hasFile('header_logo')) {
                    if ($setting->header_logo)
                    {
                        File::delete($setting->header_logo);
                    }
                    $setting->header_logo = UploadImage::imageUpload($request->file('header_logo'), 'images/setting/');
                }
                if ($request->hasFile('footer_logo')) {
                    if ($setting->footer_logo)
                    {
                        File::delete($setting->footer_logo);
                    }
                    $setting->footer_logo = UploadImage::imageUpload($request->file('footer_logo'), 'images/setting/');
                }
                if ($request->hasFile('fav_icon')) {
                    if ($setting->fav_icon)
                    {
                        File::delete($setting->fav_icon);
                    }
                    $setting->fav_icon = UploadImage::imageUpload($request->file('fav_icon'), 'images/setting/');
                }
                $setting->save();
                if (!$setting) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Setting Data Not found'
                    ], 404);
                }

                return response()->json([
                    'status' => true,
                    'message' => "Setting Data stored successfully",
                    'setting' => $setting,
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Token',
                ], 405);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function getDashboardData()
    {
        try {

            $user = Auth::user();
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $data = [
                'total_lead' => Lead::where('is_customer', 0)->count(),
                'total_customer' => Lead::where('is_customer', 1)->count(),
                'current_project' => Project::where('status', 0)->count(),
                'total_project' => Project::count(),
                'total_expense_value' => (double) Expense::sum('amount'),
                'total_staff' => Staff::count(),
                'total_project_value' => (int) Project::sum('project_value'),
                'current_project_value' => (int) Project::where('status', 0)->sum('project_value'),
            ];

            return response()->json([
                'status'=> true,
                'get_dashboard_data' => $data,
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'An error occurred while fetching the dashboard data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function getAccountLedger()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            // Calculate income, deposits, expenses, and balance
            $projectIncome = (int) Project::where('is_approve', 1)->sum('advance');
            $paymentIncome = (int) Payment::where('is_approve', 1)->sum('amount');
            $totalIncome = $projectIncome + $paymentIncome;

            $totalDeposit = (int) Deposit::where('status', 1)->sum('amount');
            $totalExpense = (int) Expense::where('is_approve', 1)->sum('amount');
            $totalWithdraw = (int) Withdraw::where('status', 1)->sum('amount');

            $sumOfIncome = $totalIncome + $totalDeposit;
            $sumOfExpense = $totalExpense + $totalWithdraw;
            $balance = $sumOfIncome - $sumOfExpense;

            // Prepare data array for response
            $data = [
                'project_income' => $projectIncome,
                'payment_income' => $paymentIncome,
                'total_income' => $totalIncome,
                'total_deposit' => $totalDeposit,
                'total_expense' => $totalExpense,
                'total_withdraw' => $totalWithdraw,
                'sum_of_income' => $sumOfIncome,
                'sum_of_expense' => $sumOfExpense,
                'balance' => $balance,
            ];

            return response()->json([
                'status' => true,
                'get_account_ledger' => $data,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching the cashbook data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
