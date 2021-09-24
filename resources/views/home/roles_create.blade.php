@extends('layouts.main')
@section('content')
<div class="col-lg-12">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h5 class="card-title">{{ $title ?? __('label.no_title') }}</h5>
            <div class="card-tools">
                <a type="button" href="{{ route('roles') }}" class="btn btn-tool" ><i class="fas fa-times"></i></a>
            </div>
        </div>
        <form action="{{ url('roles') }}" method="post" class="form-horizontal">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">{{ __('label.roles') }}*:</label>
                    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                        <input value="{{ old('role_name') }}" class="form-control form-control-sm @error('role_name') is-invalid @enderror" id="role_name" name="role_name" type="text" maxlength="20" required/>
                        @error('role_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        @error('role') <label class="text-danger text-xs"> {{ $message }}</label>@enderror
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" id="btnAdd" name="btnAdd" class="btn btn-info btn-sm float-right">{{ __('button.save') }}</button>
            </div>
        </form>
    </div>        	
</div>
@endsection