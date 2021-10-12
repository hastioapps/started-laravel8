<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Roles;
use App\Models\Branches;
use App\Models\Branch_roles;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->breadcrumb->add(__('label.home'), '/');
        $this->breadcrumb->add(__('label.users'), '/users');
		$data['breadcrumbs']    = $this->breadcrumb->render();
        $data['title']          = __('label.users');
        return view('home.users',$data);
    }

    public function flexigrid(Request $request)
    {
        $page           = (isset($request->page))?$request->page: 1;
		$rp             = (isset($request->rp))?$request->rp : 10;
        $start          = (($page-1) * $rp);
      	$sortname       = (isset($request->sortname))? $request->sortname : ' id ';
      	$sortorder      = (isset($request->sortorder))? $request->sortorder : ' asc ';

        $result         = User::select('id','name','phone','role_id','status','company_id')
                            ->where('master', '=', false)
                            ->where('company_id', '=', $request->user()->company_id)
                            ->filter($request['query'],$request['qtype'])
                            ->orderBy($sortname,$sortorder)
                            ->offset($start)
                            ->limit($rp)
                            ->get();
        
        $result_total   = User::select('id')
                            ->where('master', '=', false)
                            ->where('company_id', '=', $request->user()->company_id)
                            ->filter($request['query'],$request['qtype'])
                            ->count();                  
        $data = $_POST;
        $data['total'] = ($result_total<100)? $result_total : 100;
        $array_default = array();
        $array_data = array();
        foreach ($result as $row){
            $rows['ID'] = $row->id;
            if($row->status=='Disabled'){
                $label_status='<i class="text-danger">'.$row->status.'</i>';
            }else if($row->status=='Enabled') {
                $label_status='<i class="text-primary">'.$row->status.'</i>';
            }else{
                $label_status='<i class="text-warning">'.$row->status.'</i>';
            }  
            
            $array_data['cell'] =array($row->id,$row->name,$row->phone,Str::of($row->role_id)->replaceFirst($row->company_id,''),$label_status);
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
    public function create(Request $request)
    {
        $this->breadcrumb->add(__('label.home'), '/');
        $this->breadcrumb->add(__('label.users'), '/users');
        $this->breadcrumb->add(__('button.create'), '/users/create');
		$data['breadcrumbs']    = $this->breadcrumb->render();
        $data['title']          = __('label.user_create');
        $data['roles']          = Roles::select('id','role_name')->where('company_id',$request->user()->company_id)->get();
        return view('home.users_create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'       => 'required|max:10|unique:users,id|alpha_num',
            'name'          => 'required|max:100',
            'phone'         => 'max:15',
            'roles'         => 'required',
            'password'      => 'required|confirmed',
        ]);

        if(User::create([
            'id'                => $request->user_id,
            'name'              => $request->name,
            'email'             => $request->user_id.'@hastioapps.com',
            'phone'             => $request->phone, 
            'password'          => Hash::make($request->password),
            'role_id'           => $request->roles, 
            'started'           => 'Ok',
            'master'            => false,
            'email_verified_at' => now(),
            'company_id'        => $request->user()->company_id, 
        ])){
            $request->session()->flash('success',__('alert.after_save'));
            return redirect()->route('users');
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
        $users=User::select('id','name','phone','role_id','company_id','status','created_at','updated_at')
                    ->where([
                        'id'=>$request->id,
                        'master'=>false,
                        'company_id'=>$request->user()->company_id])
                    ->first();

        if (isset($users)){
            if (is_file('storage/users-img/'.$users->img)){
                $temp=asset('storage/users-img/'.$users->img);
            }else{
                $temp=url('assets/img/default.png');
            }

            $text='<div class="table-responsive p-0" style="max-height: 450px">
                <table class="table table-head-fixed table-sm">
                    <thead>
                        <tr>
                            <th colspan="3" class="text-center"><img class="profile-user-img img-fluid" src="'.$temp.'" alt="..."></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width:20%">User ID</td>
                            <td style="width:5%">:</td>
                            <td style="width:75%">'.$users->id.'</td>
                        </tr>
                        <tr>
                            <td style="width:20%">'.__("label.name").'</td>
                            <td style="width:5%">:</td>
                            <td style="width:75%">'.$users->name.'</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>:</td>
                            <td>'.$users->phone.'</td>
                        </tr>
                        <tr>
                            <td>'.__("label.roles").'</td>
                            <td>:</td>
                            <td>'.Str::of($users->role_id)->replaceFirst($users->company_id,'').'</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td>'.$users->status.'</td>
                        </tr>
                        <tr>
                            <td>'.__("label.created_at").'</td>
                            <td>:</td>
                            <td>'.$users->created_at.'</td>
                        </tr>
                        <tr>
                            <td>'.__("label.updated_at").'</td>
                            <td>:</td>
                            <td>'.$users->updated_at.'</td>
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
        $this->breadcrumb->add(__('label.users'), '/users');
        $this->breadcrumb->add(__('button.edit'), '/users/'.$id.'/edit');
		$data['breadcrumbs']    = $this->breadcrumb->render();
        $data['title']          = __('label.user_edit');
        $data['roles']          = Roles::select('id','role_name')->where('company_id',$request->user()->company_id)->get();
        $data['users']          = User::select('id','name','phone','role_id')->where(['id'=>$id,'master'=>false,'company_id'=>$request->user()->company_id])->first();
        if (isset($data['users'])){
            return view('home.users_edit',$data);
        }else{
            $data['id']=$id;
            $data['back']='users';
            return view('layouts.not_found',$data);
        }
    }

    public function reset(Request $request,$id)
    {
        $this->breadcrumb->add(__('label.home'), '/');
        $this->breadcrumb->add(__('label.users'), '/users');
        $this->breadcrumb->add(__('auth.reset_password'), '/users'.$id.'/reset');
		$data['breadcrumbs']    = $this->breadcrumb->render();
        $data['title']          = __('auth.reset_password');
        $data['users']          = User::select('id')->where(['id'=>$id,'master'=>false,'company_id'=>$request->user()->company_id])->first();
        if (isset($data['users'])){
            return view('home.users_reset',$data);
        }else{
            $data['id']=$id;
            $data['back']='users';
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
        if (isset($request['btnReset'])){
            $request->validate([
                'password'      => 'required|confirmed',
            ]);

            if(User::where(['id'=>$id,'master'=>false,'company_id'=>$request->user()->company_id])->update([
                'password'      => Hash::make($request->password),
            ])){
                $request->session()->flash('success',__('alert.after_update'));
                return redirect()->route('users');
            } else {
                $request->session()->flash('warning',__('alert.failed_save'));
                return back();
            }
        }else{
            $request->validate([
                'name'          => 'required|max:100',
                'phone'         => 'max:15',
                'roles'         => 'required',
            ]);

            if(User::where(['id'=>$id,'master'=>false,'company_id'=>$request->user()->company_id])->update([
                'name'              => $request->name,
                'phone'             => $request->phone, 
                'role_id'           => $request->roles, 
            ])){
                $request->session()->flash('success',__('alert.after_update'));
                return redirect()->route('users');
            } else {
                $request->session()->flash('warning',__('alert.failed_save'));
                return back();
            }
        }
    }

    public function status(Request $request)
    {
        if ($request['id']){
            $id=$request->id;
            $status=$request->status;
            if ($status=='Enabled'){
                $status_change='Disabled';
            }else{
                $status_change='Enabled';
            }

            if (User::where('id',$id)->update(['status'=> $status_change])){
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

    public function branch_roles(Request $request, $id)
    {
        $this->breadcrumb->add(__('label.home'), '/');
        $this->breadcrumb->add(__('label.users'), '/users');
        $this->breadcrumb->add($id, '/users/'.$id.'branch_roles');
		$data['breadcrumbs']    = $this->breadcrumb->render();
        $data['title']          = $id;
        $data['users']          = User::select('id','company_id')->where(['id'=>$id,'master'=>false,'company_id'=>$request->user()->company_id])->first();
        if (isset($data['users'])){
            return view('home.users_branch_roles',$data);
        }else{
            $data['id']=$id;
            $data['back']='users';
            return view('layouts.not_found',$data);
        }
    }

    public function duallist(Request $request)
    {
        if ($request['id']){
            $user_id=$request->id;
            $result = Branches::select('branches.id', 'branches.code', 'branches.name', 'branch_roles.user_id as selected')
                                ->leftJoin('branch_roles', function ($join) use ($user_id) {
                                    $join->on('branches.id', '=', 'branch_roles.branch_id')->where('branch_roles.user_id', '=', $user_id);
                                })
                                ->where('branches.company_id',$request->company_id)
                                ->get();
        	foreach ($result  as $branch) {
                if ($branch->selected==$user_id){
                    $selected=true;
                }else{
                    $selected=false;
                }
                $dataArray[]= array("item"=> $branch->code.' - '.$branch->name,"value"=> $branch->id,"selected"=> $selected);
            }
            return json_encode($dataArray);
        }else if ($request['code']){
	        $user_id=$request->code;
        	if(!isset($request->data)){
        		Branch_roles::where('user_id',$user_id)->delete();
        		$alert['alert']= 'Success';
        		$alert['message']=__('alert.after_save');
        	}else{
        		$data=$request->data;
	        	$branches=array();
	        	foreach ($data as $branch) {
		        	$id=$branch.$user_id;
		        	$branches[]=array("id"=>$id, "user_id"=>$user_id, "branch_id"=>$branch);
		        }
                Branch_roles::where('user_id',$user_id)->delete();
                if(Branch_roles::insert($branches)){
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
}
