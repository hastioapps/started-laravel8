function myGeneral(){
	$('#dataDisplays').flexigrid({
    		url: base_url+"/journal_entries/searching/getdata",
    		dataType: 'json',
            buttons : [ {name : '<i class="fa fa-folder-open fa-xs"></i>',bclass : 'btn btn-primary btn-xs',onpress : btnAction}
            ],
    		colModel : [
                        {display: 'Tgl. Dokumen ', name : 'date_doc',width:80, sortable : true, align: 'left', process: celDivAction},
                        {display: 'Batch', name : 'batch',width:130, sortable : true, align: 'left', process: celDivAction},
                        {display: 'Dokumen', name : 'doc',width:120, sortable : true, align: 'left', process: celDivAction},
                        {display: 'Kode', name : 'acc_code',width:80, sortable : true, align: 'left', process: celDivAction},
                        {display: 'Akun', name : 'acc_desc',width:300, sortable : false, align: 'left', process: celDivAction},
                        {display: 'Keterangan', name : 'djour_desc',width:300, sortable : false, align: 'left', process: celDivAction},
                        {display: 'Segment', name : 'segment_code',width:50, sortable : true, align: 'left', process: celDivAction},
                        {display: 'Debit', name : 'djour_db',width:150, sortable : false, align: 'right', process: celDivAction},
                        {display: 'Kredit', name : 'djour_cr',width:150, sortable : false, align: 'right', process: celDivAction},
                        {display: 'Kategori', name : 'cj_code',width:50, sortable : true, align: 'left', process: celDivAction},
                        {display: 'ID Pengguna', name : 'user_id',width:80, sortable : true, align: 'left', process: celDivAction},
                        {display: 'Area Bisnis', name : 'ba_code',width:50, sortable : false, align: 'left', process: celDivAction},
                        {display: 'Perusahaan', name : 'com_code',width:50, sortable : false, align: 'left', process: celDivAction}
                        ],
            searchitems : false,
            sortname: 'djour_date_entry',
    		sortorder: 'desc',
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
		$('#dataDisplays').flexOptions({ query: $(".dataSearch").val(),qtype: $("#cmbKey").val(), rp: 10,sortname: 'djour_date_entry', sortorder: 'desc' }).flexReload();
        return false;
	});
}

function btnAction(action,grid) {
    var code=$('.trSelected',grid).children('td').eq(1).text();
    if (action == '<i class="fa fa-folder-open fa-xs"></i>') {
        if ($('.trSelected',grid).length != 1) {
            toastr.warning('Data belum dipilih.');
        }else{
            $('#modalDisplays').modal('show');
            $.ajax({
                type    : "POST",
                url     : base_url+"/journal_entries/views",
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

function celDivAction(celDiv) {
    $( celDiv ).dblclick( function() {
        var code = $(this).parent().parent().children('td').eq(1).text();
        $('#modalDisplays').modal('show');
            $.ajax({
                type    : "POST",
                url     : base_url+"/journal_entries/views",
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