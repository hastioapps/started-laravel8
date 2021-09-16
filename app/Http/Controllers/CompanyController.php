<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Companies;

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
}
