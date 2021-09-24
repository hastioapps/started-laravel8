@extends('layouts.main')
@section('content')
<div class="col-lg-12">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h5 class="card-title">{{ $title ?? __('label.no_title') }}</h5>
            <div class="card-tools">
                <a type="button" href="{{ route('users') }}" class="btn btn-tool" ><i class="fas fa-times"></i></a>
            </div>
        </div>
        <form action="{{ url('users/'.$users->username) }}" method="post" class="form-horizontal">
            @method('put')
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">{{ __('auth.password') }}*:</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <input value="" class="form-control form-control-sm @error('password') is-invalid @enderror" id="password" name="password" type="password" required/>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">{{ __('auth.re_password') }}*:</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <input value="" class="form-control form-control-sm" id="password_confirmation" name="password_confirmation" type="password" required/>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" id="btnReset" name="btnReset" class="btn btn-info btn-sm float-right">{{ __('button.save') }}</button>
            </div>
        </form>
    </div>        	
</div>
@endsection