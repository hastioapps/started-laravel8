<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(){
        $data['title'] = __('auth.login');
        return view('auth.login',$data);
    }

    public function store(Request $request){
        $request->validate([
            'user_id'        => 'required',
            'password'      => 'required',
        ]);

        $data = [
            'id'  => $request->user_id,
            'password'  => $request->password,
            'status'    => 'Enabled',
        ];
  
        if (Auth::attempt($data, $request->remember)) { 
            $request->session()->regenerate();
            return redirect()->route('home');
        } else {
            $request->session()->flash('warning',__('auth.alert_login'));
            return back();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
