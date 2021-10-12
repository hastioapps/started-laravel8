<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branches;
use App\Models\Branch_roles;
use Illuminate\Support\Facades\Validator;

class BranchesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->breadcrumb->add(__('label.home'), '/');
        $this->breadcrumb->add(__('label.branches'), '/branches');
		$data['breadcrumbs']    = $this->breadcrumb->render();
        $data['title']          = __('label.branches');
        return view('home.branches',$data);
    }

    public function flexigrid(Request $request)
    {
        $page           = (isset($request->page))?$request->page: 1;
		$rp             = (isset($request->rp))?$request->rp : 10;
        $start          = (($page-1) * $rp);
      	$sortname       = (isset($request->sortname))? $request->sortname : ' id ';
      	$sortorder      = (isset($request->sortorder))? $request->sortorder : ' asc ';
        $user_id        = $request->user()->id;
        $result         = Branches::select('code','name','phone','email','status')
                            ->whereExists(function ($query) use ($user_id) {
                                $query->select('branch_roles.branch_id')->from('branch_roles')->whereColumn('branch_roles.branch_id','=','branches.id')->where('branch_roles.user_id',$user_id);
                            })
                            ->where('company_id', '=', $request->user()->company_id)
                            ->filter($request['query'],$request['qtype'])
                            ->orderBy($sortname,$sortorder)
                            ->offset($start)
                            ->limit($rp)
                            ->get();
        
        $result_total   = Branches::select('id')
                            ->whereExists(function ($query) use ($user_id) {
                                $query->select('branch_roles.branch_id')->from('branch_roles')->whereColumn('branch_roles.branch_id','=','branches.id')->where('branch_roles.user_id',$user_id);
                            })
                            ->where('company_id', '=', $request->user()->company_id)
                            ->filter($request['query'],$request['qtype'])
                            ->count();                  
        $data = $_POST;
        $data['total'] = ($result_total<100)? $result_total : 100;
        $array_default = array();
        $array_data = array();
        foreach ($result as $row){
            $rows['ID'] = $row->code;
            if($row->status=='Disabled'){
                $label_status='<i class="text-danger">'.$row->status.'</i>';
            }else if($row->status=='Enabled') {
                $label_status='<i class="text-primary">'.$row->status.'</i>';
            }else{
                $label_status='<i class="text-warning">'.$row->status.'</i>';
            }  
            
            $array_data['cell'] =array($row->code,$row->name,$row->phone,$row->email,$label_status);
            array_push($array_default,$array_data);
        }
        $data['rows'] = $array_default;
        return json_encode($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->breadcrumb->add(__('label.home'), '/');
        $this->breadcrumb->add(__('label.branches'), '/branches');
        $this->breadcrumb->add(__('button.create'), '/branches/create');
		$data['breadcrumbs']    = $this->breadcrumb->render();
        $data['title']          = __('label.branch_create');
        return view('home.branches_create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id=$request->user()->company_id.$request->code;
        $data=Validator::make([
            'id'            => $id,
            'code'          => $request->code,
            'name'          => $request->name,
            'address'       => $request->address,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'manager'       => $request->manager,
            'company_id'    => $request->user()->company_id,
        ],[
            'id'            => 'unique:branches,id',
            'code'          => 'required|max:4|alpha_num',
            'name'          => 'required|max:100',
            'address'       => 'required',
            'email'         => 'max:225',
            'phone'         => 'max:15',
            'manager'       => 'required|max:100',
            'company_id'    => 'required',
        ])->validate();

        if(Branches::create($data) && Branch_roles::create(['id'=>$id.$request->user()->id,'user_id'=>$request->user()->id,'branch_id'=>$id])){
            $request->session()->flash('success',__('alert.after_save'));
            return redirect()->route('branches');
        } else {
            $request->session()->flash('warning',__('alert.failed_save'));
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $branches=Branches::select('code','name','address','phone','email','manager','status','created_at','updated_at')
                    ->where(['id'=>$request->user()->company_id.$request->id])
                    ->first();

        if (isset($branches)){
            $text='<div class="table-responsive p-0" style="max-height: 450px">
                <table class="table table-head-fixed table-sm">
                    <thead>
                        <tr>
                            <th style="width:20%">'.__("label.code").'</th>
                            <th style="width:5%">:</th>
                            <th style="width:75%">'.$branches->code.'</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width:20%">'.__("label.name").'</td>
                            <td style="width:5%">:</td>
                            <td style="width:75%">'.$branches->name.'</td>
                        </tr>
                        <tr>
                            <td style="width:20%">'.__("label.address").'</td>
                            <td style="width:5%">:</td>
                            <td style="width:75%">'.$branches->address.'</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>:</td>
                            <td>'.$branches->phone.'</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td>'.$branches->email.'</td>
                        </tr>
                        <tr>
                            <td>Manager</td>
                            <td>:</td>
                            <td>'.$branches->manager.'</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td>'.$branches->status.'</td>
                        </tr>
                        <tr>
                            <td>'.__("label.created_at").'</td>
                            <td>:</td>
                            <td>'.$branches->created_at.'</td>
                        </tr>
                        <tr>
                            <td>'.__("label.updated_at").'</td>
                            <td>:</td>
                            <td>'.$branches->updated_at.'</td>
                        </tr>
                    </tbody>
                </table>
            </div>';
            return $text;
        }else{
            return __('alert.data_not_found',['Data' => $request->id ?? 'Data']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $this->breadcrumb->add(__('label.home'), '/');
        $this->breadcrumb->add(__('label.branches'), '/branches');
        $this->breadcrumb->add(__('button.edit'), '/branches'.$id.'/edit');
		$data['breadcrumbs']    = $this->breadcrumb->render();
        $data['title']          = __('label.branch_edit');
        $user_id                = $request->user()->id;
        $data['branches']       = Branches::select('id','code','name','address','phone','email','manager')
                                        ->whereExists(function ($query) use ($user_id) {
                                            $query->select('branch_roles.branch_id')->from('branch_roles')->whereColumn('branch_roles.branch_id','=','branches.id')->where('branch_roles.user_id',$user_id);
                                        })
                                        ->where(['id'=>$request->user()->company_id.$id])
                                        ->first();
        if (isset($data['branches'])){
            return view('home.branches_edit',$data);
        }else{
            $data['id']=$id;
            $data['back']='branches';
            return view('layouts.not_found',$data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data=Validator::make([
            'name'          => $request->name,
            'address'       => $request->address,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'manager'       => $request->manager,
        ],[
            'name'          => 'required|max:100',
            'address'       => 'required',
            'email'         => 'max:225',
            'phone'         => 'max:15',
            'manager'       => 'required|max:100',
        ])->validate();

        if(Branches::where('id',$id)->update($data)){
            $request->session()->flash('success',__('alert.after_update'));
            return redirect()->route('branches');
        } else {
            $request->session()->flash('warning',__('alert.failed_save'));
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function status(Request $request)
    {
        if ($request['id']){
            $id=$request->user()->company_id.$request->id;
            $status=$request->status;
            if ($status=='Enabled'){
                $status_change='Disabled';
            }else{
                $status_change='Enabled';
            }

            if (Branches::where('id',$id)->update(['status'=> $status_change])){
                $alert['alert']= 'Success';
                $alert['message']=$id.' status '.$status_change;
            }else{
                $alert['alert']= 'Error';
                $alert['message']=__('alert.system_error');
            }
        }else{
            $alert['alert']= 'Warning';
            $alert['message']=__('alert.failed_save');
        }
        return json_encode($alert);
    }

    
}
