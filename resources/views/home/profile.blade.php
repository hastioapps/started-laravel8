@extends('layouts.main')
@section('content')
<div class="col-12">
    <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            <div class="text-center">
            <img class="profile-user-img img-fluid img-circle"
                src="{{ (is_file(url('assets/img/'.Request::user()->image)))? url('assets/img/'.Request::user()->image):url('assets/img/default.png')}}"
                alt="User profile picture">
            </div>
            <h3 class="profile-username text-center">{{ Request::user()->name }}</h3>
            <p class="text-muted text-center">{{ Request::user()->role_id }}</p>
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
                                        <td style="width:20%">Username</td>
                                        <td style="width:5%">:</td>
                                        <td style="width:75%">{{ Request::user()->username }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>:</td>
                                        <td>{{ Request::user()->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td>:</td>
                                        <td>{{ Request::user()->phone }}</td>
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
                                </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-password" role="tabpanel" aria-labelledby="vert-tabs-password-tab">
                            <form action="{{ url('profile') }}" method="POST">
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
@endsection
