@extends('layouts.main')
@section('content')
<div class="col-lg-12">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h5 class="card-title">{{ $title ?? __('label.no_title') }}</h5>
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 200px;">
                    <input type="text" placeholder="{{ __('button.search') }}..." class="form-control float-right dataSearch">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-default" id="btnSearch"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <table id="dataDisplays" style="display:none"></table>
    </div>        	
</div>
@endsection