$(document).ready(function () {
    carga_perfiles();
    //carga_entidades();
    input_pw();
    $('#formUser').submit(function (e) {
        e.preventDefault();
        $(document).skylo('start');
        setTimeout(function () {
            $(document).skylo('set', 50);
        }, 150);
        validation = valida_password($('#newPassword').val(),$('#rePassword').val(),$('#id_usuario').val());
        if (validation['error'] == true) {
            $("#message").html('<div class="alert alert-dismissable alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a><strong> ¡Atención! </strong> '+ validation['message'] +' </div>');
        } else {
            var formData = $("#formUser").serializeArray();
            $.ajax({
                data: formData,
                type: 'POST',
                dataType: 'json',
                url: 'index.php?event=101',
                beforeSend: function () {
                    $('#btn-save').attr('disabled', true).html('<i class="fa fa-clock-o"></i> Cargando..');
                    $("html, body").animate({ scrollTop: "0" });
                    $("#message").html('<div class="alert alert-dismissable alert-info"><a href="#" class="close" data-dismiss="alert">&times;</a><center><h5>Guardando, espere por favor...</h5></center></div>');
                },
                success: function (data) {
                    $("#id_usuario").val(data['id_usuario']);
                    var type_alert = 'success';
                    if (true == data[0]) {
                        type_alert = 'warning';
                        swal({
                                title:   data[1],
                                text:    data[2],
                                icon:    type_alert,
                                button:  true
                        });
                        setTimeout(function () {
                            $("#message").html('');
                        }, 1000);
                    }else{
                        swal({
                                title:   data[1],
                                text:    data[2],
                                icon:    type_alert,
                                button:  false
                        });
                        setTimeout(function () {
                            self.location = "index.php?event=1";
                        }, 3000); 
                    }
                },
                error: function (data) {
                    $("#message").html('<div class="alert alert-dismissable alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Warning!</strong> Ocurrio un Error, Por favor verifique su conexión e intente nuevamente.</div>');
                }
            });
        }
        setTimeout(function () {
            $(document).skylo('end');
            $('#btn-save').attr('disabled', false).html('Guardar');
        }, 300);

    });
    $('#edita_pw').click(function() {
        check_value = $(this).prop('checked');
        if(check_value == true){
            $('#newPassword').attr('disabled',false);
            $('#rePassword').attr('disabled',false);
            $('#regla_pw').prop('d-none',false);
        }else{
            $('#newPassword').val('');
            $('#rePassword').val('');
            $('#newPassword').attr('disabled',true);
            $('#rePassword').attr('disabled',true);
            $('#regla_pw').prop('d-none',true);
        }
    }); 
});

function carga_perfiles() {
    $.ajax({
        type: "POST",
        url: url_path + 'modules/Catalogs/Profiles?event=10',
        dataType: 'json',
        success: function (data, textStatus, xhr) {
            $.each(data, function (arrayID, group) {
                var opt = $('<option>').val(group.id).text(group.label);
                if ($('#perfil').val() == group.id) {
                    opt.attr("selected", "selected");
                    $(opt).appendTo($('#id_perfil'));
                } else {
                    $(opt).appendTo($('#id_perfil'));
                }
            });
        },
        error: function () {
            console.log('Ocurrio un error al intentar cargar.');
        }
    });
}
function carga_entidades() {
    $.ajax({
        type: "POST",
        url: url_path + 'modules/Catalogos/?event=10&tabla=sys_entities',
        dataType: 'json',
        success: function (data, textStatus, xhr) {
            $.each(data, function (arrayID, group) {
                var opt = $('<option>').val(group.id).text(group.label);
                if ($('#entidad').val() === group.id) {
                    opt.attr("selected", "selected");
                    $(opt).appendTo($('#id_entidad'));
                    $("#id_entidad").val(group.id).trigger("change");
                } else {
                    $(opt).appendTo($('#id_entidad'));
                }
            });
        },
        error: function () {
            console.log('Ocurrio un error al intentar cargar.');
        }
    });
}
function input_pw(){
    if($('#id_usuario').val() != 0){
        $('#newPassword').attr('disabled',true);
        $('#rePassword').attr('disabled',true);
        $('#regla_pw').prop('d-none',true);
    }
}
function valida_password(password1,password2,idUsuario){
    data_return = new Array();
    Contrasenia_1 = password1.trim();  
    Contrasenia_2 = password2.trim(); 
    Usuario = idUsuario;
    check = false;
    data_return['error'] = false;
    data_return['message'] = '';
    if($('#edita_pw').prop('checked') && Usuario != 0) {
        check = true;
    }
    if(Contrasenia_1 != '' || Contrasenia_2 != ''){
        check = true;
    }
    if(check == true){
        if(Contrasenia_1 == '' && Contrasenia_2 == ''){
            data_return['error'] = true;
            data_return['message'] = 'Solicitó actualizar la contraseña, si es un error desactive la casilla o escriba la nueva contraseña';
        }else{
            if(Contrasenia_1 === Contrasenia_2 ){
                longitud = Contrasenia_1.length;
                if(longitud >= 8){
                var nMay = 0, nMin = 0, nNum = 0, nChar = 0 
                var Mayusculas = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZ"; 
                var Minusculas = "abcdefghijklmnñopqrstuvwxyz"; 
                var Numeros = "0123456789"; 
                var Chars = "#!¡_-.@&()$/,*+<>";
    
                    for (i=0; i<Contrasenia_1.length; i++) { 
                        if (Mayusculas.indexOf(Contrasenia_1.charAt(i)) != -1) {nMay++} 
                        if (Minusculas.indexOf(Contrasenia_1.charAt(i)) != -1) {nMin++} 
                        if (Numeros.indexOf(Contrasenia_1.charAt(i)) != -1)    {nNum++} 
                        if (Chars.indexOf(Contrasenia_1.charAt(i)) != -1)      {nChar++}
                    } 
    
                    if (nMay > 0 && nMin > 0 && nNum > 0 &&nChar > 0){
                        data_return['error'] = false;
                        data_return['message'] = 'La contraseña cumple con los criterios de seguridad exigidos';
                    }else{
                        data_return['error'] = true;
                        data_return['message'] = 'La contraseña debe contener mínimo: 1 Letra Mayúscula, 1 Letra Minúscula, 1 Caracter Especial y 1 Número';
                    } 
                }else{
                    data_return['error'] = true;
                    data_return['message'] = 'La longitud de la contraseña debe ser mínimo de 8 caracteres';
                }
            }else{
                data_return['error'] = true;
                data_return['message'] = 'Las contraseñas propuestas no coinciden';
            }
        }
    }
    return data_return;  
}

