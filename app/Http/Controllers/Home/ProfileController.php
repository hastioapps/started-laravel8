<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileController extends Controller
{

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
        }else if ($request->file('file')){
            $file           = $request->file('file');
            $allowed_ext    = ['jpg', 'jpeg', 'png'];
			$file_ext		= Str::lower($file->getClientOriginalExtension());
			$file_size      = $file->getSize();
		    $name 			= $file->hashName();
				
		    if(in_array($file_ext,$allowed_ext)){
		        if ($file_size>102400){
		            $alert['alert']= 'Warning';
				    $alert['message']=__('alert.size_max_100');
		        }else{
                    $temp=$file->store('users-img');
		            User::where('id',$request->id)->update(['img'=> $name]);
		            $alert['alert']= 'Success';
				    $alert['message']=__('alert.after_save');
				    $alert['img']='<img class="profile-user-img img-fluid" src="'.asset('storage/'.$temp).'" alt="...">';
		        }
		    }else{
                $alert['alert']= 'Warning';
				$alert['message']=__('alert.ext_not_allowed');
		    }
        }else{
            $alert['alert']= 'Warning';
            $alert['message']=__('alert.failed_save');
        }
        return json_encode($alert);
    }
}
