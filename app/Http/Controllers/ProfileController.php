<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {        
        parent::__construct();
    }

    public function profile(Request $request)
    {
        $this->breadcrumb->add(__('label.home'), '/');
        $this->breadcrumb->add(__('label.profile'), '/profile');
		$data['breadcrumbs'] = $this->breadcrumb->render();
        $data['title'] = __('label.profile');
        return view('home.profile',$data);
    }

    public function change_password(Request $request){
        $request->validate([
            'password'      => 'required|confirmed',
        ]);

        User::where('id',$request->user()->id)->update(['password' => Hash::make($request->password)]);
        $request->session()->flash('success',__('alert.after_update'));
        return back();
    }

    public function change_atribute(Request $request){
        if ($request->changeName){
            $data=$request->changeName;
            if (User::where('id',$request->user()->id)->update(['name'=> $data])){
                $alert['alert']= 'Success';
                $alert['message']=__('alert.after_update');
            }else{
                $alert['alert']= 'Error';
                $alert['message']=__('alert.system_error');
            }
        }else if ($request->changePhone){
            $data=$request->changePhone;
            if (User::where('id',$request->user()->id)->update(['phone'=> $data])){
                $alert['alert']= 'Success';
                $alert['message']=__('alert.after_update');
            }else{
                $alert['alert']= 'Error';
                $alert['message']=__('alert.system_error');
            }
        }else{
            $alert['alert']= 'Error';
            $alert['message']=__('alert.system_error');
        }
        echo json_encode($alert);
    }
}
