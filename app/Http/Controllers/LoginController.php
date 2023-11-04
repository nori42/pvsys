<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
           
            if($request->loginas == 'customer'){
                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();
                    
                    if(Auth::user()->role == "ADMINISTRATOR")
                        return redirect()->intended('/admin')->with('incorrectRoleLogin','Admin cannot login in client');

                    return redirect()->intended('/services');
                }
            } else {
                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();
                    
                    if(Auth::user()->role == "CUSTOMER")
                        return redirect()->intended('/login')->with('incorrectRoleLogin','Client cannot login in admin');

                    return redirect()->intended('/bookings?status=pending');
                }
            }

        return back()->with('invalidCred',true);
    }

    public function logout(){
        $role = Auth::user()->role;
        Auth::logout();

        if($role == "CUSTOMER")
            return redirect('/login');
        else
            return redirect('/admin');
    }
}
