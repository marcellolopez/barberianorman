<script>
	function spinner(){
		var $spinner = '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>' + 'Cargando';
		return $spinner;
	}
 var segundos = 10; //Segundos de la cuenta atrás 
 function tiempo(){  
 	var t = setTimeout("tiempo()",1000);  
 	document.getElementById('contador').innerHTML = 'Será redireccionado en '+segundos--+" segundos.";  
 	if (segundos==0){
        window.location.href='{{url('/')}}';  //Págiana a la que redireccionará a X segundos

        clearTimeout(t);  
    }  
}  
</script>