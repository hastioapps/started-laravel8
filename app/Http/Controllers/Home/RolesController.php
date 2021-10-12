<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\Tcodes;
use App\Models\Role_tcodes;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $this->breadcrumb->add(__('label.home'), '/');
        $this->breadcrumb->add(__('label.roles'), '/roles');
		$data['breadcrumbs'] = $this->breadcrumb->render();
        $data['title'] = __('label.roles');
        return view('home.roles',$data);
    }

    public function flexigrid(Request $request)
    {
        $page           = (isset($request->page))?$request->page: 1;
		$rp             = (isset($request->rp))?$request->rp : 10;
        $start          = (($page-1) * $rp);
      	$sortname       = (isset($request->sortname))? $request->sortname : ' id ';
      	$sortorder      = (isset($request->sortorder))? $request->sortorder : ' asc ';

        $result         = Roles::select('role_name')
                            ->where('company_id', '=', $request->user()->company_id)
                            ->filter($request['query'],$request['qtype'])
                            ->orderBy($sortname,$sortorder)
                            ->offset($start)
                            ->limit($rp)
                            ->get();
        
        $result_total   = Roles::select('role_name')
                            ->where('company_id', '=', $request->user()->company_id)
                            ->filter($request['query'],$request['qtype'])
                            ->count();                  
        $data = $_POST;
        $data['total'] = ($result_total<100)? $result_total : 100;
        $array_default = array();
        $array_data = array();
        foreach ($result as $row){
            $rows['ID'] = $row->role_name;
            $array_data['cell'] =array($row->role_name);
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
        $this->breadcrumb->add(__('label.roles'), '/roles');
        $this->breadcrumb->add(__('button.create'), '/roles/create');
		$data['breadcrumbs']    = $this->breadcrumb->render();
        $data['title']          = __('label.role_create');
        return view('home.roles_create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make([
            'role'          => $request->user()->company_id.$request->role_name,
            'role_name'     => $request->role_name,
        ],[
            'role'          => 'required|unique:roles,id',
            'role_name'     => 'required|max:20|alpha_num',
        ])->validate();

        if(Roles::create([
            'id'            => $request->user()->company_id.$request->role_name,
            'role_name'     => $request->role_name,
            'company_id'    => $request->user()->company_id, 
        ])){
            $request->session()->flash('success',__('alert.after_save'));
            return redirect()->route('roles');
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
    public function show(Request $request,$id)
    {
        $this->breadcrumb->add(__('label.home'), '/');
        $this->breadcrumb->add(__('label.roles'), '/roles');
        $this->breadcrumb->add($id, '/roles/'.$id);
		$data['breadcrumbs']    = $this->breadcrumb->render();
        $data['title']          = $id;
        $data['roles']          = Roles::where(['role_name'=>$id,'company_id'=>$request->user()->company_id])->first();
        if (isset($data['roles'])){
            return view('home.roles_show',$data);
        }else{
            $data['id']=$id;
            $data['back']='roles';
            return view('layouts.not_found',$data);
        }
    }

    public function duallist(Request $request)
    {
        if ($request['id']){
            $role=$request->id;
            $tcodes = Tcodes::select('tcodes.id', 'tcodes.description', 'tcodes.level_tcode', 'tcodes.tcode_group', 'role_tcodes.role_id as selected')
                                ->leftJoin('role_tcodes', function ($join) use ($role) {
                                    $join->on('tcodes.id', '=', 'role_tcodes.tcode_id')->where('role_tcodes.role_id', '=', $role);
                                })
                                ->where('tcodes.access','Public')
                                ->get();
            foreach ($tcodes  as $tcode) {
                if ($tcode->selected==$role){
                    $selected=true;
                }else{
                    $selected=false;
                }
                if ($tcode->level_tcode==2){
                    $groups[]=$tcode->tcode_group;
                }
                $data_tcodes[$tcode->tcode_group][]= array("item"=> __('label.'.$tcode->description),"value"=> $tcode->id,"selected"=> $selected);
            }

            $collect_group = collect($groups);
            $json=array();
            foreach ($collect_group as $group){
                $data['groupItem']=__('label.'.$group);
                $data['groupArray']=$data_tcodes[$group];
                $json[]=$data;
            }
            return json_encode($json);
        }else if ($request['code']){
	        $role=$request->code;
        	if(!isset($request->data)){
        		Role_tcodes::where('role_id',$role)->delete();
        		$alert['alert']= 'Success';
        		$alert['message']=__('alert.after_save');
        	}else{
        		$data=$request->data;
	        	$insertTcode=array();
	        	foreach ($data as $tcode) {
		        	$id=$tcode.$role;
		        	$insertTcode[]=array("id"=>$id, "role_id"=>$role, "tcode_id"=>$tcode);
		        }
                Role_tcodes::where('role_id',$role)->delete();
                if(Role_tcodes::insert($insertTcode)){
		            $alert['alert']= 'Success';
			        $alert['message']=__('alert.after_save');
		        }else{
					$alert['alert']= 'Error';
			        $alert['message']=__('alert.system_error');
				}
	        }
        	return json_encode($alert);
        };
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    public function delete($id)
    {
        $this->breadcrumb->add(__('label.home'), '/');
        $this->breadcrumb->add(__('label.roles'), '/roles');
        $this->breadcrumb->add(__('button.delete'), '/roles/delete');
		$data['breadcrumbs']    = $this->breadcrumb->render();
        $data['title']          = __('label.role_delete');
        $data['id']          =$id;
        return view('home.roles_delete',$data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $role_id=$request->user()->company_id.$request->role;
        Validator::make([
            'role_id'           => $role_id,
            'role'              => $request->role,
            'role_confirmation' => $id,
        ],[
            'role_id'           => 'unique:users,role_id',
            'role'              => 'required|max:20|confirmed',
        ],[
            'role_id.unique'    => __('validation.delete_unique'),
        ])->validate();

        if(Roles::where('id',$role_id)->delete() || Role_tcodes::where('role_id',$role_id)->delete()){
            $request->session()->flash('success',__('alert.after_delete'));
            return redirect()->route('roles');
        } else {
            $request->session()->flash('warning',__('alert.failed_delete'));
            return redirect()->route('roles');
        }
    }
}
