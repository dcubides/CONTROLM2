<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if($this->session->userdata('conectado') == true){ ?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
<script src="<?php echo base_url()?>asset/js/jquery-1.10.2.js"></script>
<script src="<?php echo base_url()?>asset/js/JsonMovimientos.js"></script>

<div class"cintainer">
  <h1 class="page-header"><span class="icon-play-circle"></span> Informe Movimientos</h1>
  
  <div class="widget-content">
    <form name="formulario" id="formulario" class="form-horizontal" role="form">
      <h2><span class="icon-upload"></span> Movimientos</h2>
      
      <hr/><br/>
      <table class="table table-striped table-bordered" border=0 width="100%">
        <tr>
          <td colspan="10">
            <table>

            <tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;Movimiento:&nbsp;&nbsp;&nbsp;</td>
                <td>
                  <input type="text" name="idmovimiento" id="idmovimiento" class="span2" />
                </td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;Tipo:&nbsp;&nbsp;&nbsp;</td>
                <td>
                  <input type="text" name="tipo" id="tipo" class="span2" />
                </td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;Ticket:&nbsp;&nbsp;&nbsp;</td>
                <td>
                  <input type="text" name="ticket" id="ticket" class="span2" />
                </td>
                </tr>
                <tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;Requisición:&nbsp;&nbsp;&nbsp;</td>
                <td>
                  <input type="text" name="requisicion" id="requisicion" class="span2" />
                </td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;Elemento:&nbsp;&nbsp;&nbsp;</td>
                <td>
                  <input type="text" name="elemento" id="elemento" class="span2" />
                </td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;Fecha:&nbsp;&nbsp;&nbsp;</td>
                <td>
                  <input type="text" name="fecha" id="fecha" class="span2" />
                </td>
              </tr>
              <tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;Técnicos:&nbsp;&nbsp;&nbsp;</td>
                <td>
                  <input type="text" name="tecnico" id="tecnico" class="span2" />
                </td>
                <td></td>
                <td>
                  
                </td>
                <td style="text-align: center;"><center><button type="submit" class="btn btn-primary" id="consultar"><span class="icon-search"></span> Consultar Saldos</button></center></td>
                <td style="text-align: center;"><center><button type="button" class="btn" id="descargar"><span class="icon-download-alt"></span> Exportar</button></center></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </form>
    
    <br />
    
    <table id="carritoInforme" class="table table-striped table-bordered" border=0 width="100%">
      <thead>
        <tr><th style="text-align: center;">MOVIMIENTO</th>
        <th style="text-align: center;">FECHA</th>
        <th style="text-align: center;">ENTREGA</th>
        <th style="text-align: center;">RECIBE</th>
        <th style="text-align: center;">ELEMENTO</th>
        <th style="text-align: center;">TIPO MOVIMIENTO</th>
        <th style="text-align: center;">REQUISICIÓN</th>
        <th style="text-align: center;">TICKET</th>
        <th style="text-align: center;">ENTREGADO</th>
        <th style="text-align: center;">LEGALIZADO</th>
        <th style="text-align: center;">PENDIENTE</th>
        <th style="text-align: center;">VALOR UNI</th>
        <th style="text-align: center;">TOTAL</th>



        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="13"><center>No ha seleccionado busqueda</center></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
 
<?php }else{
    redirect(base_url());
}
?>