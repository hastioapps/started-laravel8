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
        <form action="{{ url('roles/'.$id) }}" method="post" class="form-horizontal">
            @method('delete')
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-lg-10 col-md-10 col-sm-12 col-xs-12 control-label">{{ __('alert.confirm_delete') }} "<b>{{ $id }}</b>"</label>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <input value="" class="form-control form-control-sm @error('role') is-invalid @enderror" id="role" name="role" type="text" maxlength="20" required/>
                        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        @error('role_id') <label class="text-danger text-xs"> {{ $message }}</label>@enderror
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" id="btnAdd" name="btnAdd" class="btn btn-danger btn-sm float-right">{{ __('button.delete') }}</button>
            </div>
        </form>
    </div>        	
</div>
@endsection