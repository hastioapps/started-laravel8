function actionForm(name_form){
    $(name_form).validate({
                rules: {
                    cmbGroup:{required: true},
                    txtLabel:{required: true,maxlength: 100},
                    txtAddress:{required: true},
                    txtTerm:{required: true}
                },
                messages: {
                    cmbGroup:{required: "Silakan pilih grup."},
                    txtLabel:{
                            required: "Silakan isi keterangan.",
                            maxlength: $.validator.format( "Keterangan max 100 karakter." )
                            },
                    txtAddress:{required: "Silakan isi alamat."},
                    txtTerm:{required: "Silakan isi syarat pembayaran."}
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
                                url     : base_url+'/master/supplier/action',
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

function mySupplier(){
	$('#dataDisplays').flexigrid({
    		url: base_url+"/master/supplier/getdata",
    		dataType: 'json',
            buttons : [ {name : '<i class="fa fa-plus fa-xs"></i>',tooltip:'Y051',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-edit fa-xs"></i>',tooltip:'Y052',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-cubes fa-xs"></i>',tooltip:'Y053',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-lock fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnAction},
                        {name : '<i class="fa fa-folder-open fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnAction}
            ],
    		colModel : [
                {display: 'Kode', name : 'supplier_code',width:100, sortable : true, align: 'left', process: celDivAction},
                {display: 'Pemasok', name : 'supplier_label',width:450, sortable : true, align: 'left', process: celDivAction},
                {display: 'Grup', name : 'supplier_group',width:80, sortable : true, align: 'left', process: celDivAction},
                {display: 'Status', name : 'supplier_status',width:80, sortable : true, align: 'left', process: celDivAction},
                {display: 'Perusahaan', name : 'com_code',width:100, sortable : true, align: 'left', process: celDivAction}
            ],
    		searchitems : false,
    		sortname: 'supplier_code',
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
		$('#dataDisplays').flexOptions({ query: $(".dataSearch").val(),qtype: $("#cmbKey").val(), rp: 10,sortname: 'supplier_code', sortorder: 'asc' }).flexReload();
        return false;
	});
}

function celDivAction(celDiv) {
    $( celDiv ).dblclick( function() {
        var code = $(this).parent().parent().children('td').eq(0).text();
        $('#modalDisplays').modal('show');
        $.ajax({
            type    : "POST",
            url     : base_url+"/master/supplier/views",
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
    var status=$('.trSelected',grid).children('td').eq(3).text();
    if (action == '<i class="fa fa-plus fa-xs"></i>') {
        cekTcode('Y051','',false);
    }else if (action == '<i class="fa fa-edit fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            cekTcode('Y052','?code='+code,false);
        }
    }else if (action == '<i class="fa fa-cubes fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            cekTcode('Y053','?code='+code,false);
        }
    }else if (action == '<i class="fa fa-lock fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            statusSupplier(status,code);
        }
    }else if (action == '<i class="fa fa-folder-open fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            $('#modalDisplays').modal('show');
            $.ajax({
                type    : "POST",
                url     : base_url+"/master/supplier/views",
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

function statusSupplier(status,code){
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
        url     : base_url+'/master/supplier/action',
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

function mySupplierProduct(code){
    $('#dataProduct').flexigrid({
            url: base_url+"/master/supplier/getproduct",
            dataType: 'json',
            buttons : [ {name : '<i class="fa fa-plus fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnActionProduct},
                        {name : '<i class="fa fa-edit fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnActionProduct},
                        {name : '<i class="fa fa-trash fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnActionProduct}
            ],
            colModel : [
                {display: 'Kode', name : 'tbl_supplier_product.item_code',width:100, sortable : true, align: 'left'},
                {display: 'Keterangan', name : 'tbl_product.item_label',width:450, sortable : true, align: 'left'},
                {display: 'Harga Satuan', name : 'tbl_supplier_product.sproduct_price',width:100, align: 'right'},
                {display: '<i class="fa fa-lock"></i>', name : 'tbl_supplier_product.sproduct_lock_price',width:30, align: 'center'},
                {display: 'Satuan', name : 'tbl_product.item_unit',width:100, sortable : true, align: 'center'},
                {display: 'PPn', name : 'tbl_supplier_product.sproduct_vat',width:50, sortable : true, align: 'center'},
                {display: 'Diskon (%)', name : 'tbl_supplier_product.sproduct_disc',width:100, align: 'center'},
                {display: '<i class="fa fa-lock"></i>', name : 'tbl_supplier_product.sproduct_lock_disc',width:30, align: 'center'},
                {display: 'Area Bisnis', name : 'tbl_supplier_product.ba_code',width:100, align: 'center'},
                {display: 'Perusahaan', name : 'tbl_supplier_product.com_code',width:100, align: 'center'}
            ],
            searchitems : false,
            sortname: 'tbl_supplier_product.item_code',
            sortorder: 'asc',
            usepager: true,
            title: false,
            useRp: false,
            qtype:code,
            rp: 6,
            height:200,
            resizable: false,
            autoload: true,
            singleSelect: true,
            procmsg: 'please wait ...'
        }
    );

    $('#btnSearch').click(function(){
        $('#dataProduct').flexOptions({ query: $(".dataSearch").val(),qtype:code, rp: 6,sortname: 'tbl_supplier_product.item_code', sortorder: 'asc' }).flexReload();
        return false;
    });
}

function btnActionProduct(action,grid) {
    var supplier=$('#txtCode').val();
    var item_code=$('.trSelected',grid).children('td').eq(0).text();
    var item_label=$('.trSelected',grid).children('td').eq(1).text();
    var unit_cost=$('.trSelected',grid).children('td').eq(2).text();
    var unit=$('.trSelected',grid).children('td').eq(4).text();
    var ppn=$('.trSelected',grid).children('td').eq(5).text();
    var disc=$('.trSelected',grid).children('td').eq(6).text();
    var ba=$('.trSelected',grid).children('td').eq(8).text();
    if (action == '<i class="fa fa-plus fa-xs"></i>') {
        addProduct();
        $('#modalItemProduct').modal('show');
    }else if (action == '<i class="fa fa-edit fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            $('#txtItemCode').val(item_code);
            $('#txtSupplier').val(supplier);
            $('#txtItemDesc').val(item_label);
            $('#txtUnit').val(unit);
            $('#cmbBa').val(ba); 
            $('#txtCost').val(unit_cost);
            if (ppn=='Include'){
                $('#cbVat').prop('checked',true);
            }else{
                $('#cbVat').prop('checked',false);
            }
            $('#cbLockCost').prop('checked',true);
            $('#cbLockDisc').prop('checked',true);
            $('#txtDisc').val(disc);
            $('#modalProduct').modal('show');
        }
    }else if (action == '<i class="fa fa-trash fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            swal({
                title: "",
                text: 'Data akan dihapus...!!!',
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
                    url     : base_url+'/master/supplier/action',
                    data    : "deleteItem="+item_code+"&ba="+ba+"&supplier="+supplier,
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
                            toastr.success(json.message);
                            swal.close();
                            $('#dataProduct').flexReload();
                        }
                    }
                });
            });
        }
    }
}


function addProduct(){
    $('#tbItem').flexigrid({
            url: base_url+"/master/supplier/addproduct",
            dataType: 'json',
            buttons : [ {name : '<i class="fa fa-plus fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnAddItem}
            ],
            colModel : [
                {display: 'Kode', name : 'item_code',width:100, sortable : true, align: 'left', process: celDivActionItem},
                {display: 'Keterangan', name : 'item_label',width:450, sortable : true, align: 'left', process: celDivActionItem},
                {display: 'Satuan', name : 'item_unit',width:100, sortable : true, align: 'left', process: celDivActionItem}
            ],
            searchitems : false,
            sortname: 'item_code',
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

    $('#btnSearchData').click(function(){
        $('#tbItem').flexOptions({ query: $(".keyItem").val(), rp: 10,sortname: 'item_code', sortorder: 'asc' }).flexReload();
        return false;
    });
}


function btnAddItem(action,grid) {
    var supplier=$('#txtCode').val();
    var item_code=$('.trSelected',grid).children('td').eq(0).text();
    var item_label=$('.trSelected',grid).children('td').eq(1).text();
    var unit=$('.trSelected',grid).children('td').eq(2).text();
    if (action == '<i class="fa fa-plus fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            $('#txtItemCode').val(item_code);
            $('#txtSupplier').val(supplier);
            $('#txtItemDesc').val(item_label);
            $('#txtUnit').val(unit);
            $('#cmbBa').val(''); 
            $('#txtCost').val('');
            $('#cbVat').prop('checked',false);
            $('#cbLockCost').prop('checked',true);
            $('#cbLockDisc').prop('checked',true);
            $('#txtDisc').val('0');
            $('#modalProduct').modal('show');
        }
    }
}

function celDivActionItem(celDiv) {
    $( celDiv ).dblclick( function() {
        var supplier=$('#txtCode').val();
        var item_code=$(this).parent().parent().children('td').eq(0).text();
        var item_label=$(this).parent().parent().children('td').eq(1).text();
        var unit=$(this).parent().parent().children('td').eq(2).text();
        $('#txtItemCode').val(item_code);
        $('#txtSupplier').val(supplier);
        $('#txtItemDesc').val(item_label);
        $('#txtUnit').val(unit);
        $('#cmbBa').val(''); 
        $('#txtCost').val('');
        $('#cbVat').prop('checked',false);
        $('#cbLockCost').prop('checked',true);
        $('#cbLockDisc').prop('checked',true);
        $('#txtDisc').val('0');
        $('#modalProduct').modal('show');
    });    
}

function frmAddItem(){
    $('#frmAddItem').validate({
                rules: {
                    txtItemCode:{required: true},
                    txtItemDesc:{required: true},
                    cmbBa:{required: true},
                    txtUnit:{required: true},
                    txtCost:{required: true},
                    txtDisc:{required: true}
                },
                messages: {
                    txtItemCode:{required: "Silakan isi kode."},
                    txtItemDesc:{required: "Silakan isi keterangan."},
                    cmbBa:{required: "Silakan pilih bisnis area."},
                    txtUnit:{required: "Silakan isi satuan."},
                    txtCost:{required: "Silakan isi harga satuan."},
                    txtDisc:{required: "Silakan isi diskon."}
                },
                submitHandler: function() {
                    var dataForm=$('#frmAddItem').serialize();
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
                                url     : base_url+'/master/supplier/action',
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
                                        toastr.success(json.message);
                                        swal.close();
                                        $('#dataProduct').flexReload();
                                        $('#modalProduct').modal('hide');
                                    }
                                }
                            });
                    });
                }
    });
}