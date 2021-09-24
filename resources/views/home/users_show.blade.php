@extends('layouts.main')
@section('content')
<div class="col-12">
    <div class="card card-primary card-outline">
        <div class="card-header box-profile">
            <div class="card-tools">
                <a type="button" href="{{ route('users.create') }}" class="btn btn-tool" ><i class="fas fa-plus"></i></a>
                <a type="button" href="{{ url('users/'.$users->username.'/edit') }}" class="btn btn-tool" ><i class="fas fa-edit"></i></a>
                <a type="button" href="{{ url('users/'.$users->username.'/reset') }}" class="btn btn-tool" ><i class="fas fa-key"></i></a>
                <a type="button" href="{{ route('users') }}" class="btn btn-tool" ><i class="fas fa-times"></i></a>
            </div>
            <br>
            <div class="text-center">
                <a href="#" class="userImg">
                    <img class="profile-user-img img-fluid" src="{{ (is_file('storage/users-img/'.$users->img))? asset('storage/users-img/'.$users->img):url('assets/img/default.png')}}" alt="...">
                </a>
            </div>
            <h3 class="profile-username text-center">{{ $users->username }}</h3>
            <p class="text-muted text-center">{{ Str::of($users->role_id)->ltrim($users->company_id) }}</p>
            <div class="row">
                    <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <td style="width:20%">{{ __('label.name') }}</td>
                                        <td style="width:5%">:</td>
                                        <td style="width:75%">{{ $users->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td>:</td>
                                        <td>{{ $users->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td>Master</td>
                                        <td>:</td>
                                        <td>{{ ($users->master)? 'True':'False' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('label.created_at') }}</td>
                                        <td>:</td>
                                        <td>{{ $users->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('label.updated_at') }}</td>
                                        <td>:</td>
                                        <td>{{ $users->updated_at }}</td>
                                    </tr>
                                </tbody>
                    </table>
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
