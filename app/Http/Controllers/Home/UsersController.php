<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Roles;

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

        $result         = User::select('username','name','phone','role_id','status','company_id')
                            ->where('master', '=', false)
                            ->where('company_id', '=', $request->user()->company_id)
                            ->filter($request['query'],$request['qtype'])
                            ->orderBy($sortname,$sortorder)
                            ->offset($start)
                            ->limit($rp)
                            ->get();
        
        $result_total   = User::select('username')
                            ->where('master', '=', false)
                            ->where('company_id', '=', $request->user()->company_id)
                            ->filter($request['query'],$request['qtype'])
                            ->count();                  
        $data = $_POST;
        $data['total'] = ($result_total<100)? $result_total : 100;
        $array_default = array();
        $array_data = array();
        foreach ($result as $row){
            $rows['ID'] = $row->username;
            if($row->status=='Disabled'){
                $label_status='<i class="text-danger">'.$row->status.'</i>';
            }else if($row->status=='Enabled') {
                $label_status='<i class="text-primary">'.$row->status.'</i>';
            }else{
                $label_status='<i class="text-warning">'.$row->status.'</i>';
            }  
            
            $array_data['cell'] =array($row->username,$row->name,$row->phone,Str::of($row->role_id)->ltrim($row->company_id),$label_status);
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
            'username'      => 'required|max:10|unique:users,username|alpha_num',
            'name'          => 'required|max:100',
            'phone'         => 'max:15',
            'roles'         => 'required',
            'password'      => 'required|confirmed',
        ]);

        if(User::create([
            'username'          => $request->username,
            'name'              => $request->name,
            'email'             => $request->username.'@hastioapps.com',
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
        $users=User::select('username','name','phone','role_id','company_id','status','created_at','updated_at')
                    ->where([
                        'username'=>$request->username,
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
                            <td style="width:20%">Username</td>
                            <td style="width:5%">:</td>
                            <td style="width:75%">'.$users->username.'</td>
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
                            <td>'.Str::of($users->role_id)->ltrim($users->company_id).'</td>
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
            return __('alert.data_not_found');
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
        $this->breadcrumb->add(__('button.edit'), '/users'.$id.'/edit');
		$data['breadcrumbs']    = $this->breadcrumb->render();
        $data['title']          = __('label.user_edit');
        $data['roles']          = Roles::select('id','role_name')->where('company_id',$request->user()->company_id)->get();
        $data['users']          = User::select('username','name','phone','role_id')->where(['username'=>$id,'master'=>false,'company_id'=>$request->user()->company_id])->first();
        if (isset($data['users'])){
            return view('home.users_edit',$data);
        }else{
            $data['back']=route('users');
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
        $data['users']          = User::select('username')->where(['username'=>$id,'master'=>false,'company_id'=>$request->user()->company_id])->first();
        if (isset($data['users'])){
            return view('home.users_reset',$data);
        }else{
            $data['back']=route('users');
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

            if(User::where(['username'=>$id,'master'=>false,'company_id'=>$request->user()->company_id])->update([
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

            if(User::where(['username'=>$id,'master'=>false,'company_id'=>$request->user()->company_id])->update([
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
        if ($request['username']){
            $username=$request->username;
            $status=$request->status;
            if ($status=='Enabled'){
                $status_change='Disabled';
            }else{
                $status_change='Enabled';
            }

            if (User::where('username',$username)->update(['status'=> $status_change])){
                $alert['alert']= 'Success';
                $alert['message']=$username.' status '.$status_change;
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
