<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Companies;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function __construct()
    {        
        parent::__construct();
    }

    public function company(Request $request)
    {
        $this->breadcrumb->add(__('label.home'), '/');
        $this->breadcrumb->add(__('label.company'), '/company');
		$data['breadcrumbs'] = $this->breadcrumb->render();
        $data['title'] = __('label.company');
        $data['company'] = Companies::where('id',$request->user()->id)->first();
        return view('home.company',$data);
    }

    public function change_logo(Request $request){
        if ($request->file('file')){
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
                    $temp=$file->store('company-img');
		            Companies::where('id',$request->user()->company_id)->update(['img'=> $name]);
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
        echo json_encode($alert);
    }
}
