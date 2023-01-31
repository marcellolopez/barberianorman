<script>
$( ".regiones" ).change(function() {
    $.ajax({
        type: "GET",
        url:'{{ url("getComunas") }}',
        data: {'region': $("#region").val()},
        success: function (response) {
            $('.comunas').empty();
            $('.comunas').append('<option value="x">Seleccione su comuna</option>')
            if(Object.keys(response).length > 1){
                $.each(response,function(id, data) {
                    $('.comunas').append($("<option></option>").attr("value",data['comuna_id']).text(data['comuna_nombre'])).prop( "disabled", false );
                    
                });
            }else{
                $.each(response,function(id, data) {
                    $('.comunas').append($("<option></option>").attr("value",data['comuna_id']).attr("selected","selected").text(data['comuna_nombre'])).prop( "disabled", false );
                    
                });
            }
        },
        error: function (data) {
            console.log('Error:', data);
            $('.comunas').empty();
            $('.comunas').append('<option value="x">Seleccione su comuna</option>')
        }
    });
});    
</script>