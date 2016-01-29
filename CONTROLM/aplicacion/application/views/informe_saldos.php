<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if($this->session->userdata('conectado') == true){ ?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
<script src="<?php echo base_url()?>asset/js/jquery-1.10.2.js"></script>
<script src="<?php echo base_url()?>asset/js/JsonSaldos.js"></script>

<div class"cintainer">
  <h2 class="page-header"><span class="icon-list-alt"></span> Informe saldos.</h2>
  
  <div class="widget-content">
    <form name="formulario" id="formulario" class="form-horizontal" role="form">
      <h2><span class="icon-barcode"></span> Saldos.</h2>
      
      <hr/><br/>
      <table class="table table-striped table-bordered" border=0 width="100%">
        <tr>
          <td colspan="10">
            <table>
              <tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;Técnicos:&nbsp;&nbsp;&nbsp;</td>
                <td>
                  <input type="text" name="tecnico" id="tecnico" class="span2" />
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
        <tr>
        <th style="text-align: center;">TIPO</th>
        <th style="text-align: center;">CODIGO</th>
        <th style="text-align: center;">ELEMENTO</th>
        <th style="text-align: center;">UNIDAD</th>
        <th style="text-align: center;">CANTIDAD</th>
        <th style="text-align: center;">VALOR</th>
        <th style="text-align: center;">Total</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="6"><center>No ha seleccionado tecnio</center></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
 
<?php }else{
    redirect(base_url());
}
?>