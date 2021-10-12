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
        <div class="tcode"></div>
    </div>        	
</div>
<script type="text/javascript">
	$(document).ready(function (){
		$.ajax({
            type        : "POST",
            dataType    : "json",
            url         : "{{ url('users/duallist') }}",
            data        : "id={{ $users->id }}&company_id={{ $users->company_id }}",
            success     : function(dataArray){
                var settings = {
                    "dataArray": dataArray,
                    "tabNameText": "Disabled",
                    "rightTabNameText": "Enabled",
                    "callable": function (items) {
                        var totalArray=items.length;
                        var data=[];
                        for (i=0;i<totalArray;i++){
                            data.push(items[i]['value']);
                        }
                        $.ajax({
                            type        : "POST",
                            dataType    : "json",
                            url         : "{{ url('users/duallist') }}",
                            data        : {code:"{{ $users->id }}",data:data},
                            success     : function(json){
                                if (json.alert=='Error'){
                                    toastr.error(json.message);
                                }else if (json.alert=='Warning'){
                                    toastr.warning(json.message);
                                }else if (json.alert=='Success'){
                                    toastr.success(json.message);
                                }
                            }
                        });
                    }
                };
                $(".tcode").transfer(settings);
            }
        });
	});
</script>
@endsection