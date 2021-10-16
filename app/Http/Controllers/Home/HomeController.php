<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        $this->breadcrumb->add(__('label.home'), '/');
		$data['breadcrumbs'] = $this->breadcrumb->render();
        $data['title'] = __('label.title');
        return view('home.index',$data);
    }
}
