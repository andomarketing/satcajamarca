$(document).ready(function(){

});

$("#buscarHR").submit(function(e){
    e.preventDefault();

    var items;
    var fila_tabla;

    $.ajax({
        type: "POST",
        data: $(this).serialize(),
        url: 'consuta_hr.php', 
        dataType: "json",
        success: function(data){
            //SE LIMPIA LA TABLA
            $("#contHR .items").empty();
            $("#datosHR tbody").empty();
            $("#datosRelacionados tbody").empty();

            $(data).each(function(index, data) {

                index +=1;

                if(data.error == true){
                    alert(data.valor);
                }else{

                    if(index == 1){
                        items = "<span class='ID_AUXILIAR'>"                + data.persona_id               +"</span>";
                        items += "<span class='persona_id'>"                + data.persona_id                +"</span>";
                        items += "<span class='fecha_de_emision_1'>"        + data.fechaEmision_completa     +"</span>";
                        //items += "<span class='determinacion_id'>"          + data.determinacion_id          +"</span>";
                        items += "<span class='emision'>"                   + data.emision                   +"</span>";
                        items += "<span class='tipo_contribuyente'>"        + data.tipo_Contibuyente        +"</span>";
                        items += "<span class='nro_docu_identidad'>"        + data.nro_docu_identidad        +"</span>";
                        items += "<span class='apellidos_nombres'>"         + data.apellidos_nombres         +"</span>";
                        items += "<span class='direccion_completa'>"        + data.domicilio_completo        +"</span>";
                        //items += "<span class='base_imponible'>"            + data.base_imponible            +"</span>";
                        //items += "<span class='base_afecta'>"               + data.base_afecta               +"</span>";
                        //items += "<span class='impuesto'>"                  + data.impuesto                  +"</span>";
                        //items += "<span class='monto_de_la_cuota'>"         + data.monto_de_la_cuota         +"</span>";
                        $("#contHR .items").append(items);
                    }
                    
                    $(data.HR).each(function(index, HR) {
                        fila_tabla = "<tr>"
                                    + "<td class='item'>"               + HR.item                      +"</td>"
                                    + "<td class='direccion_predial'>"  + HR.UbicacionPredio           +"</td>"
                                    + "<td class='fecha_adquisicion'>"  + HR.fecha_adquisicion         +"</td>"
                                    + "<td class='valor_predio'>"       + HR.valor_Predio              +"</td>"
                                    + "<td class='porc_propiedad'>"     + HR.porc_participacion        +"%</td>"
                                    + "<td class='monto_inafecto'>"     + HR.monto_inafecto            +"</td>"
                                    + "<td class='base_imponible_variable'>"    + HR.valor_afecto   +"</td>"
                                +"<tr>";

                    
                        $("#datosHR tbody").append(fila_tabla);
                    });

                    $(data.relacionados).each(function(index, relacionados) {
                        fila_tabla = "<tr>"
                                    + "<td class='item'>"               + relacionados.item         +"</td>"
                                    + "<td class='relacionado'>"  + relacionados.relacionado  +"</td>"
                                    + "<td class='Tporelacion'>"  + relacionados.Tporelacion  +"</td>"
                                    + "<td class='NroDocumento'>"       + relacionados.NroDocumento +"</td>"
                                +"<tr>";
                    
                        $("#datosRelacionados tbody").append(fila_tabla);
                    });
                    
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