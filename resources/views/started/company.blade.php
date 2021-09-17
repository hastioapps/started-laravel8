@extends('layouts.main')
@section('content')
<div class="col-lg-12">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h5 class="card-title">{{ $title ?? __('label.no_title') }}</h5>
        </div>
        <form action="{{ url('started/company') }}" method="post" class="form-horizontal">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">{{ __('company.company_name') }}*:</label>
                    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                        <input value="{{  Request::user()->name }}" type="text" name="name" id="name" maxlength="100" class="form-control form-control-border border-width-2 form-control-sm @error('name') is-invalid @enderror" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">{{ __('company.company_address') }}*:</label>
                    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                        <textarea class="form-control form-control-border border-width-2 form-control-sm @error('address') is-invalid @enderror" name="address" id="address" required>{{ old('address') }}</textarea>
                        @error('address') <label class="invalid-feedback"> {{ $message }}</label> @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">Phone:</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <input value="{{ old('phone') }}" type="text" name="phone" id="phone" maxlength="15" class="form-control form-control-border border-width-2 form-control-sm @error('phone') is-invalid @enderror">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">Email:</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <input value="{{ old('email') }}" type="email" name="email" max="225" id="email" class="form-control form-control-border border-width-2 form-control-sm @error('email') is-invalid @enderror">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">{{ __('company.owner') }}*:</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <input value="{{ old('owner') }}" type="text" name="owner" id="owner" maxlength="100" class="form-control form-control-border border-width-2 form-control-sm  @error('owner') is-invalid @enderror" required>
                        @error('owner') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">{{ __('label.currency') }}*:</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <select name="currency" id="currency" class="form-control form-control-border border-width-2 form-control-sm @error('currency') is-invalid @enderror" required>
                            <option value="">--- ---</option>
                            @foreach ($currency as $currency)
                                <option value="{{ $currency->id }}" {{ (old("currency") == $currency->id ? "selected":"") }}>{{ $currency->id.' - '.$currency->description }}</option>
                            @endforeach
                        </select>
                        @error('currency') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <div class="card-header">
                <h5 class="card-title">{{ __('label.tax') }}</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">{{ __('company.npwp') }}:</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <input value="{{ old('npwp') }}" type="text" name="npwp" id="npwp" maxlength="25" class="form-control form-control-border border-width-2 form-control-sm @error('npwp') is-invalid @enderror">
                        @error('npwp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">{{ __('company.npwp_name') }}:</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <input value="{{ old('npwp_name') }}" type="text" name="npwp_name" id="npwp_name" maxlength="100" class="form-control form-control-border border-width-2 form-control-sm @error('npwp_name') is-invalid @enderror">
                        @error('npwp_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">{{ __('company.npwp_address') }}:</label>
                    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                        <textarea class="form-control form-control-border border-width-2 form-control-sm" name="npwp_address" id="npwp_address">{{ old('npwp_address') }}</textarea>
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