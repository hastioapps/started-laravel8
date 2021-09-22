<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LangController extends Controller
{
    public function selectLang(Request $request){
        setcookie('lang',$request->id,['path' => '/']);
        return redirect()->back();
    }
}