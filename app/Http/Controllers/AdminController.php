<?php

namespace App\Http\Controllers;

use App\Helper\UploadImage;
use App\Models\Expense;
use App\Models\Lead;
use App\Models\Staff;
use App\Models\User;
use App\Models\Project;
use App\Models\Payment;
use App\Models\Deposit;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use const http\Client\Curl\AUTH_ANY;

class AdminController extends Controller
{
    public function dashboard(){
        $total_lead = Lead::where('is_customer', '=', 0)->count();
        $total_customer = Lead::where('is_customer', '=', 1)->count();
        $current_project = Project::where('status', 0)->count();
        $total_project = Project::count();
        $total_expense_value = Expense::sum('amount');
        $total_staff = Staff::count();
        $total_project_value = Project::sum('project_value');
        $current_project_value = Project::Where('status', 0)->sum('project_value');
        return view('admin.index', compact('total_lead', 'total_customer', 'current_project', 'total_project', 'total_expense_value', 'total_staff', 'total_project_value', 'current_project_value'));
    }

    public function index()
    {
        $user = User::findOrFail(Auth::user()->id);
        return view('admin.profile.index', compact('user'));
    }

    public function updatePro(Request $request){

        $request->validate([
            'email' => 'required',
            'name' => 'required',
            'phone' => 'required'
        ]);

        $auth_id = Auth::user()->id;

        $user = User::where('id', $auth_id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        if ($request->hasFile('image'))
        {
            if ($user->image)
            {
                File::delete($user->image);
            }
            $user->image = UploadImage::imageUpload($request->file('image'), 'backend/assets/images/profile/');
        }

        $user->save();
        return redirect()->back()->with('success', 'Your Profile updated Successfully.');
    }

    public function updatePass(Request $request){
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|max:30',
            'confirm_password' => 'required|same:new_password',
        ]);

        if(Hash::check($request->current_password, Auth::guard('web')->user()->password)){
            if($request->new_password == $request->confirm_password){
                $admin = User::where('id', Auth::guard('web')->user()->id)->first();
                $admin->password = Hash::make($request->new_password);
                $admin->save();
                return redirect()->back()->with('success', 'Your Password Updated Successfully.');
            }else{
                return redirect()->back()->with('error', 'Password Do not match');
            }
        }else{
            return redirect()->back()->with('error', 'Current Password Do not match');
        }
    }

    public function AccountLedger(){
        $projectIncome = (int) Project::where('is_approve', 1)->sum('advance');
        $paymentIncome = (int) Payment::where('is_approve', 1)->sum('amount');
        $totalIncome = $projectIncome + $paymentIncome;

        $totalDeposit = (int) Deposit::where('status', 1)->sum('amount');
        $totalExpense = (int) Expense::where('is_approve', 1)->sum('amount');
        $totalwithdraw = (int) Withdraw::where('status', 1)->sum('amount');
        $SumOfIncome = $totalIncome + $totalDeposit;
        $SumOfExpense = $totalExpense + $totalwithdraw;
        $Balance = $SumOfIncome - $SumOfExpense;
        //dd('Balance', $Balance);

        return view('admin.ledger.index', compact('totalIncome', 'totalDeposit', 'totalExpense', 'totalwithdraw', 'SumOfIncome', 'SumOfExpense', 'Balance'));
    }
}
