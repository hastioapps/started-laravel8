<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currencies;

class HomeController extends Controller
{
    public function __construct()
    {        
        parent::__construct();
    }

    public function home(Request $request)
    {
        $this->breadcrumb->add(__('label.welcome'), '/');
		$data['breadcrumbs'] = $this->breadcrumb->render();
        $data['title'] = __('label.title');
        return view('home.index',$data);
    }
}
