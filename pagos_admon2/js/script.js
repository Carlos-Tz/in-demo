//variables globales
var id_requisicion ;
var consecutivo ;
var saldo ;
var total ;
var id_detalle ;
var numeral ;
var orden ;

// leer los registros
function readRecords() {
    var proveedor = $("#listaProveedor").val();

    $.get("ajax/readRecord.php", {proveedor : proveedor}, function (data, status) {
        $("#records_content").html(data);
    });
}

function VerParcialidades(){
    $('#listaPagos').find('tr').click( function(){
      //  alert('fila '+ ($(this).index()+1));
        var row = $(this).find('td:first').text();
        var pos = row.search('-') ;
        numeral = row.slice(-1);
        id_detalle = row.slice(0,pos-1) ;
 
    $.post("ajax/leerDetalle.php", {
            id_detalle : id_detalle,
            numeral : numeral
        },
        function (data, status) {
            console.log(data);
            $("#lista_modal").html(data);
        }
    );
    });
    $("#mostrar_detalles_modal").modal("show");
}

function hacerPago(){
    $('#listaPagos').find('tr').click( function(){
        //   alert('fila '+ ($(this).index()+1));
        var row = $(this).find('td:first').text();
        var pos = row.search('-') ;
        consecutivo = row.slice(-1);
        id_requisicion = row.slice(0,pos-1) ;
        total = $(this).find('td:nth-child(7)').text() ;
        saldo = $(this).find('td:nth-child(8)').text() ;
        $("#monto").val(saldo) ;
        $("#monto").attr({
            "max" : saldo,        // substitute your own
            "min" : 2          // values (or variables) here
        });
/*        n =  new Date();
        //Año
        y = n.getFullYear();
        //Mes
        m = n.getMonth() + 1;
        //Día
        d = n.getDate();
        //Lo ordenas a gusto.
        $("#fecha").attr({
            "value" : d + "/" + m + "/" + y
        });*/
    });
    
    $.post(
        "ajax/leerMetodosPago.php", //llamada a modelo
        {},  //argumentos
        function (data, status) {  //que haces con lo que te regresa
            $("#metodo").html(data);
        }
    );
    $("#hacer_pago_modal").modal("show");
}

// Registra Pago
function registraPago() {
    // toma los valores del modal
    var fecha = $("#fecha").val();
    var folio = $("#folio").val();
    var documento = $("#documento").val();
    var monto = $("#monto").val();
    var metodo = $("#metodo").val();

    // añade pago
    $.post(
        "ajax/registra_Pago.php",
        {
            id_requisicion : id_requisicion,
            consecutivo: consecutivo,
            saldo : saldo,
            total : total,
            fecha : fecha,
            folio : folio,
            documento : documento,
            monto : monto,
            metodo : metodo
        }, 
        function (data, status) {
            $("#hacer_pago_modal").modal("hide");
            readRecords();
            console.log(data) ;
            // limpia los campos del modal
            $("#fecha").val("");
            $("#folio").val("");
            $("#documento").val("");
            $("#monto").val("");
            $("#metodo").val("");
        }
    );
}

//Ver Orden de Compra
function VerOrdenCompra(orden){
    data = '<iframe id="inlineFrameExample" title="Inline Frame Example" width="100%" height="500" src="https://demo.inomac.mx/ordenes_compra/' + orden + '"></iframe>' ;
    $("#lista_orden_modal").html(data);
    $("#orden_compra_modal").modal("show");
}

function descargarPagos() {
    $("#descargar_modal").modal("show");
}

function descargar_Excel_Pagos() {
    var fechaIni = $("#fecha_ini").val();
    var fechaFin = $("#fecha_fin").val();
    
     $.ajax({
        url: 'ajax/descargaPagos.php',
        type: 'POST',
        data: { fechaIni, fechaFin },
        success: function(data) {
            if (!data.error) {
                console.log(data) ;
                $("#descargar_modal").modal("hide");
                $("#fecha_ini").val("");
                $("#fecha_fin").val("");
                window.location.href = "https://demo.inomac.mx/compras/pagos_admon2/ajax/cuentasXpagar.xlsx";
            } else { console.log("Error en funcion") }
      }
  })
}

$(document).ready(function () {
    // lee los registros al cargar la página
    readRecords(); 
});

