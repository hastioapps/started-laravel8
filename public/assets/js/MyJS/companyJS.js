function actionForm(name_form){
    $(name_form).validate({
                rules: {
                    txtCode:{required: true,maxlength: 4},
                    txtName:{required: true,maxlength: 100},
                    txtAddress:{required: true},
                    txtDistricts:{required: true,maxlength: 20},
                    txtCity:{required: true,maxlength: 20},
                    txtProvince:{required: true,maxlength: 20},
                    txtCountry:{required: true,maxlength: 20},
                    cmbCurr:{required: true},
                    txtPhone:{number: true,minlength: 9,maxlength: 15},
                    txtWeb:{maxlength: 100},
                    txtEmail:{email: true},
                    txtDirector:{required: true,maxlength: 100}
                },
                messages: {
                    txtCode:{
                            required: "Silakan isi kode.",
                            maxlength: $.validator.format( "Kode max 4 karakter." )
                            },
                    txtName:{
                            required: "Silakan isi nama perusahaan.",
                            maxlength: $.validator.format( "Nama perusahaan max 100 karakter." )
                            },
                    txtAddress:{
                            required: "Silakan isi alamat."
                            },
                    txtDistricts:{
                            required: "Silakan isi kecamatan.",
                            maxlength: $.validator.format( "Kecamatan max 20 karakter." )
                            },
                    txtCity:{
                            required: "Silakan isi kota.",
                            maxlength: $.validator.format( "Kota max 20 karakter." )
                            },
                    txtProvince:{
                            required: "Silakan isi propinsi.",
                            maxlength: $.validator.format( "Propinsi max 20 karakter." )
                            },
                    txtCountry:{
                            required: "Silakan isi negara.",
                            maxlength: $.validator.format( "Negara max 20 karakter." )
                            },
                    cmbCurr:{
                            required: "Silakan pilih mata uang."
                            },
                    txtPhone:{
                            number: "Masukan telepon dengan benar.",
                            minlength: $.validator.format( "Telepon min 9 karakter." ),
                            maxlength: $.validator.format( "Telepon max 15 karakter." )
                            },
                    txtWeb:{
                            maxlength: $.validator.format( "Website max 100 karakter." )
                            },
                    txtEmail:{
                            email: "Masukan email dengan benar."
                            },
                    txtDirector:{
                            required: "Silakan isi direktur.",
                            maxlength: $.validator.format( "Direktur max 100 karakter." )
                            }
                },
                highlight: function (element, errorClass, validClass) {
                  $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                  $(element).removeClass('is-invalid');
                },submitHandler: function() {
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
                                url     : base_url+'/company/action',
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