$(document).ready(function(){

});

$("#buscarHR").submit(function(e){
    e.preventDefault();

    var items;

    $.ajax({
        type: "POST",
        data: $(this).serialize(),
        url: '/php/consuta_hr.php', 
        dataType: "json",
        success: function(data){
            //SE LIMPIA LA TABLA
            $("#contHR .items").empty();

            $(data).each(function(index, data) {

                if(data.error == true){
                    alert(data.valor);
                }else{
                    items = "<span class='id_auxiliar'>"+ data.ID_AUXILIAR +"</span>";
                    items += "<span class='presona_id'>"+ data.PERSONA_ID +"</span>";
                    items += "<span class='fecha_emision'>"+ data.FECHA_EMISION +"</span>";
                    items += "<span class='determinacion_id'>"+ data.DETERMINACION_ID +"</span>";
                    items += "<span class='codigo'>"+ data.CODIGO +"</span>";
                    items += "<span class='apellidos_nombres'>"+ data.APELLIDOS_NOMBRES +"</span>";
                    items += "<span class='conyugue'>"+ data.CONYUGUE +"</span>";
                    items += "<span class='emision_id'>"+ data.EMISION_ID +"</span>";
                    $("#contHR .items").append(items);
                }
            });
                
        },
        error: function(data) {
            alert("Algo ha salido mal")
        }
    }); //FIN DE AJAX

});