<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
}
