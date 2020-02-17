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
                        //items = "<span class='ID_AUXILIAR'>"                + data.persona_id               +"</span>";
                        items = "<span class='persona_id'>"                + data.persona_id               +"</span>";
                        //items += "<span class='fecha_de_emision_1'>"        + data.fechaEmision_completa    +"</span>";
                        items += "<span class='determinacion_id'>"          + data.NroDeclaracionJurada     +"</span>";
                        items += "<span class='emision'>"                   + data.emision                  +"</span>";
                        items += "<span class='tipo_contribuyente'>"        + data.tipo_Contibuyente        +"</span>";
                        items += "<span class='nro_docu_identidad'>"        + data.nro_docu_identidad       +"</span>";
                        items += "<span class='apellidos_nombres'>"         + data.apellidos_nombres        +"</span>";
                        items += "<span class='direccion_completa'>"        + data.domicilio_completo       +"</span>";
                        items += "<span class='base_imponible'>"            + data.pie_HR.cantidadPredios   +"</span>";
                        items += "<span class='base_afecta'>"               + data.pie_HR.PrediosAfectos    +"</span>";
                        items += "<span class='impuesto'>"                  + data.pie_HR.valor_TotalAfecto +"</span>";
                        items += "<span class='monto_de_la_cuota'>"         + data.pie_HR.impuestoPredial   +"</span>";
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

$("#consultarPU").submit(function(e){

    e.preventDefault();

    $.ajax({
        type: "POST",
        data: $(this).serialize(),
        url: '/php/datos_contribuyente.php', 
        dataType: "json",
        success: function(data){
            //SE LIMPIA LA TABLA
            $("#contPU .items").empty();
            $("#datosHR tbody").empty();
            $("#datosRelacionados tbody").empty();

            $(data).each(function(index, data) {

                index +=1;

                if(data.error == true){
                    alert(data.valor);
                }else{

                    if(index == 1){
                        items = "<span class='persona_id'>"                 + data.persona_id               +"</span>";
                        items +=  "<span class='determinacion_id'>"         + data.NroDeclaracionJurada     +"</span>";
                        items += "<span class='emision'>"                   + data.emision                  +"</span>";
                        items += "<span class='tipo_contribuyente'>"        + data.tipo_Contibuyente        +"</span>";
                        items += "<span class='apellidos_nombres'>"         + data.apellidos_nombres        +"</span>";
                        items += "<span class='direccion_completa'>"        + data.domicilio_completo       +"</span>";                        
                        $("#contPU .items").append(items);
                    }
                    
                    $(data.PU).each(function(index, PU) {

                        items = "<span class='predio_id'>"              + PU.predio_id           +"</span>";
                        items += "<span class='codigoCatastral'>"       + PU.codigoCatastral     +"</span>";
                        items += "<span class='lugar'>"                 + PU.lugar               +"</span>";
                        items += "<span class='sector'>"                + PU.sector              +"</span>";
                        items += "<span class='ubicacion_predio'>"      + PU.ubicacion_predio    +"</span>";
                        items += "<span class='area_terreno'>"          + PU.area_terreno        +"</span>";
                        items += "<span class='condicion_propiedad'>"   + PU.condicion_propiedad +"</span>";
                        items += "<span class='arancel'>"               + PU.arancel             +"</span>";
                        items += "<span class='porc_participacion'>"    + PU.porc_paticipacion   +"</span>";
                        items += "<span class='valor_terreno'>"         + PU.valor_terreno       +"</span>";
                        items += "<span class='valor_construccion'>"    + PU.valor_construccion  +"</span>";
                        items += "<span class='area_construida'>"       + PU.area_construida     +"</span>";

                        //VALOR PRESIO SECCION
                        items += "<span class='PU_valor_terreno'>"         + PU.valor_terreno       +"</span>";
                        items += "<span class='PU_valor_construccion'>"    + PU.valor_construccion  +"</span>";
                        items += "<span class='PU_valor_instalacion'>"     + PU.valor_instalacion   +"</span>";
                        items += "<span class='PU_base_imponible'>"        + PU.base_imponible      +"</span>";

                        $("#contPU .items").append(items);

                        $(data.construcciones).each(function(index3, construccion){

                            if(PU.predio_id == construccion.predio_id){

                                items = "<tr>"
                                            +"<td class='item'>"                    + construccion.item                  +"</td>"
                                            +"<td class='tipo_nivel'>"              + construccion.tipo_nivel            +"</td>"
                                            +"<td class='nro_nivel'>"               + construccion.nro_nivel             +"</td>"
                                            +"<td class='seccion'>"                 + construccion.seccion               +"</td>"
                                            +"<td class='anno_construccion'>"       + construccion.anno_construccion     +"</td>"
                                            +"<td class='material_predominante'>"   + construccion.material_predominante +"</td>"
                                            +"<td class='estado_conservacion'>"     + construccion.estado_conservacion   +"</td>"
                                            +"<td class='muros'>"                   + construccion.muros                 +"</td>"
                                            +"<td class='techo'>"                   + construccion.techo                 +"</td>"
                                            +"<td class='pisos'>"                   + construccion.pisos                 +"</td>"
                                            +"<td class='puertas'>"                 + construccion.puertas               +"</td>"
                                            +"<td class='revestimiento'>"           + construccion.revestimiento         +"</td>"
                                            +"<td class='bannos'>"                  + construccion.bannos                +"</td>"
                                            +"<td class='electrico'>"               + construccion.electrico             +"</td>"
                                            +"<td class='valor_unitario'>"          + construccion.valor_unitario        +"</td>"
                                            +"<td class='valor_incremento'>"        + construccion.valor_incremento      +"</td>"
                                            +"<td class='porc_depreciacion'>"       + construccion.porc_depreciacion     +"</td>"
                                            +"<td class='valor_unitario_depre'>"    + construccion.valor_unitario_depre  +"</td>"
                                            +"<td class='valor_area_construida'>"   + construccion.valor_area_construida +"</td>"
                                            +"<td class='valor_construccion'>"      + construccion.valor_construccion    +"</td>"
                                        +"</tr>";

                                
                                $("#contPU .construcciones tbody").append(items);
                            }

                        });

                        var n_item_instalaciones;

                        $(data.instalaciones).each(function(index4, instalaciones){
                            if(PU.predio_id == instalaciones.predio_id){

                                if(n_item_instalaciones !== instalaciones.item){
                                    n_item_instalaciones = instalaciones.item
                                    items = "<tr>"
                                            +"<td class='item'>"                + instalaciones.item                 +"</td>"
                                            +"<td class='tipo_obra_id'>"        + instalaciones.tipo_obra_id         +"</td>"
                                            +"<td class='descripcion'>"         + instalaciones.descripcion          +"</td>"
                                            +"<td class='anno_instalacion'>"    + instalaciones.anno_instalacion     +"</td>"
                                            +"<td class='medida'>"              + instalaciones.medida               +"</td>"
                                            +"<td class='inidad_medida'>"       + instalaciones.inidad_medida        +"</td>"
                                            +"<td class='valor_unitario'>"      + instalaciones.valor_unitario       +"</td>"
                                            +"<td class='valor_instalacion'>"   + instalaciones.valor_instalacion    +"</td>"
                                            +"<td class='fact_oficializacion'>" + instalaciones.fact_oficializacion  +"</td>"
                                            +"<td class='valor_total'>"         + instalaciones.valor_total          +"</td>"
                                        +"</tr>";
                                
                                
                                    $("#contPU .instalaciones tbody").append(items);
                                }
                                
                            }
                        })
                        
                    });
                    
                }
            });
                
        },
        error: function(data) {
            alert("Algo ha salido mal")
        }
    }); //FIN DE AJAX
});


