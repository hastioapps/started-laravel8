function actionForm(name_form){
    $(name_form).validate({
                rules: {
                    cmbType:{required: true},
                    txtCode:{required: true,maxlength: 8},
                    txtLabel:{required: true,maxlength: 100},
                    txtTarif:{required: true,maxlength: 5}
                },
                messages: {
                    cmbType:{
                            required: "Silakan pilih tipe."
                            },
                    txtCode:{
                            required: "Silakan isi kode.",
                            maxlength: $.validator.format( "Kode max 8 karakter." )
                            },
                    txtLabel:{
                            required: "Silakan isi keterangan.",
                            maxlength: $.validator.format( "Keterangan max 100 karakter." )
                            },
                    txtTarif:{
                            required: "Silakan isi tarif.",
                            maxlength: $.validator.format( "Tarif max 5 karakter." )
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
                                url     : base_url+'/master/tax/action',
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

function myTax(){
	$('#dataDisplays').flexigrid({
    		url: base_url+"/master/tax/getdata",
    		dataType: 'json',
            buttons : [ {name : '<i class="fa fa-plus fa-xs"></i>',tooltip:'Y021',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-edit fa-xs"></i>',tooltip:'Y022',bclass : 'btn btn-primary btn-xs',onpress : btnAction}
            ],
    		colModel : [
                {display: 'Kode', name : 'tax_code',width:80, sortable : true, align: 'left'},
                {display: 'Keterangan', name : 'tax_label',width:350, sortable : true, align: 'left'},
                {display: 'Persen', name : 'tax_percen',width:100, sortable : true, align: 'left'},
                {display: 'Tipe', name : 'tax_type',width:80, sortable : true, align: 'left'},
                {display: 'Perusahaan', name : 'com_code',width:100, sortable : true, align: 'left'}
            ],
    		searchitems : false,
    		sortname: 'tax_code',
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
		$('#dataDisplays').flexOptions({ query: $(".dataSearch").val(),qtype: $("#cmbKey").val(), rp: 10,sortname: 'tax_code', sortorder: 'asc' }).flexReload();
        return false;
	});
}

function btnAction(action,grid) {
    var code=$('.trSelected',grid).children('td').eq(0).text();
    if (action == '<i class="fa fa-plus fa-xs"></i>') {
        cekTcode('Y021','',false);
    }else if (action == '<i class="fa fa-edit fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            cekTcode('Y022','?code='+code,false);
        }
    }
}