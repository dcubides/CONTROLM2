var currentLocation = window.location;
$(function(){
    var encargado = currentLocation + "/ListarTecnicos";
    $('#quien_recive').autocomplete({
        source: encargado
    });
    
    $('#quien_entrega').autocomplete({
        source: currentLocation + "/EncargadoBodega"
    });
    $('#requisicion').autocomplete({
        source: currentLocation + "/Requisiciones"
    });
});

$(document).ready(function(){
    
});