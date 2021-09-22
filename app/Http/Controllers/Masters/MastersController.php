<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MastersController extends Controller
{
    public function __construct()
    {        
        parent::__construct();
    }

    public function masters(Request $request)
    {
        $this->breadcrumb->add(__('label.welcome'), '/');
		$data['breadcrumbs'] = $this->breadcrumb->render();
        $data['title'] = __('label.title');
        return view('masters.index',$data);
    }
}
