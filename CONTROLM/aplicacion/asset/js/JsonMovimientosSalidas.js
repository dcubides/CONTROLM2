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
});

$(document).ready(function(){
    $("#formulario").submit(function(e){
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
                                $("#mensaje").html("<div class='alert alert-success text-center' alert-dismissable> <button type='button' class='close' data-dismiss='alert'>&times;</button>"+data.Msg+"</div>");
                            }
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
});