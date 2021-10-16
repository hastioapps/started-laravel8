<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Companies;
use Illuminate\Support\Str;
use App\Models\Currencies;

class CompanyController extends Controller
{
    public function company(Request $request)
    {
        $this->breadcrumb->add(__('label.home'), '/');
        $this->breadcrumb->add(__('label.company'), '/company');
		$data['breadcrumbs'] = $this->breadcrumb->render();
        $data['title'] = __('label.company');
        $data['company'] = Companies::where('id',$request->user()->company_id)->first();
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
        return json_encode($alert);
    }

    public function edit(Request $request){
        $this->breadcrumb->add(__('label.home'), '/');
        $this->breadcrumb->add(__('label.company'), '/company');
        $this->breadcrumb->add(__('button.edit'), '/company/edit');
		$data['breadcrumbs'] = $this->breadcrumb->render();
        $data['title'] = __('label.company_edit');
        $data['company'] = Companies::where('id',$request->user()->company_id)->first();
        $data['currency'] = Currencies::select('id','description')->get();
        return view('home.company_edit',$data);
    }

    public function update(Request $request){
        $request->validate([
            'name'          => 'required|max:100',
            'address'       => 'required',
            'phone'         => 'max:15',
            'email'         => 'max:225',
            'owner'         => 'required|max:100',
            'currency'      => 'required',
            'npwp'          => 'max:25',
            'npwp_name'     => 'max:100',
        ]);

        if(Companies::where('id',$request->user()->company_id)->update([
                'name'          => $request->name,
                'address'       => $request->address,
                'currency_id'   => $request->currency, 
                'email'         => $request->email, 
                'phone'         => $request->phone, 
                'npwp'          => $request->npwp, 
                'npwp_name'     => $request->npwp_name, 
                'npwp_address'  => $request->npwp_address, 
                'owner'         => $request->owner,
        ])){
            $request->session()->flash('success',__('alert.after_update'));
            return redirect()->to(url('company'));
        } else {
            $request->session()->flash('warning',__('alert.failed_save'));
            return back();
        }
    }
}
