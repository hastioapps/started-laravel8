@extends('layouts.main')
@section('content')
<div class="col-lg-12">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h5 class="card-title">{{ $title ?? __('label.no_title') }}</h5>
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 200px;">
                    <input type="text" placeholder="{{ __('button.search') }}..." class="form-control float-right dataSearch">
                    <select name="cmbKey" id="cmbKey" class="form-control">
                        <option value="username">Username</option>
                        <option value="name">{{ __('label.name') }}</option>
                        <option value="status">Status</option>
                    </select>
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
    		url: "/users/flexigrid",
    		dataType: 'json',
            buttons : [ {name : '<i class="fa fa-plus fa-xs"></i>',tooltip:'Tambah',bclass : 'btn btn-primary btn-xs',onpress : btnAction}
            ],
    		colModel : [
                {display: 'Username', name : 'username',width:100, sortable : true, align: 'left', process: celDivAction},
                {display: 'Nama', name : 'name',width:250, sortable : true, align: 'left', process: celDivAction},
                {display: 'Email', name : 'email',width:250, sortable : true, align: 'left', process: celDivAction},
                {display: 'Phone', name : 'phone',width:150, sortable : true, align: 'left', process: celDivAction},
                {display: 'Master', name : 'master',width:100, sortable : true, align: 'left', process: celDivAction},
                {display: 'Peran', name : 'role_id',width:100, align: 'left', process: celDivAction},
                {display: 'Status', name : 'status',width:80, align: 'left', process: celDivAction}
            ],
    		searchitems : false,
    		sortname: 'id',
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
            $('#dataDisplays').flexOptions({ query: $(".dataSearch").val(),qtype: $("#cmbKey").val(), rp: 10,sortname: 'id', sortorder: 'asc' }).flexReload();
            return false;
        });

        function celDivAction(celDiv) {
            $( celDiv ).dblclick( function() {
                var username = $(this).parent().parent().children('td').eq(0).text();
            });    
        }

        function btnAction(action,grid) {
            var username=$('.trSelected',grid).children('td').eq(0).text();
            if (action == '<i class="fa fa-plus fa-xs"></i>') {
                //
            }
        }
	});
</script>
@endsection