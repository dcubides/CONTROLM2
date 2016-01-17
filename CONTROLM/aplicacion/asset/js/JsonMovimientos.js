$(document).ready(function(){
   $('#tipoMovimiento').change(function(){
     $('#movimiento').empty();
     
     var tipoM = $('#tipoMovimiento').val();
     
     var Tmovimiento = new String();
     
     if(tipoM=='Salida'){
        Tmovimiento = '<table border=0 width="100%">' +
                    '<tr>' +
                      '<td>Entrega</td>' +
                      '<td>:</td>' +
                      '<td><input type="text" class="span2" /></td>' +  
                      '<td>Tecnico:</td>' +
                      
                      //'<td>:</td>' +
                      '<td><input type="text" class="span2" /></td>' +
                      '<td>Requisición</td>' +
                      '<td>:</td>' +
                      '<td><input type="text" class="span2" /></td>' +
                      '<td><button type="button" class="btn" id="clear-salida"><span class="icon-repeat"></span> Nueva Salida</button> &nbsp; </td>' +
                      '<td><button type="submit" id="SaveOrder" class="btn btn-primary"><span class="icon-save"></span> Crear Salida</button></center> </td>' +
                    '</tr>' +
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
     }
     
     $('#movimiento').append(Tmovimiento);
     
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