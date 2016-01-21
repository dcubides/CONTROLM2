var currentLocation = window.location;

$(function(){
    /*$('#quien_recive').autocomplete({
        source: currentLocation + "/ListarTecnicos"
    });
    $('#quien_entrega').autocomplete({
        source: currentLocation + "/EncargadoBodega"
    });*/
    $('#requisicion').autocomplete({
        source: currentLocation + "/Requisiciones"
    });
});

$(document).ready(function(){
    $('#frmDetalleM').find('input, textarea, select').attr('disabled', 'disabled');
});