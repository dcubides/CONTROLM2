var currentLocation = window.location;
$(document).ready(function(){
    $('#quien_recive').autocomplete({
        source: currentLocation + "/BuscarTecnico",
        select: function(event, ui){
            
        }
        
    });
});