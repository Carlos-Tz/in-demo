$(document).ready(function () {
    verify_token();
    $('#update_pw').submit(function (e) {
        e.preventDefault();
        $(document).skylo('start');
        setTimeout(function () {
            $(document).skylo('set', 50);
        }, 150);
        var formData = $(this).serializeArray();
        $.ajax({
            data: formData,
            type: 'POST',
            dataType: 'json',
            url: url_path + 'modules/Users/login.php?event=1100',
            beforeSend: function () {
                $('#btn-ok').attr('disabled', true).html('Procesando...');
                $("#message").html('<div class="alert alert-dismissable alert-info"><a href="#" class="close" data-dismiss="alert">&times;</a><center><b><h4>Validando los datos, un momento por favor...</h4></b></center></div>');
            },
            success: function (data) {
                var type_alert = 'success';
                $('html, body').animate({scrollTop: 0}, 'slow');
                if (true == data[0]) {
                    type_alert = 'warning';
                }
                $(document).skylo('end');
                $('#btn-ok').attr('disabled', false).html('Actualizar');
                $("#message").html('<div class="alert alert-dismissable alert-' + type_alert + '"><a href="#" class="close" data-dismiss="alert">&times;</a>' + data[1] + '</div>');
                setTimeout(function(){ $("#message").html('<div class="alert alert-dismissable alert-' + type_alert + '"><a href="#" class="close" data-dismiss="alert">&times;</a><b>Ya puedes iniciar sesión</b></div>');}, 8000);
            },
            error: function (data) {
                $("#message").html('<div class="alert alert-dismissable alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Warning!</strong>No hemos podido verificar sus datos, intente de nuevo por favor!</div>');
            }
        });
    });
});

function verify_token(){
    var _token = $('#token').val();
    var _user = $('#user_id').val();
    $.ajax({
        data: {token:_token,user:_user},
        type: 'POST',
        dataType: 'json',
        url: url_path + 'modules/Users/login.php?event=1101',
        beforeSend: function () {
            $('#btn-ok').attr('disabled', true).html('Procesando...');
            $("#message").html('<div class="alert alert-dismissable alert-info"><a href="#" class="close" data-dismiss="alert">&times;</a><center><b><h4>Validando los datos, un momento por favor...</h4></b></center></div>');
        },
        success: function (data) {
            $('html, body').animate({scrollTop: 0}, 'slow');
            if (true == data[0]) {
                type_alert = 'danger';
                $('#btn-ok').attr('disabled', true).html('Acción no permitida');
                $("#message").html('<div class="alert alert-dismissable alert-' + type_alert + '"><a href="#" class="close" data-dismiss="alert">&times;</a>' + data[1] + '</div>');
                setTimeout(function(){ $("#message").html('');}, 10000);
            }else{
                $('#btn-ok').attr('disabled', false).html('Actualizar');
                $("#message").html('');
            }
        },
        error: function (data) {
            $("#message").html('<div class="alert alert-dismissable alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Warning!</strong>No hemos podido verificar sus datos, intente de nuevo por favor!</div>');
        }
    });
}