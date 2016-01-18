$(document).ready(function(){
   $('#tipoMovimiento').change(function(){
     $('#movimiento').empty();
     $('#frmDetalleM').empty();
     
     var tipoM = $('#tipoMovimiento').val();
     
     var Tmovimiento = new String();
     var Dmovimiento = new String();
     
     if(tipoM=='Salida'){
        Tmovimiento = '<table border=0 width="100%">' +
                    '<tr>' +
                      '<td>Entrega</td>' +
                      '<td>:</td>' +
                      '<td><input type="text" class="span2" /></td>' +  
                      '<td>Tecnico</td>' +
                      '<td>:</td>' +
//=======
                      '<td><input type="text" class="span2" /></td>' +  
                      '<td>Requisición</td>' +
                      '<td>:</td>' +
                      '<td><input type="text" class="span1" /></td>' +
                      '</tr>'+
                      '<tr>'+
                      '<td><button type="button" class="btn" id="clear-salida"><span class="icon-repeat"></span> Nueva Salida</button> &nbsp; </td>' +
                      '<td></td>'+
                      '<td><button type="submit" id="SaveOrder" class="btn btn-primary"><span class="icon-save"></span> Crear Salida</button></center> </td>' +
                    '</tr>' +
                  '</table>';
                  
                    'Detalle Movimiento';
        Dmovimiento = '<h3>Detalle Movimiento</h3>'+
                        '<table id="tablaElementos" class="table table-striped table-bordered" border=0 width="100%"><tbody><tr>' + 
                        '<td>Elemento</td><td><input type="text" name="elemento" id="elemento" style="width: 314px;" required /></td>' +
                        '<td>Unidad</td><td><input type="text" name="unidad" id="unidad" readonly style="width: 100px;" /></td>' +
                        '<td>Cantidad</td><td><input type="text" name="cantidad" id="cantidad" style="width: 100px;" /></td>' +
                        '<td>Valor</td><td><input type="text" name="valor" id="valor" style="width: 100px;" /></td>' +
                        '<td><input type="button" class="btn btn-primary" name="btnAgregarSalida" id="btnAgregarSalida" value="Agregar Elemento" /></td>' +
                      '</tr></tbody></table>' +
                      '<table id="carritoSalidas" class="table table-striped table-bordered" border=0 width="100%">' +
                        '<thead><tr><th style="text-align: center;">CODIGO</th><th style="text-align: center;">ELEMENTO</th><th style="text-align: center;">UNIDAD</th><th style="text-align: center;">CANTIDAD</th><th style="text-align: center;">VALOR</th></tr></thead>'+
                      '</table>'
     }
     if(tipoM=='Entrada'){
        Tmovimiento = '<table border=0 width="100%">' +
                    '<tr>' +
                      '<td>Técnico</td>' +
                      '<td>:</td>' +
                      '<td><input /></td>' +  
                      '<td>Recibe</td>' +
                      '<td>:</td>' +
                      '<td><input /></td>' +
                      '<td><button type="button" class="btn" id="clear-entrada"><span class="icon-repeat"></span> Nueva Entrada</button> &nbsp; </td>' +
                      '<td><button type="submit" id="SaveOrder" class="btn btn-primary"><span class="icon-save"></span> Crear Entrada</button></center> </td>' +
                    '</tr>' +
                  '</table>'
        
        Dmovimiento =   '<h3>Detalle Movimiento</h3>'+
                        '<table id="tablaElementos" class="table table-striped table-bordered" border=0 width="100%"><tbody>' +
                        '<tr><td>Elemento</td><td><input type="text" name="elemento" id="elemento" style="width: 314px;" required /></td>' +
                        '<td>Unidad</td><td><input type="text" name="unidad" id="unidad" readonly style="width: 100px;" /></td>' +
                        '<td>Cantidad Legalizada</td><td><input type="text" name="cantidad" id="cantidad" style="width: 100px;" /></td></tr>' +
                        '<tr><td>Tipo</td><td><select><option>Legalización</option><option>Compra</option><option>Requisición</option></select></td>' +
                        '<td>Cantidad Asignada</td><td><input type="text" name="cantidadAsignada" id="cantidadAsignada" readonly style="width: 100px;" /></td>' +
                        '<td colspan="2"><input type="button" class="btn btn-primary" name="btnAgregarEntrada" id="btnAgregarEntrada" value="Agregar Elemento" /></td>' +
                      '</tr></tbody></table>' +
                      '<table id="carritoEntradas" class="table table-striped table-bordered" border=0 width="100%">' +
                        '<thead><tr><th style="text-align: center;">CODIGO</th><th style="text-align: center;">ELEMENTO</th><th style="text-align: center;">UNIDAD</th><th style="text-align: center;">CANTIDAD GASTADA</th><th style="text-align: center;">CANTIDAD ASIGNADA</th><th style="text-align: center;">VALOR</th></tr></thead>'+
                      '</table>';
     }
     
     $('#movimiento').append(Tmovimiento);
     $('#frmDetalleM').append(Dmovimiento);
     
     $('#clear-salida').click(function(){
        var movimiento = $('#tipoMovimiento').val();
        $('#tipoMovimiento').val(movimiento);
     });
     $('#clear-entrada').click(function(){
        var movimiento = $('#tipoMovimiento').val();
        $('#tipoMovimiento').val(movimiento);
     });
     
   });
});