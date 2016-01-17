<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if($this->session->userdata('conectado') == true){ ?>


<script src="<?php echo base_url()?>asset/js/jquery-1.10.2.js"></script>
<script src="<?php echo base_url()?>asset/js/jquery-ui.js"></script>
<!--<script src="<?php echo base_url();?>asset/js/JsonVenta.js"></script>-->
<script src="<?php echo base_url();?>asset/js/JsonMovimientos.js"></script>

</script>



  
  
          
          <div class="span12">          
            
            <div class="widget ">
              
              <div class="widget-header">
                <i class="icon-user"></i>
                <h3>Nuevo Movimiento</h3>
            </div> <!-- /widget-header -->
          
          <div class="widget-content">
            
                <form name="formulario" id="formulario" class="form-horizontal" role="form">

            <h1><span class="glyphicon glyphicon-list"></span> Nuevo Movimiento</h1>
            <div id="mensaje"></div>
            <hr/><br/>

              <table class="table table-striped table-bordered" border=0 width="100%">
                <tr>
                  <td colspan="10">
                    <table>
                      <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;Tipo:&nbsp;&nbsp;&nbsp;</td>
                        <td>
                          <select name="tipoMovimiento" id="tipoMovimiento" class="span2" >
                            <option></option>
                            <option>Entrada</option>
                            <option>Salida</option>
                          </select>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
            		<td colspan="10"><br/></td>
            	</tr>
                
                <tr id="movimiento"></tr>
              </table>
            
            </form>

<br/><hr/><br/>




</div>


</div>
            
            
            
            
            
          </div> <!-- /widget-content -->
            
        </div> <!-- /widget -->
            
        </div> <!-- /span8 -->
          
          
          
          
       <!-- <table class="table table-striped table-bordered" border=0 width="100%">
                <tr>
                  <td colspan="10">
                    <table>
                      <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;Tipo:&nbsp;&nbsp;&nbsp;</td>
                        <td>
                          <select name="tipoMovimiento" id="tipoMovimiento" class="form-control input-sm" >
                            <option></option>
                            <option>Entrada</option>
                            <option>Salida</option>
                          </select>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                <td colspan="10"><br/></td>
              </tr>
                
                <tr id="movimiento"></tr>
              </table>
            
            </form>-->

    









<!--<form   name="formulario" id="formulario" role="form">
<table class="table table-bordered table-striped"    id="carrito">
  <thead>
    <th>Código</th>
    <th>Descripcion</th>
    <th>Proveedor</th>
    <th>Precio</th>
    <th>Cantidad</th>
    <th>Total</th>
    <th></th>
  <thead>
  
   <tbody>
        <tr>
            <td colspan=7><center>No Hay Productos Agregados</center></td>
        </tr>
        
   </tbody>
   <tfoot> 
   <tr>
    <td colspan=5 align="right">Sub-Total:</td>
    <td colspan=2><label id="lblsubtotal" name="lblsubtotal">$ 0</label><input type="hidden" name="txtsubtotal" id="txtsubtotal" value="0"/C></td>
  </tr>
  <tr>
    <td colspan=5 align="right">IVA:</td>
    <td colspan=2><label id="lbliva" name="lbliva">$ 0</label><input type="hidden" name="txtIva" id="txtIva" value="0"/></td>
  </tr>
  <tr>
    <td colspan=5 align="right">Total:</td>
    <td colspan=2><label id="lbltotal" name="lbltotal">$ 0</label><input type="hidden" name="txtTotal" id="txtTotal" value="0"/></td>
  </tr>
</tfoot> 
  </table>
  <p class="bg-success">Direcciónes de Embarque</p>
  <input type="radio" value="0"/> Dir. de Embarque <input type="radio" value="1"> Dir de Recolección. 
<br/>
  Dir. de Entrega: 
  <select name="dirEnvio">
    <option value="0">Elige Dirección</option>
  </select>
 <center>
  <button type="reset" class="btn btn-default" onclick="javascript:location.reload();"><span class="glyphicon glyphicon-edit"></span> Nueva Salida</button> &nbsp;
  <button type="submit" id="SaveOrder" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-saved"></span> Crear Salida</button></center>
</form>		-->





<?php }else{

  redirect(base_url());

  }
  ?>