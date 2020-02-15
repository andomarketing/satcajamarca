$(document).ready(function(){

});

$("#buscarHR").submit(function(e){
    e.preventDefault();

    var items;

    $.ajax({
        type: "POST",
        data: $(this).serialize(),
        url: 'consulta-pu.php', 
        dataType: "json",
        success: function(data){
            //SE LIMPIA LA TABLA
            $("#contHR .items").empty();

            $(data).each(function(index, data) {

                if(data.error == true){
                    alert(data.valor);
                }else{
                    items += "<span class='presona_id_pu'>"+ data.PERSONA_ID +"</span>";
                    items += "<span class='fecha_emision_pu'>"+ data.FECHA_EMISION +"</span>";
                    items += "<span class='determinacion_id_pu'>"+ data.DETERMINACION_ID +"</span>";
                    items += "<span class='codigo_pu'>"+ data.CODIGO +"</span>";
                    items += "<span class='apellidos_nombres_pu'>"+ data.APELLIDOS_NOMBRES +"</span>";
                   items += "<span class='estado_construccion_pu'>"+ data.ESTADO_CONSTRUCCCION +"</span>";
                   items += "<span class='descripcion_pu'>"+ data.DESCRIPCION +"</span>";
                   items += "<span class='porc_propiedad_pu'>"+ data.PORC_PROPIEDAD +"</span>";
                   items += "<span class='area_terreno_pu'>"+ data.AREA_TERRENO +"</span>";
                   items += "<span class='valor_arancel_pu'>"+ data.VALOR_ARANCEL +"</span>";
                   items += "<span class='valor_terreno_pu'>"+ data.VALOR_TERRENO +"</span>";
                   items += "<span class='direccion_pu'>"+ data.DIRECCION +"</span>";
                   items += "<span class='item_pu'>"+ data.ITEM +"</span>";
                   items += "<span class='nivel_pu'>"+ data.NIVEL +"</span>";
                   items += "<span class='dentiponnivel_pu'>"+ data.DENTIPONIVEL +"</span>";
                   items += "<span class='antiguedad_pu'>"+ data.ANTIGUEDAD +"</span>";
                   items += "<span class='mat_predominante_pu'>"+ data.MAT_PREDOMINANTE_ID +"</span>";
                   items += "<span class='conservacion_pu'>"+ data.CONSERVACION_ID +"</span>";
                   items += "<span class='clasi_depreciacion_pu'>"+ data.CLASI_DEPRECIACION_ID +"</span>";
                   items += "<span class='denmuros_pu'>"+ data.DENMUROS +"</span>";
                   items += "<span class='dentecho_pu'>"+ data.DENTECHO +"</span>";
                   items += "<span class='denpisos_pu'>"+ data.DENPISOS +"</span>";
                   items += "<span class='denpuertas_pu'>"+ data.DENPUERTAS +"</span>";
                   items += "<span class='denrevestimiento_pu'>"+ data.DENREVESTIMIENTO +"</span>";
                   items += "<span class='denbannos_pu'>"+ data.DENBANNOS +"</span>";
                   items += "<span class='denelectrico_pu'>"+ data.DENELECTRICO +"</span>";
                   items += "<span class='valor_unitario_pu'>"+ data.VALOR_UNITARIO +"</span>";
                   items += "<span class='valor_incremento_pu'>"+ data.VALOR_INCREMENTO +"</span>";
                   items += "<span class='porc_depreciacion_pu'>"+ data.PORC_DEPRECIACION +"</span>";
                   items += "<span class='valor_depreciacion_pu'>"+ data.VALOR_DEPRECIACION +"</span>";
                   items += "<span class='area_construida_pu'>"+ data.AREA_CONSTRUIDA +"</span>";
                   items += "<span class='a_const_m2_pu'>"+ data.A_CONST_M2 +"</span>";
                   items += "<span class='a_const_pu'>"+ data.A_CONST +"</span>";

                   items += "<span class='valor_area_construida_pu'>"+ data.VALOR_AREA_CONSTRUIDA +"</span>";
                   items += "<span class='valor_de_construccion_pu'>"+ data.VALOR_DE_CONSTRUCCION +"</span>";
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
            alert("Algo ha salido mal ")
        }
    }); //FIN DE AJAX
}