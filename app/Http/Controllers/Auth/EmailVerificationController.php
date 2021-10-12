<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller
{
    public function notice(){
        $data['title'] = __('auth.verify_your_email_address');
        return view('auth.verify-email',$data);
    }

    public function verify(EmailVerificationRequest $request){
        $request->fulfill();
        return redirect()->route('home');
    }

    public function send(Request $request){
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', __('auth.resend_email_message'));
    }

    public function change(Request $request){
        $request->validate([
            'email'         => 'required|email|unique:users,email',
        ]);
        $email=$request->email;
        if (User::where('id',$request->user()->id)->update(['email'=>$email,'email_verified_at'=>null])){
            return back()->with('message', __('alert.after_update'));
        }else{
            $alert['alert']= 'Error';
            $alert['message']=__('alert.system_error');
        }
    }
}
