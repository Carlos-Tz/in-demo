/* global bootbox, url_path */
$(document).ready(function () {
    $('#login').submit(function (e) {
        e.preventDefault();
        $(document).skylo('start');
        setTimeout(function () {
            $(document).skylo('set', 50);
        }, 150);
        var formData = $("#login").serializeArray();
        $.ajax({
            data: formData,
            type: 'POST',
            dataType: 'script',
            url:url_path+'modules/Users/login.php?event=LOGIN',
            beforeSend: function () {
                $('#login').attr('disabled', true);
                $('#btn-log').attr('disabled', true).html('<i class="fa fa-clock-o"></i> Cargando..');
                $("#message").html('<div class="alert alert-dismissable alert-info"><a href="#" class="close" data-dismiss="alert">&times;</a><strong><i class="fa fa-clock-o"</strong> Comprobando sus datos, por favor espere.</div>');
            },
            success: function (data) {
                $('html, body').animate({scrollTop: 0}, 'slow');
            },
            error: function (data) {
                $("#message").html('<div class="alert alert-dismissable alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Warning!</strong>Ocurrio un Error, Por Favor Verifique su Conexión e Intente Nuevamente.</div>');
            }
        });
        setTimeout(function () {
            $(document).skylo('end');
            $('#login').attr('disabled', false);
            $('#btn-log').attr('disabled', false).html('Entrar');
        }, 300);
    });
    
    $('#recovery').click(function () {
        bootbox.prompt({
            title: "Ingresa tu correo electrónico registrado",
            buttons: {
                confirm: {
                    label: 'Recuperar',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'Cancelar',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (null !== result) {
                    $.ajax({
                            data: 'email=' + result,
                            type: 'POST',
                            dataType: 'json',
                            url: url_path + 'modules/Users/login.php?event=RESETPW',
                            beforeSend: function () {
                                $("#message").html('<div class="alert alert-dismissable alert-info"><a href="#" class="close" data-dismiss="alert">&times;</a>Espera un momento, estamos verificando tu cuenta...</div>');
                            },
                            success: function (data) {
                                var type_alert = 'success';
                                $('html, body').animate({scrollTop: 0}, 'slow');
                                if (true == data[0]) {
                                    type_alert = 'warning';
                                }
                                $("#message").html('<div class="alert alert-dismissable alert-' + type_alert + '"><a href="#" class="close" data-dismiss="alert">&times;</a>' + data[1] + '</div>');
                                setTimeout(function(){ $("#message").html('');}, 6000);
                            },
                            error: function (data) {
                                $("#loginButton").html('Entrar');
                            },
                            onChange: function (data) {
                                $('#message').html(data).fadeIn("slow");
                            }
                    });
                }
            }
        });
    });
});