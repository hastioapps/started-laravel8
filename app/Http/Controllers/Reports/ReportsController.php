<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function __construct()
    {        
        parent::__construct();
    }

    public function reports(Request $request)
    {
        $this->breadcrumb->add(__('label.reports'), '/');
		$data['breadcrumbs'] = $this->breadcrumb->render();
        $data['title'] = __('label.title');
        return view('reports.index',$data);
    }
}
