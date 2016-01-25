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
            var Consulta = new Object();
            
            Consulta.movimiento = $('#idmovimiento').val();
            Consulta.tipo = $('#tipo').val();
            Consulta.ticket = $('#ticket').val();
            Consulta.requisicion = $('#requisicion').val();
            Consulta.elemento = $('#elemento').val();
            Consulta.fecha = $('#fecha').val();
            Consulta.nombre = $('#tecnico').val();
            
            var DatosJson = JSON.stringify(Consulta);
            $.post(currentLocation + '/InformeKardex',
            {
                MiConsulta: DatosJson
            },
            function(data, textStatus) {
                $("#carritoInforme tbody").html("");
                $.each(data, function(i, item) {
                    var nuevaFila =
                             "<tr>" 
                             +"<td>" + item.Movimiento + "</td>"
                             +"<td>" + item.fecha_movimiento + "</td>"
                             +"<td>" + item.Entrega + "</td>"
                             +"<td>" + item.Recibe + "</td>"
                             +"<td>" + item.Elemento + "</td>"
                             +"<td>" + item.Tipo_Movimiento + "</td>"
                             +"<td>" + item.Requisicion + "</td>"
                             +"<td>" + item.Ticket + "</td>"
                             +"<td>" + item.Entregado + "</td>"
                             +"<td>" + item.Legalizado + "</td>"
                             +"<td>" + item.pendiente + "</td>"
                             +"<td>" + item.Valor_Unitario + "</td>"
                             +"<td>" + item.Total + "</td>"
                             +"</tr>";
                    $(nuevaFila).appendTo("#carritoInforme tbody");
                });
            },
            "json"
            );
        });
    });
    
    $('#descargar').click(function(){
        window.open(currentLocation + "/Exportar?movimiento=" + $('#idmovimiento').val() + "&tipo=" + $('#tipo').val() + "&ticket=" + $('#ticket').val() +
        "&requisicion=" + $('#requisicion').val() + "&elemento=" + $('#elemento').val() + "&fecha=" + $('#fecha').val() + "&nombre=" + $('#tecnico').val());
    });
});