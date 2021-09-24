@extends('layouts.main')
@section('content')
<div class="col-lg-12">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h5 class="card-title">{{ $title ?? __('label.no_title') }}</h5>
            <div class="card-tools">
                <a type="button" href="{{ $back?? url('home') }}" class="btn btn-tool" ><i class="fas fa-times"></i></a>
            </div>
        </div>
        <div class="card-body">
            {{ __('alert.data_not_found') }}
        </div>
    </div>        	
</div>
@endsection