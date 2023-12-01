<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function create(){
        return view('pages.client.register');
    }

    public function store(Request $request){
        $inputs = $request->collect();

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if(User::where('email',$request->email)->count() == 1){
            return back()->with('emailExist',true);
        }

        $user = new User();

        $user->email = $request->email;

        $user->password = Hash::make($request->password);
        $user->first_name = $inputs['firstname'];
        $user->last_name = $inputs['lastname'];;
        $user->phone_no = $inputs['phoneno'];;
        $user->role = $inputs['role'];;

        $user->save();

        $user->notify(new VerifyEmail);

        return view('pages.client.login');
    }
}
