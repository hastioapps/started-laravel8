<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MastersController extends Controller
{
    public function masters(Request $request)
    {
        $this->breadcrumb->add(__('label.master_data'), '/');
		$data['breadcrumbs'] = $this->breadcrumb->render();
        $data['title'] = __('label.title');
        return view('masters.index',$data);
    }
}
