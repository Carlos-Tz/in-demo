<?php
include("../../utils/cabecera.php") ;
?>

    <div class="card-header-actions">
        <h2 class="card-header bg-cyan-soft text-black">
            Ordenes de Compra: Realizar Pago   
            <button type="button" onclick="descargarPagos()" class="btn btn-outline-success btn-lg"><i class="fa fa-file-excel"></i></button>
        </h2>
    </div>
    <div class="card-body">
        <div class= "row">
            <form>
                <div class="form-group row align-items-center">
                    <div class="col-sm-12 col-md-6 col-lg-10">
                        <div class="form-group">
                            <label for="listaProveedor">Proveedor</label>
                            <select name="listaProveedor" id = "listaProveedor" class="form-control buscador">
                                <?php include("modelo/proveedor.php") ; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-2">
                        <button type="button" onclick="readRecords()" class="btn btn-primary btn-sm"><i class="fa fa-info"></i>&nbsp; Buscar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <table id="listaPagos" class="table table-responsive table-bordered table-striped table-sm">
	            <thead>
						<tr>
							<th>ID</th>
							<th>RFC</th>
							<th>Proveedor</th>
							<th>Fecha Programada</th>
							<th>Subtotal</th>
							<th>IVA</th>
							<th>Total</th>
							<th>Saldo</th>
							<th>Pagar</th>
							<th>Detalle</th>
							<th>Orden Pago</th>
						</tr>
				</thead>
                <tbody id="records_content">
                    
                </tbody>
            </table>

<!-- Bootstrap Modals --> 

<!-- Modal - Descargar -->
<div class="modal fade" id="descargar_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
   
      <div class="modal-header">
        <h5 class="modal-title">Descargar Pagos Realizados</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="fecha">Fecha Inicial</label>
          <input  type="date" id="fecha_ini" class="form-control" required />
        </div>
        <div class="form-group">
          <label for="fecha">Fecha Final</label>
          <input  type="date" id="fecha_fin" class="form-control" required />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="descargar_Excel_Pagos()">Descargar</button>
      </div>
    </div>
  </div>
</div>
<!-- // Modal descargar--> 

<!-- Modal - Hacer pago -->
<div class="modal fade" id="hacer_pago_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
   
      <div class="modal-header">
        <h5 class="modal-title">Registrar Pago</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="fecha">Fecha</label>
          <input  type="date" id="fecha" value="<?php echo date("Y-m-d");?>"  class="form-control" required />
        </div>
        <div id = "forma_pago" class="form-group">
            <label for="metodo">Forma de Pago</label>
            <select class="form-control" id="metodo">
                <!-- aqui van las opciones  -->
            </select>
        </div>
        <div class="form-group">
          <label for="documento">Documento</label>
          <input type="text" id="documento" class="form-control" required />
        </div>
        <div class="form-group">
          <label for="folio">Folio</label>
          <input type="text" id="folio" class="form-control"  required />
        </div>
        <div class="form-group">
          <label for="monto">Monto</label>
          <input type="number" id="monto" class="form-control" min="1" max="" required /> 
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="registraPago()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- // Modal --> 

<!-- Modal - mostrar detalles -->
<div class="modal fade" id="mostrar_detalles_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
   
      <div class="modal-header">
        <h5 class="modal-title">Pagos Parciales</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> 
      
      
      <div class="modal-body">
        <div id="lista_modal"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <input type="hidden" id="hidden_user_id">
      </div>
    </div>
  </div>
</div>
<!-- // Modal --> 

<!-- Modal - Orden de Compra -->
<div class="modal fade bd-example-modal-lg" id="orden_compra_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
   
      <div class="modal-header">
        <h5 class="modal-title">Orden de Compra</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> 
      
      
      <div class="modal-body">
        <div id="lista_orden_modal">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <input type="hidden" id="hidden_user_id">
      </div>
    </div>
  </div>
</div>
<!-- // Modal --> 
        
        </div> <!-- div  -->
    </div> <!-- cardbody -->

<?php include("../../utils/piePagina.php") ; ?>
<script type="text/javascript" src="js/script.js"></script> 
<!-- <script type="text/javascript" src="js/lista.js"></script>  -->