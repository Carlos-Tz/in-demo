 
function loadDetail(id) {
    $("#userDetail").modal("show");
    $.ajax({
        type: "POST",
        url: 'index.php/?event=10',
        data:{"id_usuario":id},
        dataType: 'json',
        beforeSend: function() {
            console.log("Cargando..");
        },
        success: function(response) {
            $("#usr_nombre").html(response.nombre);
            $("#apellidos").html(response.ap_paterno+' '+response.ap_materno);
            $("#usr_mail").html(response.mail);
            $("#usr_foto").attr("src", '../Users/Files/medium/' + response.foto);
            $("#usr_foto").attr("onerror", "this.src='../../assets/img/user_icon.png';");
            $("#usr_telefono").html(response.telefono);
            $("#usr_fecha_nacimiento").html(response.fecha_nacimiento);
        },
        error: function(a, b, c) {
            console.log(a, b, c);
        }
    });
    return;
}