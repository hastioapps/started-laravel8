@extends('layouts.main')
@section('content')
<div class="col-lg-12">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h5 class="card-title">{{ $title ?? __('label.no_title') }}</h5>
            <div class="card-tools">
                <a type="button" href="{{ route('branches') }}" class="btn btn-tool" ><i class="fas fa-times"></i></a>
            </div>
        </div>
        <form action="{{ url('branches') }}" method="post" class="form-horizontal">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">{{ __('label.code') }}*:</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <input value="{{ old('code') }}" class="form-control form-control-sm @error('code') is-invalid @enderror" id="code" name="code" type="text" maxlength="4" required/>
                        @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        @error('id') <label class="text-danger text-xs"> {{ $message }}</label>@enderror
                    </div>
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">{{ __('label.branches') }}*:</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <input value="{{ old('name') }}" class="form-control form-control-sm @error('name') is-invalid @enderror" id="name" name="name" type="text" maxlength="100" required/>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">{{ __('label.address') }}*:</label>
                    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                        <textarea class="form-control form-control-sm @error('address') is-invalid @enderror" name="address" id="address" required>{{ old('address') }}</textarea>
                        @error('address') <label class="invalid-feedback"> {{ $message }}</label> @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">Phone:</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <input value="{{ old('phone') }}" type="text" name="phone" id="phone" maxlength="15" class="form-control form-control-sm @error('phone') is-invalid @enderror">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">Email:</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <input value="{{ old('email') }}" type="email" name="email" max="225" id="email" class="form-control form-control-sm @error('email') is-invalid @enderror">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">Manager*:</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <input value="{{ old('manager') }}" type="text" name="manager" id="manager" maxlength="100" class="form-control form-control-sm  @error('manager') is-invalid @enderror" required>
                        @error('manager') <div class="invalid-feedback">{{ $message }}</div> @enderror
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