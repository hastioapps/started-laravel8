<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tcodes;
use App\Models\Role_tcodes;

class TcodeController extends Controller
{
    public function tcode(Request $request)
    {
        $tcode=$request->tcode;
        if ($request->user()->role_id=='Admin'){
            if($data=Tcodes::select('id')->where(['access'=>'Public','id'=>$tcode])->first()){
                $alert['alert']= 'Success';
                $alert['message']=route($data->id);
            }else{
                $alert['alert']= 'Warning';
                $alert['message']=__('alert.forbidden_tcode');
            }
        }else{
            if($data=Role_tcodes::select('tcode_id')->where(['role_id'=>$request->user()->role_id,'tcode_id'=>$tcode])->first()){
                $alert['alert']= 'Success';
                $alert['message']=route($data->tcode_id);
            }else{
                $alert['alert']= 'Warning';
                $alert['message']=__('alert.forbidden_tcode');
            }
        }
        echo json_encode($alert);
    }
}