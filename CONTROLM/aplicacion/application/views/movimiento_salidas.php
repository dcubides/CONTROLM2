<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if($this->session->userdata('conectado') == true){ ?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo base_url()?>asset/js/jquery-1.10.2.js"></script>
<!--<script src="<?php echo base_url()?>asset/js/jquery-ui.js"></script>-->
<script src="<?php echo base_url()?>asset/js/JsonMovimientosEntradas.js"></script>

<div class"cintainer">
<div id="mensaje"></div> 
<h1 class="page-header"><span class="icon-play-circle"></span> Nuevo Movimiento</h1>
  <div class="widget-content">
    <form name="formulario" id="formulario" class="form-horizontal" role="form">
      <h2><span class="icon-upload"></span> Nueva Salida</h2>
      <hr/><br/>
      <table class="table table-striped table-bordered" border=0 width="100%">
        <tr>
          <td colspan="10">
            <table>
              <tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;Salidas:&nbsp;&nbsp;&nbsp;</td>
                <td>
                  <input type="text" name="idSalidas" id="idSalidas" class="span2" />
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      
      <table class="table table-striped table-bordered" border=0 width="100%">
        <thead>
          <tr>
            <th style="text-align: center;">Entrega: <input class="span2" type="text" name="quien_entrega" id="quien_entrega" required=""/></th>
            <th style="text-align: center;">Técnico: <input class="span2" type="text" name="quien_recive" id="quien_recive" required=""/></th>
            <th style="text-align: center;">Requisición: <input class="span2" type="text" name="requisicion" id="requisicion" required=""/></th>
            
            <th style="text-align: center;"><center><button type="submit" class="btn btn-primary" id="salvar-salida"><span class="icon-save"></span> Guardar Salida</button></center></th>
          </tr>
        </thead>
      </table>
    </form>
    
    <form name="frmDetalleM" id="frmDetalleM" class="form-horizontal" role="form">
      <h2 class="page-header"><span class="icon-th-list"></span> Detalle Movimiento</h2>
      <br />
      <table id="carritoSalidas" class="table table-striped table-bordered" border=0 width="100%">
        <thead>
          <tr>
            <th style="text-align: center;">Elemento: <input class="span2" type="text" name="elemento" id="elemento" required=""/>
                                                      <input class="span2" type="hidden" name="codigo" id="codigo"/>
                                                      <input class="span2" type="hidden" name="descripcion" id="descripcion"/>
                                                      <input type="hidden" name="idsession"  id="idsession" value="<?php echo md5(rand(1000,50000)); ?>" /></td>
            </th>
            <th style="text-align: center;">Unidad: <input class="span2" type="text" name="unidad" id="unidad" readonly=""/></th>
            <th style="text-align: center;">Cantidad: <input class="span2" type="text" name="cantidad" id="cantidad" autocomplete="off" required=""/></th>
            <th style="text-align: center;">Valor <input class="span2" type="text" name="valor" id="valor" autocomplete="off" required=""/></th>
            <th style="text-align: center;"><center><input type="submit" class="btn btn-primary" name="btnAgregarElemento" id="btnAgregarElemento" value="Agregar Elemento" /></center></th>
          </tr>
        </thead>
      </table>
      
      <br />
      
      <table id="carritoSalidas" class="table table-striped table-bordered" border=0 width="100%">
        <thead>
          <tr><th style="text-align: center;">CODIGO</th><th style="text-align: center;">ELEMENTO</th><th style="text-align: center;">UNIDAD</th><th style="text-align: center;">CANTIDAD</th><th style="text-align: center;">VALOR</th><th style="text-align: center;">Total</th><th></th></tr>
        </thead>
        <tbody>
          <tr>
            <td colspan=7><center>No Hay Productos Agregados</center></td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <th colspan="3"></th>
            <th style="text-align: center;">Total Cantidades</th>
            <th style="text-align: center;">Subtotal</th>
            <th style="text-align: center;">Total</th>
            <th></th>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
            <td style="text-align: center;"><label id="lbltcantidad"></label></td>
            <td style="text-align: center;"><label id="lbltvalor"></label></td>
            <td style="text-align: center;"><label id="lbltotal"></label></td>
          </tr>
        </tfoot>
      </table>
      
      <center>
      <button type="button" class="btn" id="clear-salida"><span class="icon-repeat"></span> Nueva Salida</button> &nbsp;
      <button type="reset" id="cancelar-movimiento" class="btn btn-default" onclick="javascript:location.reload();"><span class="icon-retweet"></span> Cancelar Salida</button> &nbsp;
      <button type="button" id="salvar-detalle" class="btn btn-primary"><span class="icon-save"></span> Confirmar Salida</button></center>
    </form>
    
    <br/><hr/><br/>
  </div>
</div>

<?php }else{

  redirect(base_url());

  }
  ?>