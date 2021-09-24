@extends('layouts.main')
@section('content')
<div class="col-12">
    <div class="card card-primary card-outline">
        <div class="card-header box-profile">
            <div class="card-tools">
                <a type="button" href="{{ route('home') }}" class="btn btn-tool" ><i class="fas fa-times"></i></a>
            </div>
            <br>
            <div class="text-center">
                <a href="#" class="userImg">
                    <img class="profile-user-img img-fluid" src="{{ (is_file('storage/users-img/'.Request::user()->img))? asset('storage/users-img/'.Request::user()->img):url('assets/img/default.png')}}" alt="...">
                </a>
            </div>
            <h3 class="profile-username text-center">{{ Request::user()->username }}</h3>
            <p class="text-muted text-center">{{ Str::of(Request::user()->role_id)->ltrim(Request::user()->company_id) }}</p>
            @error('password')
                <script type="text/javascript">
                    $(document).ready(function (){ 
                        toastr.warning("{{ $message }}");
                    });
                </script>
            @enderror
            <div class="row">
                <div class="col-5 col-sm-3">
                    <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="vert-tabs-profile-tab" data-toggle="pill" href="#vert-tabs-profile" role="tab" aria-controls="vert-tabs-profile" aria-selected="true">{{ __('label.profile') }}</a>
                        <a class="nav-link" id="vert-tabs-password-tab" data-toggle="pill" href="#vert-tabs-password" role="tab" aria-controls="vert-tabs-password" aria-selected="false">{{ __('auth.reset_password') }}</a>
                    </div>
                </div>
                <div class="col-7 col-sm-9">
                    <div class="tab-content" id="vert-tabs-tabContent">
                        <div class="tab-pane text-left fade show active" id="vert-tabs-profile" role="tabpanel" aria-labelledby="vert-tabs-profile-tab">
                            <div class="table-responsive p-0">
                                <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <td style="width:20%">{{ __('label.name') }}</td>
                                        <td style="width:5%">:</td>
                                        <td style="width:75%"><input value="{{ Request::user()->name }}" class="form-control form-control-sm" maxlength="100" id="txtName" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>:</td>
                                        <td>{{ Request::user()->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td>:</td>
                                        <td><input value="{{ Request::user()->phone }}" class="form-control form-control-sm" id="txtPhone" maxlength="15" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <td>Master</td>
                                        <td>:</td>
                                        <td>{{ (Request::user()->master)? 'True':'False' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('label.created_at') }}</td>
                                        <td>:</td>
                                        <td>{{ Request::user()->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('label.updated_at') }}</td>
                                        <td>:</td>
                                        <td>{{ Request::user()->updated_at }}</td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-password" role="tabpanel" aria-labelledby="vert-tabs-password-tab">
                            <form action="{{ url('profile/change_password') }}" method="POST">
                                @csrf
                                <div class="form-group row mb-2">
                                    <label class="col-sm-2 col-form-label">{{ __('auth.new_password') }}</label>
                                    <div class="col-sm-10">
                                        <input value="" class="form-control form-control-sm @error('password') is-invalid @enderror" id="password" name="password" type="password" required/>
                                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-sm-2 col-form-label">{{ __('auth.re_password') }}</label>
                                    <div class="col-sm-10">
                                        <input value="" class="form-control form-control-sm" id="password_confirmation" name="password_confirmation" type="password" required/>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal upload-->
<div class="modal fade" id="modalLogo">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <form class="form-horizontal" action="#">
                    <div class="input-group input-group-sm">
                        <input type="file" name="file"  id="file" class="form-control">
                        <span class="input-group-append">
                        <button type="submit" class="btn btn-default btn-flat" name="btnLogo" id="btnLogo"><i class="fa fa-upload"></i></button>
                        </span>
                    </div>
                </form>   
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#txtName").change(function(){
        var txtName=$("#txtName").val();
        $.ajax({
            type      : "POST",
            dataType  : "json",
            url       : 'profile/change_atribute',
            data      : 'changeName='+txtName,
            success : function(data){
                if (data.alert=='Error'){
                    toastr.error(data.message);
                }else if (data.alert=='Warning'){
                    toastr.warning(data.message);
                }else if (data.alert=='Success'){
                    toastr.success(data.message);
                }
            }
        });
    });

    
    $("#txtPhone").change(function(){
        var txtPhone=$("#txtPhone").val();
        $.ajax({
            type      : "POST",
            dataType  : "json",
            url       : 'profile/change_atribute',
            data      : 'changePhone='+txtPhone,
            success : function(data){
                if (data.alert=='Error'){
                    toastr.error(data.message);
                }else if (data.alert=='Warning'){
                    toastr.warning(data.message);
                }else if (data.alert=='Success'){
                    toastr.success(data.message);
                }
            }
        });
    });

    $('.userImg').click(function (){
        $('#modalLogo').modal('show');
        return false;
    });

    $(document).on('click','#btnLogo',function(e){
            e.preventDefault();
            if ($('#file').val()!=''){
                var form_data = new FormData();
                form_data.append('file', $('#file').prop('files')[0]);
                form_data.append('id', '{{ Request::user()->id }}');
                $.ajax({
                    type    : "POST",
                    dataType : "json",
                    url: 'profile/change_atribute',
                    data: form_data,
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $(".userImg").LoadingOverlay("show");
                        $('#modalLogo').modal('hide');
                    },success: function(json){
                        $(".userImg").LoadingOverlay("hide");
                        $('#file').val('');
                        if (json.alert=='Error'){
                            toastr.error(json.message);
                        }else if (json.alert=='Warning'){
                            toastr.warning(json.message);
                        }else if (json.alert=='Success'){
                            $('#modalLogo').modal('hide');
                            toastr.success(json.message);
                            $(".userImg").html(json.img);
                        }
                    }
                });
            }
        });
</script>
@endsection
