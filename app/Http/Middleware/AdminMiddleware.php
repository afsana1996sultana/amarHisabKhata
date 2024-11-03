<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::guard('admin')->check()){
            if(Auth::guard('admin')->user() || Auth::guard('admin')->user()->user_role =="2"){
                if(!Auth::guard('admin')->user()->user_role == "1" && !Auth::guard('admin')->user()->user_role == "2"){
                    return redirect()->route('login')->with('error','Plz login First');
                }
            }else if(Auth::guard('web')->user()){
                abort(404);
            }else{
                abort(404);
            }
        }else{
            return redirect()->route('login');
        }
        return $next($request);
    }

}
