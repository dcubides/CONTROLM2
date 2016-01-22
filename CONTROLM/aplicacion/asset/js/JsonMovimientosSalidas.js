var currentLocation = window.location;

$(function(){
    $('#quien_recive').autocomplete({
        source: currentLocation + "/ListarTecnicos"
    });
    $('#quien_entrega').autocomplete({
        source: currentLocation + "/EncargadoBodega"
    });
    $('#requisicion').autocomplete({
        source: currentLocation + "/Requisiciones"
    });
    $('#idSalidas').autocomplete({
        source: currentLocation + "/Salidas"
    });
    $('#elemento').autocomplete({
        source: currentLocation + "/Elementos",
        select: function(event, ui){
            $('#codigo').val(ui.item.CODIGO);
            $('#descripcion').val(ui.item.DESCRIPCION);
            $('#unidad').val(ui.item.UNIDAD);
            $('#valor').val(ui.item.VALOR);
        }
    });
});

$(document).ready(function(){
    $("#formulario").submit(function(e){
        return false;
    });
    $('#frmDetalleM').submit(function(e){
        return false;
    });
    
    
    $('#frmDetalleM').find('input, textarea, select').attr('disabled', 'disabled');
    
    $('#salvar-salida').click(function(){
        $("form#formulario").submit(function(){
            $.prompt("¿Desea generar una nueva salida?", {
                title: "Control de inventarios. Salida de bodega",
                buttons: { "Si, crear salida": true, "No, cerrar esta ventana": false },
                submit: function(e,v,m,f){
                    if(v==true){
                        var Salida = new Object();
                        
                        Salida.fecha_movimiento = '';
                        Salida.tipo = 'Salida';
                        Salida.quien_entrega = $('#quien_entrega').val();
                        Salida.quien_recibe = $('#quien_recive').val();
                        Salida.estado = 'Pendiente';
                        Salida.requisicion = $('#requisicion').val();
                        Salida.usuario = '';
                        
                        var DatosJson = JSON.stringify(Salida);
                        $.post(currentLocation + '/nuevaSalida',
                        {
                            MiSalida: DatosJson
                        },
                        function(data, textStatus) {
                            if(data.TipoMsg=="Error"){
                                $("#mensaje").html("<div class='alert alert-danger text-center' alert-dismissable><button type='button' class='close' data-dismiss='alert'>&times;</button>"+data.Msg+"</div>");
                            }else{
                                $('#idSalidas').val(data.id);
                                $("#mensaje").html("<div class='alert alert-success text-center' alert-dismissable> <button type='button' class='close' data-dismiss='alert'>&times;</button>"+data.Msg+"</div>");
                                
                                $('#formulario').find('input, textarea, select, button').attr('disabled', 'disabled');
                                $('#frmDetalleM').find('input, textarea, select').removeAttr("disabled");
                                $('#idSalidas').find('input, textarea, select').removeAttr("disabled");
                                                                
                                $('clear-salida').removeAttr("disabled");
                                $('#elemento').focus();
                            }
                            
                            $('#mensaje').focus();
                        },
                        "json"
                        );
                    }
                    $.prompt.close();
                    $('#salvar-salida').unbind('click');
                }
            });
        });
    });
    
    $('#btnAgregarElemento').click(function(){
        $("form#frmDetalleM").submit(function(){
            var Elemento = new Object();
            
            Elemento.Codigo = $('#codigo').val();
            Elemento.Elemento = $('#descripcion').val();
            Elemento.Unidad = $('#unidad').val();
            Elemento.Cantidad = $('#cantidad').val();
            Elemento.Valor = $('#valor').val();
            Elemento.IdSession = $('#idsession').val();
            
            var DatosJson = JSON.stringify(Elemento);
            $.post(currentLocation + '/agregarCarrito',
            {
                MiCarrito: DatosJson
            },
            function(data, textStatus) {
                $("#carritoSalidas tbody").html("");
                var idses= $('#idsession').val();
                var Subtotal = 0;
                var total    = 0;
                var tCantidad = 0;
                
                $.each(data, function(i, item) {
                    var cantsincero = item.cantidad;
                    cantsincero = parseInt(cantsincero);
                    if(cantsincero!=0){
                        tCantidad = tCantidad + cantsincero;
                        
                        var Operacion= parseFloat(item.valor.replace(/\./g,'')) * parseFloat(item.cantidad);
                        Subtotal = parseFloat(Subtotal) + parseFloat(item.valor.replace(/\./g,''));
                        total    = parseFloat(total) + parseFloat(Operacion);
                        
                        Subtotal = Subtotal.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
                        Subtotal = Subtotal.split('').reverse().join('').replace(/^[\.]/,'');
                        
                        total = total.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
                        total = total.split('').reverse().join('').replace(/^[\.]/,'');
                        
                        var nuevaFila =
							"<tr>"
							+"<td>" + item.txtCodigo + "</td>"
							+"<td>" + item.elemento + "</td>"
							+"<td>" + item.unidad + "</td>"
							+"<td>" + item.cantidad + "</td>"
							+"<td>$ " + item.valor + "</td>"
							+"<td>$ " + Operacion + "</td>"
							+"<td><div align='center'>"
							+'<img onclick="EliminarItem('
							+"'" + item.txtCodigo + "',"
							+"'" + item.elemento + "',"
                            +"'" + item.unidad + "',"
							+"'-1',"
							+"'" + idses + "',"
							+"'" + item.valor + "'"
							+ ')"' 
							+" src='../../img/delete.png' width='20' title='Eliminar'/></div></td>"
							+"</tr>";
							$(nuevaFila).appendTo("#carritoSalidas tbody");
                            
                            $('#lbltcantidad').text(tCantidad);
							$("#lbltvalor").text("$ " + Subtotal);
                            $("#lbltotal").text("$ " + total);
                    }
                    
                    LimpiarTexto();
                });
            },
            "json"
            );
            
            $('#btnAgregarElemento').unbind('click');
        });
    });
    
    $('#salvar-detalle').click(function(){
            $.prompt("¿Desea guardar el detalle de esta salida?", {
                title: "Control de inventarios. Salida de bodega",
                buttons: { "Si, guardar cambios": true, "No, cerrar esta ventana": false },
                submit: function(e,v,m,f){
                    if(v==true){
                        var Salida = new Object();
                        
                        Salida.id = $('#idSalidas').val();
                        Salida.estado = 'Terminada';
                        Salida.IdSession = $('#idsession').val();
                        Salida.usuario = '';
                        
                        var DatosJson = JSON.stringify(Salida);
                        $.post(currentLocation + '/sacar',
                        {
                            MiSalida: DatosJson
                        },
                        function(data, textStatus) {
                            $("#mensaje").empty();
                            if(data.TipoMsg=="Error"){
                                $("#mensaje").html("<div class='alert alert-danger text-center' alert-dismissable><button type='button' class='close' data-dismiss='alert'>&times;</button>"+data.Msg+"</div>");
                            }else{
                                $('#idSalidas').val(data.id);
                                $("#mensaje").html("<div class='alert alert-success text-center' alert-dismissable> <button type='button' class='close' data-dismiss='alert'>&times;</button>"+data.Msg+"</div>");
                                
                                $('#formulario').find('input, textarea, select, button').attr('disabled', 'disabled');
                                $('#frmDetalleM').find('input, textarea, select').attr('disabled', 'disabled');
                                
                                $('#salvar-detalle').attr('disabled', 'disabled');
                                $('#cancelar-movimiento').attr('disabled', 'disabled');
                            }
                            $(window).scrollTop($('#mensaje').offset().top);
                        },
                        "json"
                        );
                    }
                    $.prompt.close();
                }
            });
    })
});

