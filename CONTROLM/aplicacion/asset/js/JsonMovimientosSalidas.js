var currentLocation = window.location;
$(document).ready(function(){
    $('#quien_recive').autocomplete({
        source: currentLocation + "/BuscarTecnico",
        select: function(event, ui){
            
        }
        
    });
    
    $('#quien_entrega').autocomplete({
        source: currentLocation + "/BuscarEncargado",
        select: function(event, ui){
            
        }
        
    });
});