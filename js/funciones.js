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

function obtener_personas(npagina){

    $.ajax({
        type: "POST",
        data: {"pageno" : npagina},
        url: 'php/datos_personas.php', 
        dataType: "json",
        success: function(data){

            //VARIABLES EN ESTA FUNCION 
            var pactual;
            var tpaginas;

            //SE LIMPIA LA TABLA
            $("#tabla_personas tbody").empty();

            $(data).each(function(index, data) {
                
                index+=1;

                if(data.error == true){
                    alert(data.valor);
                }else{

                    if(index == 1){
                        pactual = data.pagina_actual;
                        tpaginas = data.n_paginas;
                    }
                    
                    items =  '<tr>'+
                                '<td>'+ data.codigo_persona     +'</td>'+
                                '<td>'+ data.nro_docu_identidad +'</td>'+
                                '<td>'+ data.apellidos_nombres  +'</td>'+
                                '<td class="text-center"> <i class="fa fa-times text-danger"></i> </td>'+
                                '<td><button class="btn btn-success" onclick="imprimir_persona('+data.codigo_persona+')" >Imprimir</button></td>'+
                            '</tr>';
                    $("#tabla_personas tbody").append(items);
                }
            });

            $("#paginacion_personas").empty();
            var paginacion =    '<li class="page-item"><a class="page-link" href="javascript:obtener_personas(1)"><<</a></li>'+
                                '<li class="page-item"><a class="page-link" href="javascript:obtener_personas('+ (parseInt(pactual) - 1) +')">< Anterior </a></li>'+
                                '<li class="page-item"><a class="page-link" href="javascript:obtener_personas('+ (parseInt(pactual) + 1) +')">'+ (parseInt(pactual) + 1) +'</a></li>'+
                                '<li class="page-item"><a class="page-link" href="javascript:obtener_personas('+ (parseInt(pactual) + 2) +')">'+ (parseInt(pactual) + 2) +'</a></li>'+
                                '<li class="page-item"><a class="page-link disabled">...</a></li>'+
                                '<li class="page-item"><a class="page-link" href="javascript:obtener_personas('+ (parseInt(tpaginas) - 2) +')">'+ (parseInt(tpaginas) - 2) +'</a></li>'+
                                '<li class="page-item"><a class="page-link" href="javascript:obtener_personas('+ (parseInt(tpaginas) - 1) +')">'+ (parseInt(tpaginas) - 1) +'</a></li>'+
                                '<li class="page-item"><a class="page-link" href="javascript:obtener_personas('+ (parseInt(pactual) + 1) +')">Siguiente ></a></li>'+
                                '<li class="page-item"><a class="page-link" href="javascript:obtener_personas('+ parseInt(tpaginas) +')">>></a></li>';
            $("#paginacion_personas").append(paginacion);
                
        },
        error: function(data) {
            alert("Algo ha salido mal")
        }
    }); //FIN DE AJAX
}