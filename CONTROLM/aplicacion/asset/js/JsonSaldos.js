var currentLocation = window.location;
$(function(){
    $('#tecnico').autocomplete({
        source: currentLocation + "/Tecnicos"
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
            $.post(currentLocation + '/InformeSaldos',
            {
                MiTecnico: DatosJson
            },
            function(data, textStatus) {
                $("#carritoInforme tbody").html("");
                $.each(data, function(i, item) {
                    var nuevaFila =
                             "<tr>" 
                             +"<td>" + item.TIPO + "</td>"
                             +"<td>" + item.CODIGO + "</td>"
                             +"<td>" + item.DESCRIPCION + "</td>"
                             +"<td>" + item.UNIDAD + "</td>"
                             +"<td>" + item.CANTIDAD + "</td>"
                             +"<td>" + item.VALOR + "</td>"
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