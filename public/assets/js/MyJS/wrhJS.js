function actionForm(name_form){
    $(name_form).validate({
                rules: {
                    txtCode:{required: true,maxlength: 4},
                    txtName:{required: true,maxlength: 100},
                    txtAddress:{required: true},
                    txtManager:{required: true,maxlength: 100},
                    cmbBa:{required: true}
                },
                messages: {
                    txtCode:{
                            required: "Silakan isi kode.",
                            maxlength: $.validator.format( "Kode max 4 karakter." )
                            },
                    txtName:{
                            required: "Silakan isi nama gudang.",
                            maxlength: $.validator.format( "Nama gudang max 100 karakter." )
                            },
                    txtAddress:{
                            required: "Silakan isi alamat."
                            },
                    txtManager:{
                            required: "Silakan isi manager.",
                            maxlength: $.validator.format( "Manager max 100 karakter." )
                            },
                    cmbBa:{
                            required: "Silakan pilih bisnis area."
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
                                url     : base_url+'/setting_up/warehouse/action',
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
                                        location.href=json.message;
                                    }
                                }
                            });
                    });
                }
    });
}

function myWrh(){
	$('#dataDisplays').flexigrid({
    		url: base_url+"/setting_up/warehouse/getdata",
    		dataType: 'json',
            buttons : [ {name : '<i class="fa fa-plus fa-xs"></i>',tooltip:'Z021',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-edit fa-xs"></i>',tooltip:'Z022',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-lock fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-folder-open fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnAction}
            ],
    		colModel : [
                {display: 'Kode', name : 'wrh_code',width:50, sortable : true, align: 'left', process: celDivAction},
                {display: 'Keterangan', name : 'wrh_name',width:250, sortable : true, align: 'left', process: celDivAction},
                {display: 'Manager', name : 'wrh_manager',width:200, sortable : true, align: 'left', process: celDivAction},
                {display: 'Perusahaan', name : 'com_code',width:100, sortable : true, align: 'left', process: celDivAction},
                {display: 'Status', name : 'wrh_status',width:80, sortable : true, align: 'left', process: celDivAction},
                {display: 'Bisnis Area', name : 'ba_code',width:100, sortable : true, align: 'left', process: celDivAction}
            ],
    		searchitems : false,
    		sortname: 'wrh_code',
    		sortorder: 'asc',
    		usepager: true,
    		title: false,
    		useRp: false,
    		rp: 10,
            height:332,
            resizable: false,
            autoload: true,
            singleSelect: true,
            procmsg: 'please wait ...'
		}
	);

	$('#btnSearch').click(function(){
		$('#dataDisplays').flexOptions({ query: $(".dataSearch").val(),qtype: $("#cmbKey").val(), rp: 10,sortname: 'wrh_code', sortorder: 'asc' }).flexReload();
        return false;
	});
}

function celDivAction(celDiv) {
    $( celDiv ).dblclick( function() {
        var ID = $(this).parent().parent().children('td').eq(0).text();
 		$('#modalDisplays').modal('show');
        $.ajax({
            type    : "POST",
            url     : base_url+"/setting_up/warehouse/views",
            data    : "code="+ID,
            beforeSend: function () {
                $(".dataModal").LoadingOverlay("show");
                $(".dataModal").html('');      
            },
            success : function(data){
                $(".dataModal").LoadingOverlay("hide");
                $(".dataModal").html(data);            
            }
        });
    });    
}

function btnAction(action,grid) {
    var ID=$('.trSelected',grid).children('td').eq(0).text();
    var Status=$('.trSelected',grid).children('td').eq(4).text();
    if (action == '<i class="fa fa-plus fa-xs"></i>') {
        cekTcode('Z021','',false);
    }else if (action == '<i class="fa fa-edit fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            cekTcode('Z022','?code='+ID,false);
        }
    }else if (action == '<i class="fa fa-lock fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            statusUser(Status,ID);
        }
    }else if (action == '<i class="fa fa-folder-open fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            $('#modalDisplays').modal('show');
            $.ajax({
                type    : "POST",
                url     : base_url+"/setting_up/warehouse/views",
                data    : "code="+ID,
                beforeSend: function () {
                    $(".dataModal").LoadingOverlay("show");
                    $(".dataModal").html('');      
                },
                success : function(data){
                    $(".dataModal").LoadingOverlay("hide");
                    $(".dataModal").html(data);            
                }
            });
        }
    }
}

function statusUser(Status,id){
    if (Status=='Enabled'){
        var updateStatus='Disabled';
    }else if (Status=='Aktif'){
        var updateStatus='Disabled';
    }else{
        var updateStatus='Enabled';
    }
    
    $.ajax({
        type    : "POST",
        dataType : "json",
        url     : base_url+'/setting_up/warehouse/action',
        data    : "addStatus="+updateStatus+"&id="+id,
        success : function(json){
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
}