<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(){
        $data['title'] = __('auth.sign_up');
        return view('auth.register',$data);
    }

    public function store(Request $request){
        $request->validate([
            'username'        => 'required|max:10|unique:users,username|alpha_num',
            'company'       => 'required|max:100',
            'email'         => 'required|email|unique:users,email',
            'phone'         => 'required|max:15',
            'password'      => 'required|confirmed',
        ]);

        $data=User::create([
            'username' => $request->username,
            'name'     => $request->company,
            'email'    => $request->email,
            'phone'    => $request->phone, 
            'password' => Hash::make($request->password),
            'role_id'  => 'Admin',
            'started'  => 1,
            'master'   => true,
        ]);
        
        if($data){
            $request->session()->flash('success',__('auth.success_register'));
            return redirect()->route('login');
        } else {
            $request->session()->flash('warning',__('auth.alert_register'));
            return back();
        }
    }
}
