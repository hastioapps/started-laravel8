function actionForm(name_form){
    $(name_form).validate({
                rules: {
                    txtCode:{required: true,maxlength: 8},
                    txtDesc:{required: true,maxlength: 50}
                },
                messages: {
                    txtCode:{
                            required: "Silakan isi kode.",
                            maxlength: $.validator.format( "Kode max 8 karakter." )
                            },
                    txtDesc:{
                            required: "Silakan isi keterangan.",
                            maxlength: $.validator.format( "Keterangan max 50 karakter." )
                            }
                },
                highlight: function (element, errorClass, validClass) {
                  $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                  $(element).removeClass('is-invalid');
                },
                submitHandler: function() {
                    var dataForm=$(name_form).serialize();
                    swal({
                            title: "",
                            text: 'Data akan disimpan...!!!',
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3071a9",
                            confirmButtonText: "Ya",
                            cancelButtonText: "Tidak",
                            closeOnConfirm: false,
                            showLoaderOnConfirm:true
                    },
                    function(){
                            $.ajax({
                                type    : "POST",
                                dataType : "json",
                                url     : base_url+'/roles/action',
                                data    : dataForm,
                                success : function(json){
                                    if (json.alert=='Error'){
                                        toastr.error(json.message);
                                        swal.close();
                                    }else if (json.alert=='Warning'){
                                        toastr.warning(json.message);
                                        swal.close();
                                    }else if (json.alert=='Session'){
                                        toastr.error(json.message);
                                        setTimeout(function (){location.href=base_url+"/auth/login";},1000);
                                    }else if (json.alert=='Success'){
                                        location.href=base_url+"/roles?code="+json.message;
                                    }
                                }
                            });
                    });
                }
    });
}

function myRoles(){
	$('#dataDisplays').flexigrid({
    		url: base_url+"/roles/getdata",
    		dataType: 'json',
            buttons : [ {name : '<i class="fa fa-plus fa-xs"></i>',tooltip:'Tambah',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-edit fa-xs"></i>',tooltip:'Edit',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-trash fa-xs"></i>',tooltip:'Hapus',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-folder-open fa-xs"></i>',tooltip:'Buka',bclass : 'btn btn-primary btn-xs',onpress : btnAction}
            ],
    		colModel : [
                {display: 'Peran', name : 'role_code',width:100, sortable : true, align: 'left', process: celDivAction},
                {display: 'Keterangan', name : 'role_description',width:500, sortable : true, align: 'left', process: celDivAction}
            ],
    		searchitems : false,
    		sortname: 'role_code',
    		sortorder: 'asc',
    		usepager: true,
    		title: false,
    		useRp: false,
    		rp: 10,
            height:290,
            resizable: false,
            autoload: true,
            singleSelect: true,
            procmsg: 'please wait ...'
		}
	);

	$('#btnSearch').click(function(){
		$('#dataDisplays').flexOptions({ query: $(".dataSearch").val(),qtype: $("#cmbKey").val(), rp: 10,sortname: 'role_code', sortorder: 'asc' }).flexReload();
        return false;
	});
}

function celDivAction(celDiv) {
    $( celDiv ).dblclick( function() {
        var ID = $(this).parent().parent().children('td').eq(0).text();
 		document.location.href=base_url+'/roles?code='+ID;
    });    
}

function btnAction(action,grid) {
    var ID=$('.trSelected',grid).children('td').eq(0).text();
    if (action == '<i class="fa fa-plus fa-xs"></i>') {
        document.location.href=base_url+'/roles/add';
    }else if (action == '<i class="fa fa-edit fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            document.location.href=base_url+'/roles/edit?code='+ID;
        }
    }else if (action == '<i class="fa fa-trash fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            swal({
                            title: "",
                            text: ID+' akan dihapus...!!!',
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3071a9",
                            confirmButtonText: "Ya",
                            cancelButtonText: "Tidak",
                            closeOnConfirm: false,
                            showLoaderOnConfirm:true
                    },
                    function(){
                    $.ajax({
                        type    : "POST",
                        dataType : "json",
                        url     : base_url+'/roles/action',
                        data    : "btnDelete="+ID,
                        success : function(json){
                            swal.close();
                            if (json.alert=='Error'){
                                toastr.error(json.message);
                            }else if (json.alert=='Warning'){
                                toastr.warning(json.message);
                            }else if (json.alert=='Session'){
                                toastr.error(json.message);
                                setTimeout(function (){location.href=base_url+"/auth/login";},1000);
                            }else if (json.alert=='Success'){
                                toastr.success(json.message);
                                $('#dataDisplays').flexReload();
                                return false;
                            }
                        }
                    });
                });
        }
    }else if (action == '<i class="fa fa-folder-open fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            document.location.href=base_url+'/roles?code='+ID;
        }
    }
}

function dualList(code){
    $.ajax({
        type        : "POST",
        dataType    : "json",
        url         : base_url+'/roles/gettcode',
        data        : "btnTcode="+code,
        success     : function(data){
            var groupDataArray = data;
            var settings = {
                "groupDataArray": groupDataArray,
                "tabNameText": "TKode",
                "rightTabNameText": "TKode Aktif",
                "callable": function (items) {
                    var totalArray=items.length;
                    var data=[];
                    for (i=0;i<totalArray;i++){
                        data.push(items[i]['value']);
                    }
                    $.ajax({
                        type        : "POST",
                        dataType    : "json",
                        url         : base_url+'/roles/gettcode',
                        data        : {code:code,data:data},
                        success     : function(json){
                            if (json.alert=='Error'){
                                toastr.error(json.message);
                            }else if (json.alert=='Warning'){
                                toastr.warning(json.message);
                            }else if (json.alert=='Session'){
                                toastr.error(json.message);
                                setTimeout(function (){location.href=base_url+"/auth/login";},1000);
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
}
