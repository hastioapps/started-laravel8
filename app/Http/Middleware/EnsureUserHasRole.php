<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tcodes;
use App\Models\Role_tcodes;
use Illuminate\Support\Facades\Route;
class EnsureUserHasRole
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->started==1) {
            if (!$request->is('started/company')){
                return redirect()->route('started1');
            }
        }else if ($request->user()->started=='Welcome') {
            if (!$request->is('welcome')){
                return redirect()->route('welcome');
            }
        }else{
            $validate_tcode[]='index';
            $validate_tcode[]='home';
            $validate_tcode[]='profile';
            $validate_tcode[]='company';
            $validate_tcode[]='company.edit';
            $validate_tcode[]='reports';
            $validate_tcode[]='masters';
            $currentPath=Route::currentRouteName();
            if ($request->user()->role_id=='Admin'){
                $tcodes=Tcodes::select('id')->where('access','Public')->get();
                foreach ($tcodes as $tcode){
                    $validate_tcode[]=$tcode->id;
                }
            }else{
                $tcodes=Role_tcodes::select('tcode_id')->where('role_id',$request->user()->role_id)->get();
                foreach ($tcodes as $tcode){
                    $validate_tcode[]=$tcode->tcode_id;
                }
            }
            $allow = in_array($currentPath,$validate_tcode);
            if(!$allow){
                $request->session()->flash('warning',__('alert.forbidden_tcode').$currentPath);
                return back();
            }
        }
        return $next($request);
    }

}