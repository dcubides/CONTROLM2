var currentLocation = window.location;
var cantidadAsignada = 0;
$(function(){
    $('#quien_recibe').autocomplete({
        source: currentLocation + "/EncargadoBodega"
    });
    $('#quien_entrega').autocomplete({
        source: currentLocation + "/ListarTecnicos"
    });
    $('#ticket').autocomplete({
        source: currentLocation + "/Tickets"
    });
    /*$('#idEntradas').autocomplete({
        source: currentLocation + "/Salidas"
    });*/
    $('#elemento').autocomplete({
        source: currentLocation + "/Elementos",
        select: function(event, ui){
            $('#codigo').val(ui.item.CODIGO);
            $('#descripcion').val(ui.item.DESCRIPCION);
            $('#cantidad_asignada').val(ui.item.cantidad);
            $('#unidad').val(ui.item.UNIDAD);
            $('#valor').val(ui.item.valor);
            cantidadAsignada = ui.item.cantidad;
        }
    });
});

$(document).ready(function(){
    soloNumero('#cantidad_legalizada');
    soloNumero('#valor');
    limpiarCero('#valor');
    llenarCero('#valor');
    soloNumero('#ticket');
    formatoNumero('valor');
    
    //----------------------------------------------------------------//
    $('#tipo').change(function(){
        if($('#tipo').val()!="Legalización"){
            $('#cantidad_asignada').val(0);
        }else{
            $('#cantidad_asignada').val(cantidadAsignada);
            var legalizado = $('#cantidad_legalizada').val().replace(',', '.') + key;
            
            if(legalizado>cantidadAsignada){
                $('#cantidad_legalizada').val(cantidadAsignada);
            }
        }
    });
    //Evitar que legalicen mas de lo que les dieron
    $('#cantidad_legalizada').keypress(function(e){
        if($('#tipo').val()=="Legalización"){
            key = String.fromCharCode(e.keyCode);
            var legalizado = $('#cantidad_legalizada').val().replace(',', '.') + key;
            var asignado = $('#cantidad_asignada').val();
            
            if(asignado=='')
              asignado = '0';
            
            legalizado = parseFloat(legalizado);
            if(asignado>=legalizado){}
            else{
                return false;
            }
        }
    });
    //----------------------------------------------------------------//
    
    
    $("#formulario").submit(function(e){
        return false;
    });
    $('#frmDetalleM').submit(function(e){
        return false;
    });
        
    $('#frmDetalleM').find('input, textarea, select').attr('disabled', 'disabled');
    
    $('#salvar-entrada').click(function(){
        $("form#formulario").submit(function(){
            $.prompt("¿Desea generar una nueva entrada?", {
                title: "Control de inventarios. Devolucion tecnico",
                buttons: { "Si, crear entrada": true, "No, cerrar esta ventana": false },
                submit: function(e,v,m,f){
                    if(v==true){
                        var Salida = new Object();
                        
                        Salida.fecha_movimiento = '';
                        Salida.tipo = 'Entrada';
                        Salida.quien_entrega = $('#quien_entrega').val();
                        Salida.quien_recibe = $('#quien_recibe').val();
                        Salida.estado = 'Terminado';
                        //Salida.requisicion = $('#ticket').val();
                        Salida.usuario = '';
                        
                        var DatosJson = JSON.stringify(Salida);
                        $.post(currentLocation + '/nuevaEntrada',
                        {
                            MiEntrada: DatosJson
                        },
                        function(data, textStatus) {
                            if(data.TipoMsg=="Error"){
                                $("#mensaje").html("<div class='alert alert-danger text-center' alert-dismissable><button type='button' class='close' data-dismiss='alert'>&times;</button>"+data.Msg+"</div>");
                            }else{
                                $('#idEntradas').val(data.id);
                                $("#mensaje").html("<div class='alert alert-success text-center' alert-dismissable> <button type='button' class='close' data-dismiss='alert'>&times;</button>"+data.Msg+"</div>");
                                
                                $('#formulario').find('input, textarea, select, button').attr('disabled', 'disabled');
                                $('#frmDetalleM').find('input, textarea, select').removeAttr("disabled");
                                $('#idEntradas').find('input, textarea, select').removeAttr("disabled");
                                                                
                                $('clear-entrada').removeAttr("disabled");
                                $('#elemento').focus();
                            }
                            
                            $('#mensaje').focus();
                        },
                        "json"
                        );
                    }
                    $.prompt.close();
                    $('#salvar-entrada').unbind('click');
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
            Elemento.Cantidad = $('#cantidad_legalizada').val();
            Elemento.Valor = $('#valor').val();
            Elemento.IdSession = $('#idsession').val();
            
            var DatosJson = JSON.stringify(Elemento);
            $.post(currentLocation + '/agregarCarrito',
            {
                MiCarrito: DatosJson
            },
            function(data, textStatus) {
                $("#carritoEntradas tbody").html("");
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
                            $(nuevaFila).appendTo("#carritoEntradas tbody");
                            
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
                        Salida.estado = 'Pendiente';
                        Salida.IdSession = $('#idsession').val();
                        Salida.usuario = '';
                        
                        var DatosJson = JSON.stringify(Salida);
                        $.post(currentLocation + '/sacar',
                        {
                            MiEntrada: DatosJson
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
function LimpiarTexto(){
    $('#elemento').val("");
    $('#unidad').val("");
    $('#cantidad').val("");
    $('#valor').val("");
    
    $("#elemento").focus();
}
function limpiarCero(id){
    $(id).focus(function(){
        var valor = $(id).val().replace(/\./g, '');
        if(valor=='')
        valor = '0';
        if(valor=='0')
        $(id).val('');
    });
}
function llenarCero(id){
    $(id).focusout(function(){
        var valor = $(id).val().replace(/\./g, '');
        if(valor=='')
          $(id).val('0');
    });
}
function formatoNumero(id){
    $('#' + id).keyup(function(){
        var input = document.getElementById(id);
        var num = input.value.replace(/\./g,'');
        
        if(!isNaN(num)){
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/,'');
            input.value = num;
        }
    });
}
function soloNumero(id){
    $(id).keypress(function(e){
        key = e.keyCode || e.which;
        tecla = String.fromCharCode(key).toLowerCase();
        letras = ' 0123456789';
        especiales = [9, 13];
        
        tecla_especial = false
        for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial)
          return false;
    });
}