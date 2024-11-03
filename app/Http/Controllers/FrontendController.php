<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FrontendController extends Controller
{
    public function login(){
        if (Auth::guard('web')->check()) {
            return redirect()->intended('dashboard');
        }
        return view('frontend.auth.login');
    }


    public function loginCheck(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|max:30',
        ], [
            'email.exists' => 'This email does not exist in the user table',
        ]);

        $credentials = $request->only('email', 'password');

        if(Auth::guard('web')->attempt($credentials)){
            return redirect()->intended('dashboard');
        } else {
            return redirect()->route('index')->with('error', 'Incorrect credentials');
        }
    }

        public function logout(){
        Auth::guard('web')->logout();
        return redirect('/')->with('success','Successfully logout');
    }

}
