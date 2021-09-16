<?php

namespace App\Http\Middleware;

use Closure;
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
            $tcode[]='/';
            $tcode[]='home';
            $tcode[]='profile';
            $tcode[]='company';
            $currentPath=$request->path();
            $allow = in_array($currentPath,$tcode);
            if(!$allow){
                return redirect()->route('home');
            }
        }
        return $next($request);
    }

}