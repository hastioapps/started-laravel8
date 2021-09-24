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
            return redirect()->to(url('users/'.$request->username));
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
        $this->breadcrumb->add(__('label.users'), '/users');
        $this->breadcrumb->add($id, '/users/'.$id);
		$data['breadcrumbs']    = $this->breadcrumb->render();
        $data['title']          = __('label.users').': '.$id;
        $data['users']          = User::select('*')->where(['username'=>$id,'master'=>false,'company_id'=>$request->user()->company_id])->first();
        if (isset($data['users'])){
            return view('home.users_show',$data);
        }else{
            $data['back']=route('users');
            return view('layouts.not_found',$data);
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
                return redirect()->to(url('users/'.$id));
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
                return redirect()->to(url('users/'.$id));
            } else {
                $request->session()->flash('warning',__('alert.failed_save'));
                return back();
            }
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
}
