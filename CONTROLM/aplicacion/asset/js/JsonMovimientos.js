var currentLocation = window.location;
$(function(){
    $('#tecnico').autocomplete({
        source: currentLocation + "/Tecnicos"
    });
    $('#idmovimiento').autocomplete({
        source: currentLocation + "/Movimiento"
    });
    $('#tipo').autocomplete({
        source: currentLocation + "/Tipo"
    });
    $('#ticket').autocomplete({
        source: currentLocation + "/Tickets"
    });
    $('#requisicion').autocomplete({
        source: currentLocation + "/Requisicion"
    });
    $('#elemento').autocomplete({
        source: currentLocation + "/Elemento"
    });
    $('#fecha').autocomplete({
        source: currentLocation + "/Fecha"
    });

});
$(document).ready(function(){
    $("#formulario").submit(function(e){
        return false;
    });
    
    $('#consultar').click(function(){
        $("form#formulario").submit(function(){
            var Tecnico = new Object();
            
            Tecnico.nombre = $('#tecnico').val();
            
            var DatosJson = JSON.stringify(Tecnico);
            $.post(currentLocation + '/InformeKardex',
            {
                MiTecnico: DatosJson
            },
            function(data, textStatus) {
                $("#carritoInforme tbody").html("");
                $.each(data, function(i, item) {
                    var nuevaFila =
                             "<tr>" 
                             +"<td>" + item.MOVIMIENTO + "</td>"
                             +"<td>" + item.FECHA_MOVIMIENTO + "</td>"
                             +"<td>" + item.ENTREGA + "</td>"
                             +"<td>" + item.RECIBE + "</td>"
                             +"<td>" + item.ELEMENTO + "</td>"
                             +"<td>" + item.TIPO_MOVIMIENTO + "</td>"
                             +"<td>" + item.REQUISICION + "</td>"
                             +"<td>" + item.TICKET + "</td>"
                             +"<td>" + item.ENTREGADO + "</td>"
                             +"<td>" + item.LEGALIZADO + "</td>"
                             +"<td>" + item.PENDIENTE + "</td>"
                             +"<td>" + item.VALOR_UNITARIO + "</td>"
                             +"<td>" + item.TOTAL + "</td>"
                             +"</tr>";
                    $(nuevaFila).appendTo("#carritoInforme tbody");
                });
            },
            "json"
            );
        });
    });
    
    $('#descargar').click(function(){
        window.open(currentLocation + "/Exportar?nombre=" + $('#tecnico').val());
    });
});