//CONSULTA PR
$("#consultarPR").submit(function(e){

    e.preventDefault();

    $.ajax({
        type: "POST",
        data: $(this).serialize(),
        url: '../php/datos_contribuyente.php', 
        dataType: "json",
        success: function(data){
            //SE LIMPIA LA TABLA
            $("#contPR .items").empty();
            $("#datosPR tbody").empty();
            $("#datosRelacionados tbody").empty();

            $(data).each(function(index, data) {

                index +=1;

                if(data.error == true){
                    alert(data.valor);
                }else{

                    if(index == 1){
                        items = "<span class='persona_id_pr estilos'>"                 + data.persona_id               +"</span>";
                        items += "<span class='nro_declaracion_id_pr estilos'>"          + data.NroDeclaracionJurada     +"</span>";
                        items += "<span class='emision_pr estilos'>"                   + data.emision                  +"</span>";
                        //items += "<span class='tipo_contribuyente_hr estilos'>"        + data.tipo_Contibuyente        +"</span>";
                      //  items += "<span class='nro_docu_identidad_hr estilos'>"        + data.nro_docu_identidad       +"</span>";
                        items += "<span class='apellidos_nombres_pr estilos'>"         + data.apellidos_nombres        +"</span>";
                        items += "<span class='direccion_completa_pr estilos'>"        + data.domicilio_completo       +"</span>";
                        $("#contPR .items").append(items);
                    }
                    
                    $(data.PR).each(function(index, PR) {

                        items = "<span class=''>"  + PR.predio_id           +"</span>";
                        items += "<span class=''>" + PR.codigoCatastral     +"</span>";
                        items += "<span class=''>" + PR.lugar               +"</span>";
                        items += "<span class=''>" + PR.sector              +"</span>";
                        items += "<span class=''>" + PR.direccion_completa  +"</span>";
                        items += "<span class=''>" + PR.ubicacion_predio    +"</span>";
                        items += "<span class=''>" + PR.area_terreno        +"</span>";
                        items += "<span class=''>" + PR.condicion_propiedad +"</span>";
                        items += "<span class=''>" + PR.arancel             +"</span>";
                        items += "<span class=''>" + PR.porc_participacion  +"</span>";
                        items += "<span class=''>" + PR.valor_terreno       +"</span>";

                       
                       
                        
                        $("#contPR .items").append(items);
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

function format(xNumero)
{
    var num = xNumero.replace(/\./g,'');
    if(!isNaN(num)){
        num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
        num = num.split('').reverse().join('').replace(/^[\.]/,'');
        xNumero = num;
    }else{ 
        alert('Solo se permiten numeros');
        xNumero = xNumero;
    }
}