function EliminarItem(codigo, descripcion, unidad, cantidad, idsession, valor){
    var Elemento = new Object();
    
    Elemento.Codigo = codigo;
    Elemento.Elemento = descripcion;
    Elemento.Unidad = unidad;
    Elemento.Cantidad = cantidad;
    Elemento.IdSession = idsession;
    Elemento.Valor = valor;
    
    var DatosJson = JSON.stringify(Elemento);
    $.post(currentLocation + '/agregarCarrito',
    {
        MiCarrito: DatosJson
    },
    function(data, textStatus) {
        $("#carritoSalidas tbody").html("");
        var idses= $('#idsession').val();
        var Subtotal = 0;
        var total    = 0;
        var tCantidad = 0;

        var contador = 0;
        //Recibimos parametro y imprimimos
        $.each(data, function(i, item) {
            var cantsincero = item.cantidad;
            cantsincero = parseInt(cantsincero);
            
            if(cantsincero!=0){
                tCantidad = tCantidad + cantsincero;
                
                contador   = contador + 1;
                var Operacion = parseFloat(item.valor.replace(/\./g,'')) * parseFloat(item.cantidad);
                Subtotal = parseFloat(Subtotal) + parseFloat(item.valor.replace(/\./g,''));
                total    = parseFloat(total) + parseFloat(Operacion);
                
                Subtotal = Subtotal.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
                Subtotal = Subtotal.split('').reverse().join('').replace(/^[\.]/,'');
                
                total = total.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
                total = total.split('').reverse().join('').replace(/^[\.]/,'');
                
                var nuevaFila =
							"<tr>"
							+"<td>"+item.txtCodigo+"</td>"
							+"<td>"+item.elemento+"</td>"
							+"<td>"+item.unidad+"</td>"
							+"<td>"+item.cantidad+"</td>"
							+"<td>$ "+item.valor+"</td>"
							+"<td>$ "+Operacion+"</td>"
							+"<td><div align='center'>"
							+'<img onclick="EliminarItem('
							+"'"+item.txtCodigo+"',"
							+"'"+item.elemento+"',"
                            +"'"+item.unidad+"',"
							+"'-1',"
							+"'"+idses+"',"
							+"'"+item.valor+"'"
							+ ')"' 
							+" src='../../img/delete.png' width='20' title='Eliminar'/></div></td>"
							+"</tr>";
							$(nuevaFila).appendTo("#carritoSalidas tbody");
                            
                            $('#lbltcantidad').text(tCantidad);
							$("#lbltvalor").text("$ " + Subtotal);
                            $("#lbltotal").text("$ " + total);
				}
							
			});
            if(contador==0){
                $("#carritoSalidas tbody").html("");
                var nuevaFila =
                "<tr>"
                +"<td colspan=7><center>No Hay Productos Agregados</center></td>"
                +"</tr>";
                $(nuevaFila).appendTo("#carritoSalidas tbody");
                $('#lbltcantidad').text("0");
                $("#lbltvalor").text("$ 0");
                $("#lbltotal").text("$ 0");
            }
            LimpiarTexto();
   },
   "json"
   );    
}
function LimpiarTexto(){
    $('#elemento').val("");
    $('#unidad').val("");
    $('#cantidad').val("");
    $('#valor').val("");
    
    $("#elemento").focus();
}