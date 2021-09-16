<?php
namespace App\Http\Controllers;

class LangController extends Controller
{
    public function selectLang(){
        setcookie('lang',$_GET['id'],['path' => '/']);
        return redirect()->back();
    }
}