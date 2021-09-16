function actionForm(name_form){
    $(name_form).validate({
                rules: {
                    cmbGroup:{required: true},
                    txtLabel:{required: true,maxlength: 100},
                    cmbBasic:{required: true},
                    cmbConversion:{required: true},
                    txtConvertionValue:{required: true},
                    cmbPpn:{required: true},
                    cmbPph:{required: true},
                    txtPpnBm:{required: true},
                    cmbCategory:{required: true}
                },
                messages: {
                    cmbGroup:{required: "Silakan pilih grup."},
                    txtLabel:{
                            required: "Silakan isi keterangan.",
                            maxlength: $.validator.format( "Keterangan max 100 karakter." )
                            },
                    cmbBasic:{required: "Silakan pilih satuan dasar."},
                    cmbConversion:{required: "Silakan pilih satuan konversi."},
                    txtConvertionValue:{required: "Silakan isi nilai konversi."},
                    cmbPpn:{required: "Silakan pilih ppn."},
                    cmbPph:{required: "Silakan pilih pph."},
                    txtPpnBm:{required: "Silakan isi ppn bm."},
                    cmbCategory:{required: "Silakan pilih kategori."}
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
                                url     : base_url+'/master/product/action',
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

function myProduct(){
	$('#dataDisplays').flexigrid({
    		url: base_url+"/master/product/getdata",
    		dataType: 'json',
            buttons : [ {name : '<i class="fa fa-plus fa-xs"></i>',tooltip:'Y031',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-edit fa-xs"></i>',tooltip:'Y032',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-lock fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-folder-open fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnAction}
            ],
    		colModel : [
                {display: 'Kode', name : 'item_code',width:100, sortable : true, align: 'left', process: celDivAction},
                {display: 'Keterangan', name : 'item_label',width:400, sortable : true, align: 'left', process: celDivAction},
                {display: 'Satuan', name : 'item_unit',width:100, sortable : true, align: 'left', process: celDivAction},
                {display: 'Segment', name : 'segment_code',width:100, sortable : true, align: 'left', process: celDivAction},
                {display: 'Grup', name : 'item_group',width:80, sortable : true, align: 'left', process: celDivAction},
                {display: 'Kategori', name : 'item_category',width:80, sortable : true, align: 'left', process: celDivAction},
                {display: 'Status', name : 'item_status',width:80, sortable : true, align: 'left', process: celDivAction},
                {display: 'Perusahaan', name : 'com_code',width:100, sortable : true, align: 'left', process: celDivAction}
            ],
    		searchitems : false,
    		sortname: 'item_code',
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
		$('#dataDisplays').flexOptions({ query: $(".dataSearch").val(),qtype: $("#cmbKey").val(), rp: 10,sortname: 'item_code', sortorder: 'asc' }).flexReload();
        return false;
	});
}

function celDivAction(celDiv) {
    $( celDiv ).dblclick( function() {
        var code = $(this).parent().parent().children('td').eq(0).text();
        $('#modalDisplays').modal('show');
        $.ajax({
            type    : "POST",
            url     : base_url+"/master/product/views",
            data    : "code="+code,
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
    var code=$('.trSelected',grid).children('td').eq(0).text();
    var status=$('.trSelected',grid).children('td').eq(6).text();
    if (action == '<i class="fa fa-plus fa-xs"></i>') {
        cekTcode('Y031','',false);
    }else if (action == '<i class="fa fa-edit fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            cekTcode('Y032','?code='+code,false);
        }
    }else if (action == '<i class="fa fa-lock fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            statusProduct(status,code);
        }
    }else if (action == '<i class="fa fa-folder-open fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            $('#modalDisplays').modal('show');
            $.ajax({
                type    : "POST",
                url     : base_url+"/master/product/views",
                data    : "code="+code,
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

function statusProduct(status,code){
    if (status=='Enabled'){
        var updateStatus='Disabled';
    }else if (status=='Aktif'){
        var updateStatus='Disabled';
    }else{
        var updateStatus='Enabled';
    }
    
    $.ajax({
        type    : "POST",
        dataType : "json",
        url     : base_url+'/master/product/action',
        data    : "addStatus="+updateStatus+"&code="+code,
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