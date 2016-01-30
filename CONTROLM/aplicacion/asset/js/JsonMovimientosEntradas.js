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
    $('#idEntradas').autocomplete({
        source: currentLocation + "/Entradas"
    });
    $('#elemento').autocomplete({
        source: currentLocation + "/Elementos",
        select: function(event, ui){
            $('#codigo').val(ui.item.CODIGO);
            $('#descripcion').val(ui.item.DESCRIPCION);
            if($('#tipo').val()=="Legalización Bodega")
              $('#cantidad_asignada').val(ui.item.cantidad);
            $('#unidad').val(ui.item.UNIDAD);
            $('#valor').val(ui.item.VALOR);
            cantidadAsignada = ui.item.cantidad;
        }
    });
    $('#ticket').autocomplete({
        source: currentLocation + "/Tickets"
    });
});

$(document).ready(function(){
    $('#tdTicket').css('display', 'none');
    $('#tdOculto').css('display', 'none');
    $('#ticket').prop('required', false);
    
    soloNumero('#cantidad_legalizada');
    soloNumero('#valor');
    limpiarCero('#valor');
    llenarCero('#valor');
    soloNumero('#ticket');
    formatoNumero('valor');
    
    //----------------------------------------------------------------//
    $('#tipo').change(function(){
        if($('#tipo').val()!="Legalización Bodega"){
            $('#cantidad_asignada').val(cantidadAsignada);
            $('#tdTicket').css('display', 'table-cell');
            $('#tdOculto').css('display', 'table-cell');
            $('#ticket').prop('required', true);
        }else{
            $('#cantidad_asignada').val(cantidadAsignada);
            $('#tdTicket').css('display', 'none');
            $('#tdOculto').css('display', 'none');
            $('#ticket').prop('required', false);
            var legalizado = $('#cantidad_legalizada').val().replace(',', '.') + key;
            
            if(legalizado>cantidadAsignada){
                $('#cantidad_legalizada').val(cantidadAsignada);
            }
        }
    });
    //Evitar que legalicen mas de lo que les dieron en legalizacion bodega
    $('#cantidad_legalizada').keypress(function(e){
        if($('#tipo').val()=="Legalización Bodega"){
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

    //Evitar que legalicen mas de lo que les dieron en legalizacion ticket
    $('#cantidad_legalizada').keypress(function(e){
        if($('#tipo').val()=="Legalización Ticket"){
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
                        var Entrada = new Object();
                        
                        Entrada.fecha_movimiento = '';
                        Entrada.tipo = 'Entrada';
                        Entrada.quien_entrega = $('#quien_entrega').val();
                        Entrada.quien_recibe = $('#quien_recibe').val();
                        Entrada.estado = 'Terminado';
                        Entrada.usuario = '';
                        
                        var DatosJson = JSON.stringify(Entrada);
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
                }
            });
        });
        $('#salvar-entrada').unbind('click');
    });
    
    $('#btnAgregarElemento').click(function(){
        $("form#frmDetalleM").submit(function(){
            var Elemento = new Object();
            var ticket = 0;
            if($('#tdOculto').css('display', 'table-cell'))
              ticket = $('#ticket').val();
            
            Elemento.Codigo = $('#codigo').val();
            Elemento.Elemento = $('#descripcion').val();
            Elemento.Ticket = ticket;
            Elemento.Unidad = $('#unidad').val();
            Elemento.Asignado = $('#cantidad_asignada').val();
            Elemento.Legalizado = $('#cantidad_legalizada').val();
            Elemento.Pendiente = 0;
            Elemento.Tipo = $('#tipo').val();
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
                    var cantsincero = item.legalizado;
                    cantsincero = parseInt(cantsincero);
                    if(cantsincero!=0){
                        tCantidad = tCantidad + cantsincero;
                        total = total.toString().replace(/\./g,'');
                        
                        var Operacion= parseFloat(item.valor.replace(/\./g,'')) * parseFloat(item.legalizado);
                        Subtotal = parseFloat(Subtotal) + parseFloat(item.valor.replace(/\./g,''));
                        total    = parseFloat(total) + parseFloat(Operacion);
                        
                        Subtotal = Subtotal.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
                        Subtotal = Subtotal.split('').reverse().join('').replace(/^[\.]/,'');
                        
                        total = total.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
                        total = total.split('').reverse().join('').replace(/^[\.]/,'');
                        
                        Operacion = Operacion.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
                        Operacion = Operacion.split('').reverse().join('').replace(/^[\.]/,'');
                        
                        var nuevaFila =
                            "<tr>"
                            +"<td>" + item.tipo + "</td>"
                            +"<td>" + item.txtCodigo + "</td>"
                            +"<td>" + item.elemento + "</td>"
                            +"<td>" + item.ticket + "</td>"
                            +"<td>" + item.unidad + "</td>"
                            +"<td>" + item.asignado + "</td>"
                            +"<td>" + item.legalizado + "</td>"
                            +"<td>" + item.pendiente + "</td>"
                            +"<td>$ " + item.valor + "</td>"
                            +"<td>$ " + Operacion + "</td>"
                            +"<td><div align='center'>"
                            +'<img onclick="EliminarItem('
                            +"'" + item.tipo + "',"
                            +"'" + item.txtCodigo + "',"
                            +"'" + item.elemento + "',"
                            +"'" + item.ticket + "',"
                            +"'" + item.unidad + "',"
                            +"'" + item.asignado + "',"
                            +"'-1',"
                            +"'" + item.pendiente + "',"
                            +"'" + item.tipo + "',"
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
        });
        $('#btnAgregarElemento').unbind('click');
    });
    
    $('#salvar-detalle').click(function(){
            $.prompt("¿Desea guardar el detalle de esta entrada?", {
                title: "Control de inventarios. Entrada de bodega",
                buttons: { "Si, guardar cambios": true, "No, cerrar esta ventana": false },
                submit: function(e,v,m,f){
                    if(v==true){
                        var Entrada = new Object();
                        
                        Entrada.id = $('#idEntradas').val();
                        Entrada.estado = 'Terminado';
                        Entrada.IdSession = $('#idsession').val();
                        Entrada.usuario = '';
                        
                        var DatosJson = JSON.stringify(Entrada);
                        $.post(currentLocation + '/entrar',
                        {
                            MiEntrada: DatosJson
                        },
                        function(data, textStatus) {
                            $("#mensaje").empty();
                            if(data.TipoMsg=="Error"){
                                $("#mensaje").html("<div class='alert alert-danger text-center' alert-dismissable><button type='button' class='close' data-dismiss='alert'>&times;</button>"+data.Msg+"</div>");
                            }else{
                                $('#idEntradas').val(data.id);
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
    });
});

function EliminarItem(codigo, descripcion, ticket, unidad, asignado, legalizado, pendiete, tipo, idsession, valor){
    var Elemento = new Object();
    var ticket = 0;
    
    Elemento.Codigo = codigo;
    Elemento.Elemento = descripcion;
    Elemento.Ticket = ticket;
    Elemento.Unidad = unidad;
    Elemento.Asignado = asignado;
    Elemento.Legalizado = legalizado;
    Elemento.Pendiente = pendiete;
    Elemento.Tipo = tipo;
    Elemento.Valor = valor;
    Elemento.IdSession = idsession;
    
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

        var contador = 0;
        //Recibimos parametro y imprimimos
        $.each(data, function(i, item) {
            var cantsincero = item.legalizado;
            cantsincero = parseInt(cantsincero);
            
            if(cantsincero!=0){
                tCantidad = tCantidad + cantsincero;
                
                contador   = contador + 1;
                var Operacion = parseFloat(item.valor.replace(/\./g,'')) * parseFloat(item.legalizado);
                Subtotal = parseFloat(Subtotal) + parseFloat(item.valor.replace(/\./g,''));
                total    = parseFloat(total) + parseFloat(Operacion);
                
                Subtotal = Subtotal.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
                Subtotal = Subtotal.split('').reverse().join('').replace(/^[\.]/,'');
                
                total = total.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
                total = total.split('').reverse().join('').replace(/^[\.]/,'');
                
                var nuevaFila =
                            "<tr>"
                             +"<td>" + item.tipo + "</td>"
                            +"<td>" + item.txtCodigo + "</td>"
                            +"<td>" + item.elemento + "</td>"
                            +"<td>" + item.ticket + "</td>"
                            +"<td>" + item.unidad + "</td>"
                            +"<td>" + item.asignado + "</td>"
                            +"<td>" + item.legalizado + "</td>"
                            +"<td>" + item.pendiente + "</td>"
                            +"<td>$ " + item.valor + "</td>"
                            +"<td>$ " + Operacion + "</td>"
                            +"<td><div align='center'>"
                            +'<img onclick="EliminarItem('
                            +"'" + item.tipo + "',"
                            +"'" + item.txtCodigo + "',"
                            +"'" + item.elemento + "',"
                            +"'" + item.ticket + "',"
                            +"'" + item.unidad + "',"
                            +"'" + item.asignado + "',"
                            +"'-1',"
                            +"'" + item.pendiente + "',"
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
            });
            if(contador==0){
                $("#carritoEntradas tbody").html("");
                var nuevaFila =
                "<tr>"
                +"<td colspan=11><center>No Hay Productos Agregados</center></td>"
                +"</tr>";
                $(nuevaFila).appendTo("#carritoEntradas tbody");
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
    $('#cantidad_legalizada').val("");
    $('#tipo').val("Legalización Bodega");
    $('#cantidad_asignada').val(0);
    $('#valor').val('');
    $('#ticket').val('');
    
    
    $('#tdTicket').css('display', 'none');
    $('#tdOculto').css('display', 'none');
    $('#ticket').prop('required', false);
    
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