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

<script type="text/javascript">
	$(document).ready(function (){
		$('#dataDisplays').flexigrid({
    		url: "{{ url('roles/flexigrid') }}",
    		dataType: 'json',
            buttons : [ {name : '<i class="fa fa-plus fa-xs"></i>',tooltip:'{{ __("button.create") }}',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-times fa-xs"></i>',tooltip:'{{ __("button.delete") }}',bclass : 'btn btn-danger btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-folder-open fa-xs"></i>',tooltip:'{{ __("button.open") }}',bclass : 'btn btn-primary btn-xs',onpress : btnAction}
            ],
    		colModel : [
                {display: '{{ __("label.roles") }}', name : 'role_name',width:600, sortable : true, align: 'left', process: celDivAction},
            ],
    		searchitems : false,
    		sortname: 'role_name',
    		sortorder: 'asc',
    		usepager: true,
    		title: false,
    		useRp: false,
    		rp: 10,
            height:320,
            resizable: false,
            autoload: true,
            singleSelect: true,
            procmsg: 'please wait ...'
            }
        );

        $('#btnSearch').click(function(){
            $('#dataDisplays').flexOptions({ query: $(".dataSearch").val(),qtype: 'role_name', rp: 10,sortname: 'role_name', sortorder: 'asc' }).flexReload();
            return false;
        });

        function celDivAction(celDiv) {
            $( celDiv ).dblclick( function() {
                var roles = $(this).parent().parent().children('td').eq(0).text();
                document.location.href='roles/'+roles;
            });    
        }

        function btnAction(action,grid) {
            var roles=$('.trSelected',grid).children('td').eq(0).text();
            if (action == '<i class="fa fa-plus fa-xs"></i>') {
                document.location.href='roles/create';
            }else if (action == '<i class="fa fa-folder-open fa-xs"></i>') {
                if ($('.trSelected',grid).length != 1) {
                    toastr.warning('{{ __("alert.data_not_selected") }}');
                }else{
                    document.location.href='roles/'+roles;
                }
            }else if (action == '<i class="fa fa-times fa-xs"></i>') {
                if ($('.trSelected',grid).length != 1) {
                    toastr.warning('{{ __("alert.data_not_selected") }}');
                }else{
                    document.location.href='roles/'+roles+'/delete';
                }
            }
        }
	});
</script>
@endsection