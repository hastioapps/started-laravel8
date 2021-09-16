$(document).ready(function (){
    contentFavorite();

    $("#myFavorite").click(function(){
        $('#modalDisplays').modal('show');
    	myFavoriteGrid();
    });  

    $('#btnSearch').click(function(){
        $('#dataDisplays').flexOptions({ query: $(".dataSearch").val(), rp: 10,sortname: 'tcode_id', sortorder: 'asc' }).flexReload();
        return false;
    });
});

function myFavoriteGrid(){
	$('#dataDisplays').flexigrid({
    		url: base_url+"/home/getmyfavorite",
    		dataType: 'json',
            buttons : [ {name : '<i class="fa fa-plus fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnAction}],
    		colModel : 
    			[
    				{display: 'Tcode', name : 'tcode_id',width:50, sortable : true, align: 'left', process: celDivAction},
    	            {display: 'Label', name : 'tcode_label',width:200, sortable : true, align: 'left', process: celDivAction},
    				{display: 'URL', name : 'tcode_url',width:300, sortable : true, align: 'left', process: celDivAction}
    			],
    		searchitems : false,
    		sortname: 'tcode_id',
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
}

function celDivAction(celDiv) {
    $( celDiv ).dblclick( function() {
        var ID = $(this).parent().parent().children('td').eq(0).text();
 		$.ajax({
                type    : "POST",
                dataType : "json",
                url     : base_url+"/home/actionmyfavorite",
                data    : "addTcode=add"+"&tcode="+ID,
                success : function(json){
                    if (json.alert=='Error'){
                        toastr.error(json.message);
                        $("#getTcode").val('');
                    }else if (json.alert=='Session'){
                        toastr.error(json.message);
                        setTimeout(function (){location.href=base_url+"/auth/login";},1000);
                    }else if (json.alert=='Sukses'){
                        $('#dataDisplays').flexReload();
                        contentFavorite();
                    }
                }
        });
    });    
}

function btnAction(action,grid) {
    var ID=$('.trSelected',grid).children('td').eq(0).text();
    if (action == '<i class="fa fa-plus fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            $.ajax({
                type    : "POST",
                dataType : "json",
                url     : base_url+"/home/actionmyfavorite",
                data    : "addTcode=add"+"&tcode="+ID,
                success : function(json){
                    if (json.alert=='Error'){
                        toastr.error(json.message);
                        $("#getTcode").val('');
                    }else if (json.alert=='Session'){
                        toastr.error(json.message);
                        setTimeout(function (){location.href=base_url+"/auth/login";},1000);
                    }else if (json.alert=='Sukses'){
                        $('#dataDisplays').flexReload();
                        contentFavorite();
                    }
                }
            });
        }
    }
}

function contentFavorite(){
    $.ajax({
        type    : "POST",
        url     : base_url+"/home/actionmyfavorite",
        data    : "contentFavorite=getData",
        success : function(data){
            $("#dataFavorite").html(data);            
        }
    });
}

function deleteFavorite(tcode){
    $.ajax({
                type    : "POST",
                url     : base_url+"/home/actionmyfavorite",
                data    : "deleteTcode=delete"+"&tcode="+tcode,
                success : function(json){
                    if (json.alert=='Error'){
                        toastr.error(json.message);
                        $("#getTcode").val('');
                    }else if (json.alert=='Session'){
                        toastr.error(json.message);
                        setTimeout(function (){location.href=base_url+"/auth/login";},1000);
                    }else if (json.alert=='Sukses'){
                        toastr.success(json.message);
                    }
                    contentFavorite();
                }
    });
}