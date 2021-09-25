@extends('layouts.main')
@section('content')
<div class="col-lg-12">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h5 class="card-title">{{ $title ?? __('label.no_title') }}</h5>
            <div class="card-tools">
                <a type="button" href="{{ route('users') }}" class="btn btn-tool" ><i class="fas fa-times"></i></a>
            </div>
            <br>
            <div class="text-center">
                <a href="#" class="userImg">
                    <img class="profile-user-img img-fluid" src="{{ (is_file('storage/users-img/'.$users->img))? asset('storage/users-img/'.$users->img):url('assets/img/default.png')}}" alt="...">
                </a>
            </div>
        </div>
        <form action="{{ url('users/'.$users->username) }}" method="post" class="form-horizontal">
            @method('put')
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">{{ __('label.full_name') }}*:</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <input value="{{ old('name',$users->name) }}" class="form-control form-control-sm @error('name') is-invalid @enderror" id="name" name="name" type="text" maxlength="100" required/>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">Phone:</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <input value="{{ old('phone',$users->phone) }}" class="form-control form-control-sm @error('phone') is-invalid @enderror" id="phone" name="phone" type="text" maxlength="15"/>
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">{{ __('label.roles') }}*:</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <select name="roles" id="roles" class="form-control form-control-sm" required>
                            <option value="Admin" {{ (old('roles',$users->role_id) == 'Admin') ? "selected":"" }}>Admin</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ (old('roles',$users->role_id) == $role->id) ? "selected":"" }}>{{ $role->role_name }}</option>
                            @endforeach
                        </select>
                        @error('roles') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" id="btnEdit" name="btnEdit" class="btn btn-info btn-sm float-right">{{ __('button.save') }}</button>
            </div>
        </form>
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
    $('.userImg').click(function (){
        $('#modalLogo').modal('show');
        return false;
    });

    $(document).on('click','#btnLogo',function(e){
            e.preventDefault();
            if ($('#file').val()!=''){
                var form_data = new FormData();
                form_data.append('file', $('#file').prop('files')[0]);
                form_data.append('id', '{{ $users->id }}');
                $.ajax({
                    type    : "POST",
                    dataType : "json",
                    url:'{{ url("profile/change_atribute") }}',
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