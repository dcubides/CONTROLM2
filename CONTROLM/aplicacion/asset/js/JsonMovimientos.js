$(document).ready(function(){
   $('#tipoMovimiento').change(function(){
     $('#movimiento').empty();
     
     var tipoM = $('#tipoMovimiento').val();
     
     var Tmovimiento = new String();
     
     if(tipoM=='Salida'){
        Tmovimiento = '<table border=0 width="100%">' +
                    '<tr>' +
                      '<td>Técnico</td>' +
                      '<td>:</td>' +
                      '<td><input /></td>' +  
                      '<td>Recibe</td>' +
                      '<td>:</td>' +
                      '<td><input /></td>' +
                      '<td>Requisición</td>' +
                      '<td>:</td>' +
                      '<td><input /></td>' +
                      '<td><button type="button" class="btn btn-default" id="clear-salida"><span class="glyphicon glyphicon-edit"></span> Nueva Salida</button> &nbsp; </td>' +
                      '<td><button type="submit" id="SaveOrder" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-saved"></span> Crear Salida</button></center> </td>' +
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
                      '<td><button type="button" class="btn btn-default" id="clear-entrada"><span class="glyphicon glyphicon-edit"></span> Nueva Entrada</button> &nbsp; </td>' +
                      '<td><button type="submit" id="SaveOrder" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-saved"></span> Crear Entrada</button></center> </td>' +
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