<?php

namespace App\Http\Controllers\Started;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Companies;
use App\Models\User;
use App\Models\Currencies;
use App\Models\Branches;
use App\Models\Branch_roles;

class StartedCompanyController extends Controller
{
    public function company(){
        $this->breadcrumb->add(__('label.started'), '/home');
        $this->breadcrumb->add('1', '/started/company');
		$data['breadcrumbs'] = $this->breadcrumb->render();
        $data['title'] = __('company.new_company');
        $data['currency'] = Currencies::select('id','description')->get();
        return view('started.company',$data);
    }

    public function store(Request $request){
        $request->validate([
            'name'          => 'required|max:100',
            'address'       => 'required',
            'phone'         => 'max:15',
            'email'         => 'max:225',
            'owner'         => 'required|max:100',
            'currency'      => 'required',
            'npwp'          => 'max:25',
            'npwp_name'     => 'max:100',
        ]);

        $company=$request->user()->id; //user id == company id
        $data = Companies::create([
                'id'            => $company,
                'name'          => $request->name,
                'address'       => $request->address,
                'currency_id'   => $request->currency, 
                'email'         => $request->email, 
                'phone'         => $request->phone, 
                'npwp'          => $request->npwp, 
                'npwp_name'     => $request->npwp_name, 
                'npwp_address'  => $request->npwp_address,  
                'img'           => null,
                'owner'         => $request->owner,
        ]);
        $data2 = User::where('id',$request->user()->id)
                ->update([
                    'started'         => 'Welcome',
                    'company_id'    => $company,
                ]);
        $data3 = Branches::create([
            'id'            => $company.'HO',
            'code'          => 'HO',
            'name'          => 'Head Office',
            'address'       => $request->address,
            'email'         => $request->email, 
            'phone'         => $request->phone, 
            'manager'       => $request->owner,
            'company_id'    => $company,
        ]);
        $data4 = Branch_roles::create([
            'id'            => $company.'HO'.$request->user()->id,
            'user_id'       => $request->user()->id,
            'branch_id'     => $company.'HO',
        ]);
        if($data && $data2 && $data3 && $data4){
            return redirect()->to(url('home'));
        } else {
            $request->session()->flash('warning',__('alert.failed_save'));
            return back();
        }
    }
}
