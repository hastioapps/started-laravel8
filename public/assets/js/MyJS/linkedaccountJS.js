$(document).ready(function (){
        myLAccount();
        $(document).on('change','#txtGoods', function () {
            var code=$('#txtGoods').val();
            checkAccount(code,'Sales_Goods','#txtGoods','#txtDescGoods');
        });

        $(document).on('change','#txtServices', function () {
            var code=$('#txtServices').val();
            checkAccount(code,'Sales_Services','#txtServices','#txtDescServices');
        });

        $(document).on('change','#txtReceivable', function () {
            var code=$('#txtReceivable').val();
            checkAccount(code,'Receivable','#txtReceivable','#txtDescReceivable');
        });

        $(document).on('change','#txtCogs', function () {
            var code=$('#txtCogs').val();
            checkAccount(code,'COGS','#txtCogs','#txtDescCogs');
        });

        $(document).on('change','#txtPayable', function () {
            var code=$('#txtPayable').val();
            checkAccount(code,'Payable','#txtPayable','#txtDescPayable');
        });

        $(document).on('change','#txtInventories', function () {
            var code=$('#txtInventories').val();
            checkAccount(code,'Inventories','#txtInventories','#txtDescInventories');
        });

        $(document).on('change','#txtVatIn', function () {
            var code=$('#txtVatIn').val();
            checkAccount(code,'Vat_In','#txtVatIn','#txtDescVatIn');
        });

        $(document).on('change','#txtVatOut', function () {
            var code=$('#txtVatOut').val();
            checkAccount(code,'Vat_Out','#txtVatOut','#txtDescVatOut');
        });

        $(document).on('change','#txtVatPayable', function () {
            var code=$('#txtVatPayable').val();
            checkAccount(code,'Vat_Payable','#txtVatPayable','#txtDescVatPayable');
        });

        $(document).on('click','#btnGoods', function () {
            $('#type').val('Sales_Goods');
            $('#modalDisplays').modal('show');
        });

        $(document).on('click','#btnServices', function () {
            $('#type').val('Sales_Services');
            $('#modalDisplays').modal('show');
        });

        $(document).on('click','#btnReceivable', function () {
            $('#type').val('Receivable');
            $('#modalDisplays').modal('show');
        });

        $(document).on('click','#btnCogs', function () {
            var code=$('#txtCogs').val();
            checkAccount(code,'COGS','#txtCogs','#txtDescCogs');
        });

        $(document).on('click','#btnPayable', function () {
            $('#type').val('Payable');
            $('#modalDisplays').modal('show');
        });

        $(document).on('click','#btnInventories', function () {
            $('#type').val('Inventories');
            $('#modalDisplays').modal('show');
        });

        $(document).on('click','#btnVatIn', function () {
            $('#type').val('Vat_In');
            $('#modalDisplays').modal('show');
        });

        $(document).on('click','#btnVatOut', function () {
            $('#type').val('Vat_Out');
            $('#modalDisplays').modal('show');
        });

        $(document).on('click','#btnVatPayable', function () {
            $('#type').val('Vat_Payable');
            $('#modalDisplays').modal('show');
        });
});

function checkAccount(code,type,txtCode,txtDesc){
    $.ajax({
            type    : "POST",
            url     : base_url+'/master/account/action',
            data    : "checkAccount="+code,
            dataType : "json",  
            success : function(json){
                var desc=json.desc;
                if (desc==''){   
                    $(txtDesc).val('');
                    $(txtCode).val('');
                    $(txtCode).focus();
                    $('#type').val(type);
                    $('#modalDisplays').modal('show');
                }else{
                    $(txtCode).val(code);
                    $(txtDesc).val(desc);
                    $('#modalDisplays').modal('hide');
                    $.ajax({
                        type    : "POST",
                        dataType : "json",
                        url     : base_url+'/setting_up/linked_account/action',
                        data    : "saveLinked="+code+"&type="+type,
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
                            }
                        }
                    });
                }
            }
    });
}

function myLAccount(){
	$('#dataDisplays').flexigrid({
            url: base_url+"/master/account/acctrx",
            dataType: 'json',
            buttons : [ {name : '<i class="fa fa-plus fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnAction}
            ],
            colModel : [
                {display: 'Kode', name : 'acc_code',width:80, sortable : true, align: 'left', process: celDivAction},
                {display: 'Nama Akun', name : 'acc_label',width:400, sortable : true, align: 'left', process: celDivAction}
            ],
            searchitems : false,
            sortname: 'acc_code',
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
        $('#dataDisplays').flexOptions({ query: $(".dataSearch").val(), rp: 10,sortname: 'acc_code', sortorder: 'asc' }).flexReload();
        return false;
    });
}

function celDivAction(celDiv) {
    $( celDiv ).dblclick( function() {
        var code = $(this).parent().parent().children('td').eq(0).text();
        var type=$('#type').val();
        if(type=='Sales_Goods') {
            checkAccount(code,'Sales_Goods','#txtGoods','#txtDescGoods');
        }else if(type=='Sales_Services') {
            checkAccount(code,'Sales_Services','#txtServices','#txtDescServices');
        }else if(type=='Receivable') {
            checkAccount(code,'Receivable','#txtReceivable','#txtDescReceivable');
        }else if(type=='COGS') {
            checkAccount(code,'COGS','#txtCogs','#txtDescCogs');
        }else if(type=='Payable') {
            checkAccount(code,'Payable','#txtPayable','#txtDescPayable');
        }else if(type=='Inventories') {
            checkAccount(code,'Inventories','#txtInventories','#txtDescInventories');
        }else if(type=='Vat_In') {
            checkAccount(code,'Vat_In','#txtVatIn','#txtDescVatIn');
        }else if(type=='Vat_Out') {
            checkAccount(code,'Vat_Out','#txtVatOut','#txtDescVatOut');
        }else if(type=='Vat_Payable') {
            checkAccount(code,'Vat_Payable','#txtVatPayable','#txtDescVatPayable');
        }
    });    
}

function btnAction(action,grid) {
    var code=$('.trSelected',grid).children('td').eq(0).text();
    if (action == '<i class="fa fa-plus fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            var type=$('#type').val();
            if(type=='Sales_Goods') {
                checkAccount(code,'Sales_Goods','#txtGoods','#txtDescGoods');
            }else if(type=='Sales_Services') {
                checkAccount(code,'Sales_Services','#txtServices','#txtDescServices');
            }else if(type=='Receivable') {
                checkAccount(code,'Receivable','#txtReceivable','#txtDescReceivable');
            }else if(type=='COGS') {
                checkAccount(code,'COGS','#txtCogs','#txtDescCogs');
            }else if(type=='Payable') {
                checkAccount(code,'Payable','#txtPayable','#txtDescPayable');
            }else if(type=='Inventories') {
                checkAccount(code,'Inventories','#txtInventories','#txtDescInventories');
            }else if(type=='Vat_In') {
                checkAccount(code,'Vat_In','#txtVatIn','#txtDescVatIn');
            }else if(type=='Vat_Out') {
                checkAccount(code,'Vat_Out','#txtVatOut','#txtDescVatOut');
            }else if(type=='Vat_Payable') {
                checkAccount(code,'Vat_Payable','#txtVatPayable','#txtDescVatPayable');
            }
        }
    }
}