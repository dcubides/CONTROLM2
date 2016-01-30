<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if($this->session->userdata('conectado') == true){ ?>



<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo base_url()?>asset/js/jquery-1.10.2.js"></script>
<!--<script src="<?php echo base_url()?>asset/js/jquery-ui.js"></script>-->
<script src="<?php echo base_url()?>asset/js/JsonMovimientosEntradas.js"></script>

  <div class"cintainer">
<div id="mensaje"></div> 
<h2 class="page-header"><span class="icon-play-circle"></span> Nuevo movimiento.</h2>
  <div class="widget-content">
    <form name="formulario" id="formulario" class="form-horizontal" role="form">
      <h2><span class="icon-download"></span> Nueva entrada.</h2>
      <hr/><br/>
      <table class="table table-striped table-bordered" border=0 width="100%">
        <tr>
          <td colspan="10">
            <table>
              <tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;Entrada:&nbsp;&nbsp;&nbsp;</td>
                <td>
                  <input type="text" name="idEntradas" id="idEntradas" class="span2" disabled/>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>


          

          <table id="carritoSalidas" class="table table-striped table-bordered" border=0 width="100%">
                       <thead>
                       <tr>
                       <th style="text-align: center;">Técnico entrega: <input class="span2" type="text" name="quien_entrega" id="quien_entrega"/><th>
                        <th style="text-align: center;">Quien recibe: <input class="span2" type="text" name="quien_recibe" id="quien_recibe"/><th>

                       <th style="text-align: center;"><center><button type="submit" class="btn btn-primary" id="salvar-entrada"><span class="icon-save"></span> Guardar Entrada</button></center></th>

                       </tr>
                       </thead>
            </table>
            </form>
            <label> <h5><li> Si el reporte NO es una devolucion a bodega, ingresar en el campo "QUIEN RECIBE" el nombre "REPORTE TICKET".</li> </h5></label>

                  <form name="frmDetalleM" id="frmDetalleM" class="form-horizontal" role="form" autocomplete="off">
                  <h2 class="page-header"><span class="icon-th-list"></span> Detalle movimiento</h2>


                      <br>


                     <table id="carritoEntradas" class="table table-striped table-bordered" border=0 width="100%">
                       <thead>
                       <tr>
                       <th style="text-align: center;">Tipo: <select class="span2" id="tipo"><option>Legalización Bodega</option><option>Legalización Ticket</option></select></th>
                       <th style="text-align: center;">Elemento: <input class="span2" type="text" name="elemento" id="elemento" required=""/>
                                                      <input class="span2" type="hidden" name="codigo" id="codigo"/>
                                                      <input class="span2" type="hidden" name="descripcion" id="descripcion"/>
                                                      <input type="hidden" name="idsession"  id="idsession" value="<?php echo md5(rand(1000,50000)); ?>" /></td>
                        <th style="text-align: center;">Unidad: <input class="span2" type="text" name="unidad" id="unidad" readonly=""/></th>
                       <th style="text-align: center;">Cantidad Legalizada: <input class="span2" type="text" name="cantidad_legalizada" id="cantidad_legalizada" required=""/></th>
                       
                       <th id="tdOculto"><td></td></th>
                       </tr><br />
                       <tr>
                       <th style="text-align: center;">Cantidad Asignada: <input class="span2" type="text" name="cantidad_asignada" id="cantidad_asignada" readonly=""/></th>
                       <th style="text-align: center;">Valor uni.: <input class="span2" type="text" name="valor" id="valor" required=""/></th>
                       <th id="tdTicket" style="text-align: center;">Ticket: <input class="span2" type="text" name="ticket" id="ticket" required=""/></th>
                       
                       <th style="text-align: center;"><center><input type="submit" class="btn btn-primary" name="btnAgregarElemento" id="btnAgregarElemento" value="Agregar Elemento" /></center></th>
                       </tr>
                       </thead>
                     </table>

                      <br>




                      <table id="carritoEntradas" class="table table-striped table-bordered" border=0 width="100%">
                        <thead>
                        <tr>
                        <th style="text-align: center;">TIPO</th>
                        <th style="text-align: center;">CODIGO</th>
                        <th style="text-align: center;">ELEMENTO</th>
                        <th style="text-align: center;">TICKET</th>
                        <th style="text-align: center;">UNIDAD</th>
                        <th style="text-align: center;">ASIGNADO</th>
                        <th style="text-align: center;">LEGALIZADO</th>
                        <th style="text-align: center;">PENDIENTE</th>
                        <th style="text-align: center;">VALOR</th>
                        <th style="text-align: center;">TOTAL</th>
                        <th></th>
                        </tr></thead>
                        <tbody>
                      <tr>
                      <td colspan=12><center>No hay productos agregados</center></td>
                      </tr>
        
                      </tbody>
                       <tfoot>
          <tr>
            <th colspan="6"></th>
            <th style="text-align: center;">Total Cantidad Legalizado</th>
            <th colspan="2"></th>
            <th colspan="2" style="text-align: center;">Total</th>
            <th></th>
          </tr>
          <tr>
            <td colspan="6">&nbsp;</td>
            <td style="text-align: center;"><label id="lbltcantidad"></label></td>
            <td colspan="2"></td>
            <td colspan="2" style="text-align: center;"><label id="lbltotal"></label></td>
          </tr>
        </tfoot>
                      </table>

                       <center>
                  <button type="reset" class="btn" id="clear-entrada" onclick="javascript:location.reload();"><span class="icon-repeat"></span> Nueva Entrada</button> &nbsp;
                  <button type="button" id="cancelar-movimiento" class="btn"><span class="icon-retweet"></span> Cancelar Salida</button> &nbsp;
                 <button type="button" id="salvar-detalle" class="btn btn-primary"><span class="icon-save"></span> Confirmar Entrada</button></center>
                </form>
          <br/><hr/><br/>
       


        </div>
      </div>
    
 

 





<?php }else{

  redirect(base_url());

  }
  ?>