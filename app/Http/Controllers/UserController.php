<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function create(){
        return view('register');
    }

    public function store(Request $request){
        if(User::where('email',$request->email)->count() == 1){
            return back()->with('emailExist',true);
        }

        $user = new User();

        $user->email = $request->email;

        $user->password = Hash::make($request->password);
        $user->first_name = $request->firstname;
        $user->last_name = $request->lastname;
        $user->phone_no = $request->phoneno;

        $user->save();

        return view('login');
    }
}
