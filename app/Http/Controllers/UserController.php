<?php

namespace App\Http\Controllers;

use App\Models\User;
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

        return view('pages.client.login');
    }
}
