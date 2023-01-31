
// namespace de la aplicación
var UXAPP = UXAPP || {};

// paquete de validaciones
UXAPP.validador = {};

// método que inicia el validador con restriccion de caracteres
UXAPP.validador.init = function () {
    // busca los elementos que contengan el atributo regexp definido
    $("input[regexp]").each(function(){
            // por cada elemento encontrado setea un listener del keypress
            $(this).keypress(function(event){
                
                if ( event.which <= 32 )
                    return 0;
                
                // extrae la cadena que define la expresión regular y creo un objeto RegExp 
                // mas info en https://goo.gl/JEQTcK
                var regexp = new RegExp( "^" + $(this).attr("regexp") + "$" , "g");
                
                // evalua si el contenido del campo se ajusta al patrón REGEXP
                if ( ! regexp.test( $(this).val() + String.fromCharCode(event.which) ) )
                    event.preventDefault();
                
            }); 
        
        });
    
}

// Arranca el validador al término de la carga del DOM
$(document).ready( UXAPP.validador.init );
