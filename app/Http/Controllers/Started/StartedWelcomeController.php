<?php

namespace App\Http\Controllers\Started;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class StartedWelcomeController extends Controller
{
    public function welcome(Request $request){
        $this->breadcrumb->add(__('label.welcome'), '/welcome');
		$data['breadcrumbs'] = $this->breadcrumb->render();
        $data['title'] = __('label.welcome');
        return view('started.welcome',$data);
    }

    public function store(Request $request){
        if (User::where('id',$request->user()->id)->update(['started'=> 'Ok'])){
            $alert['alert']= 'Success';
            $alert['message']=url('home');
        }else{
            $alert['alert']= 'Error';
            $alert['message']=__('alert.system_error');
        }
        echo json_encode($alert);
    }
}
