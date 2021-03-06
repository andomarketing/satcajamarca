$(document).ready(function(){

});

$("#buscarHR").submit(function(e){
    e.preventDefault();

    var items;
    var fila_tabla;

    $.ajax({
        type: "POST",
        data: $(this).serialize(),
        url: '/php/datos_contribuyente.php', 
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
                        items += "<span class='base_imponible'>"            + data.pie_HR["0"].cantidadPredios   +"</span>";
                        items += "<span class='base_afecta'>"               + data.pie_HR["0"].PrediosAfectos    +"</span>";
                        items += "<span class='impuesto'>"                  + data.pie_HR["0"].valor_TotalAfecto +"</span>";
                        items += "<span class='monto_de_la_cuota'>"         + data.pie_HR["0"].impuestoPredial   +"</span>";
                        $("#contHR .items").append(items);
                    }
                    
                    $(data.HR).each(function(index, HR) {
                        console.log("Cantidad Filas: " + data.HR.length)
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
                        console.log("Cantidad Relacionados: " + data.relacionados.length)
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
            $("#dtsPU .items").empty();

            var contenedor;
            $(data).each(function(index, data) {

                index +=1;

                if(data.error == true){
                    alert(data.valor);
                }else{

                    
                    
                    $(data.PU).each(function(npu, PU) {

                        npu += 1;

                        contenedor = ''
                        +'<div class="contPU PU_'+npu+'">'
                            //+'<img src="../../img/CuponeraFINAL5 CONTORNOS-05.png" alt="HR" class="img img-fluid">'
                            +'<div class="items"><!-- DATOS DE DB --></div>'
                            +'<table class="construcciones">'
                              + ' <tbody>'
                              +  '</tbody>'
                            +'</table>'

                            +'<table class="instalaciones">'
                              +  '<tbody>'
                               + '</tbody>'
                            +'</table>'
                        +'</div>';

                        $("#dtsPU").append(contenedor);

                        items = "<span class='persona_id'>"                 + data.persona_id               +"</span>";
                        items +=  "<span class='determinacion_id'>"         + data.NroDeclaracionJurada     +"</span>";
                        items += "<span class='emision'>"                   + data.emision                  +"</span>";
                        items += "<span class='tipo_contribuyente'>"        + data.tipo_Contibuyente        +"</span>";
                        items += "<span class='apellidos_nombres'>"         + data.apellidos_nombres        +"</span>";
                        items += "<span class='direccion_completa'>"        + PU.direccion_completa       +"</span>";                        
                        $(".PU_"+npu+" .items").append(items);

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

                        $(".PU_"+npu+" .items").append(items);

                        $(data.construcciones).each(function(index3, construccion){

                            if(PU.predio_id == construccion.predio_id){

                                items = "<tr>"
                                            +"<td class='item'>"                    + construccion.item                  +"</td>"
                                            +"<td class='tipo_nivel'>"              + construccion.TipoNivel             +"</td>"
                                            +"<td class='nro_nivel'>"               + construccion.nro_nivel             +"</td>"
                                            +"<td class='seccion'>"                 + construccion.seccion               +"</td>"
                                            +"<td class='anno_construccion'>"       + construccion.anno_construccion     +"</td>"
                                            +"<td class='material_predominante'>"   + construccion.material_predominante +"</td>"
                                            +"<td class='estado_conservacion'>"     + construccion.estado_concervacion   +"</td>"
                                            +"<td class='muros'>"                   + construccion.muros                 +"</td>"
                                            +"<td class='techo'>"                   + construccion.techo                 +"</td>"
                                            +"<td class='pisos'>"                   + construccion.pisos                 +"</td>"
                                            +"<td class='puertas'>"                 + construccion.puertas               +"</td>"
                                            +"<td class='revestimiento'>"           + construccion.revestimientos        +"</td>"
                                            +"<td class='bannos'>"                  + construccion.bannos                +"</td>"
                                            +"<td class='electrico'>"               + construccion.electricos            +"</td>"
                                            +"<td class='valor_unitario'>"          + construccion.valor_unitario        +"</td>"
                                            +"<td class='valor_incremento'>"        + construccion.valor_incremento      +"</td>"
                                            +"<td class='porc_depreciacion'>"       + construccion.porc_depreciacion     +"</td>"
                                            +"<td class='valor_depreciacion'>"      + construccion.valor_depreciacion    +"</td>"
                                            +"<td class='valor_unitario_depre'>"    + construccion.valor_unitario_depre  +"</td>"
                                            +"<td class='valor_unitario_depre'>"    + construccion.valor_unitario_depre  +"</td>"
                                            +"<td class='valor_area_construida'>"   + construccion.valor_area_construida +"</td>"
                                            +"<td class='valor_construccion'>"      + construccion.valor_construccion    +"</td>"
                                        +"</tr>";

                                
                                $(".PU_"+npu+" .construcciones tbody").append(items);
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
                                            +"<td class='inidad_medida'>"       + instalaciones.unidad_medida        +"</td>"
                                            +"<td class='valor_unitario'>"      + instalaciones.valor_unitario       +"</td>"
                                            +"<td class='valor_instalacion'>"   + instalaciones.valor_instalacion    +"</td>"
                                            +"<td class='fact_oficializacion'>" + instalaciones.factor_oficializacion  +"</td>"
                                            +"<td class='valor_total'>"         + instalaciones.valor_total          +"</td>"
                                        +"</tr>";
                                
                                
                                    $(".PU_"+npu+" .instalaciones tbody").append(items);
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
                        items = "<span class='codigo_predio_pr estilos'>"  + PR.predio_id           +"</span>";
                        items += "<span class='codigo_catastral_pr estilos'>" + PR.codigoCatastral     +"</span>";
                        items += "<span class='condicion_propiedad_pr estilos'>" + PR.condicion_propiedad     +"</span>";
                        items += "<span class='condicion_propiedad2_pr estilos'>" + PR.condicion_propiedad     +"</span>";
                        items += "<span class='altitud_pr estilos'>" + PR.altitud     +"</span>";
                        items += "<span class='porc_propiedad_pr estilos'>" + PR.porc_propiedad     +"</span>";
                        items += "<span class='categoria_rustico_pr estilos'>" + PR.categoria_rustico     +"</span>";
                        items += "<span class='tipo_tierra_pr '>" + PR.tipo_tierra     +"</span>";
                        items += "<span class='uso_pr estilos'>" + PR.uso     +"</span>";
                        items += "<span class='area_pr estilos'>" + PR.area     +"</span>";
                        items += "<span class='arancel_pr estilos'>" + PR.arancel     +"</span>";
                        items += "<span class='valor_terreno_pr estilos'>" + PR.valor_terreno     +"</span>";

                        items += "<span class='valor_constru_fin_pr estilos'>" + PR.valor_construccion     +"</span>";

                        items += "<span class='valor_terreno_fin_pr estilos'>" + PR.valor_terreno     +"</span>";
                        items += "<span class='valor_instalacion_fin_pr estilos'>" + PR.valor_instalacion     +"</span>";

                        items += "<span class='valor_inponible_pr estilos'>" + PR.base_imponible     +"</span>";
                        
                        $("#contPR .items").append(items);
                       
                        var n_item_instalaciones2;
                        $(data.construcciones).each(function(index3, construccion){
                           
                            if(PR.predio_id == construccion.predio_id){

                                if(n_item_instalaciones2 !== construccion.item){
                                    n_item_instalaciones2 = construccion.item


                                items = "<tr>"
                                            +"<td class='item_tabla_pr '>"                     + construccion.item                +"</td>"
                                            +"<td class='tipo_tabla_nivel_pr gira'>"               + construccion.TipoNivel         +"</td>"
                                            +"<td class='nro_nivel_tabla_pr gira'>"                + construccion.nro_nivel          +"</td>"
                                            +"<td class='seccion_pr gira'>"                  + construccion.seccion     +"</td>"
                                            +"<td class='anno_construccion_pr gira'>"        + construccion.anno_construccion               +"</td>"
                                            +"<td class='material_predominante_pr gira'>"    + construccion.material_predominante        +"</td>"
                                            +"<td class='estado_conservacion_pr gira'>"           + construccion.estado_concervacion     +"</td>"
                                            +"<td class='muros_pr'>"                    + construccion.muros    +"</td>"
                                            +"<td class='techo_pr'>"                    + construccion.techo   +"</td>"
                                            +"<td class='pisos_pr'>"              + construccion.pisos           +"</td>"
                                            +"<td class='puertas_pr'>"              + construccion.puertas           +"</td>"
                                            +"<td class='revestimiento_pr'>"              + construccion.revestimientos           +"</td>"
                                            +"<td class='bannos_pr'>"                   + construccion.bannos           +"</td>"
                                            +"<td class='electrico_pr'>"                 + construccion.electricos           +"</td>"
                                            +"<td class='valor_unitario_pr gira'>"              + construccion.valor_unitario           +"</td>"
                                            +"<td class='valor_incremento_pr gira'>"             + construccion.valor_incremento           +"</td>"
                                            +"<td class='porc_depreciacion_pr'>"              + construccion.porc_depreciacion           +"</td>"
                                            +"<td class='valor_unitario_depre_pr'>"             + construccion.valor_unitario_depre           +"</td>"
                                            +"<td class='valor_area_construida_pr gira'>"             + construccion.valor_area_construida           +"</td>"
                                            +"<td class='valor_unitario_depre_pr gira'>"             + construccion.valor_unitario_depre           +"</td>"
                                            +"<td class='valor_unitario_depre2_pr gira'>"             + construccion.valor_unitario_depre           +"</td>"
                                            +"<td class='valovalor_construccionr_total_pr ' >"           + construccion.valor_construccion           +"</td>"

                                            +"<td class='valor_unitario_total2_pr '>"             + construccion.valor_unitario_depre           +"</td>"
                                            +"<td class='valovalor_construccionr_total2_pr ' >"           + construccion.valor_construccion           +"</td>"
                                        +"</tr>";

                              
                               
                                        $("#contPR .construcciones_pr tbody").append(items);
                                }
                            }

                        });

                        var n_item_instalaciones3;
                        $(data.instalaciones).each(function(index3, instalaciones){
                           
                            if(PR.predio_id == instalaciones.predio_id){

                                if(n_item_instalaciones3 !== instalaciones.item){
                                    n_item_instalaciones3 = instalaciones.item

                              

                              items = "<tr>"
                              +"<td class='item_insta_pr'>"                + instalaciones.item                 +"</td>"
                              +"<td class='tipo_obra_id_pr'>"        + instalaciones.tipo_obra_id         +"</td>"
                              +"<td class='descripcion_pr'>"         + instalaciones.descripcion          +"</td>"
                              +"<td class='anno_instalacion_pr'>"    + instalaciones.anno_instalacion     +"</td>"
                              +"<td class='medida_pr'>"              + instalaciones.medida               +"</td>"
                              +"<td class='unidad_medida_pr'>"       + instalaciones.unidad_medida        +"</td>"
                              +"<td class='valor_unitario_pr'>"      + instalaciones.valor_unitario       +"</td>"
                              +"<td class='valor_instalacion_pr'>"   + instalaciones.valor_instalacion    +"</td>"
                              +"<td class='fact_oficializacion_pr'>" + instalaciones.factor_oficializacion  +"</td>"
                              +"<td class='valor_total_pr'>"         + instalaciones.valor_total          +"</td>"
                            +"</tr>";
                  
                              
                               
                                        $("#contPR .instalaciones_pr tbody").append(items);
                                }
                            }

                        });


                        
                      
                    });
                    
                }
            });
                
        },
        error: function(data) {
            alert("Algo ha salido mal")
        }
    }); //FIN DE AJAX
});


// CONSULTA HLP

$("#consultarHLP").submit(function(e){

    e.preventDefault();

    $.ajax({
        type: "POST",
        data: $(this).serialize(),
        url: '../php/datos_contribuyente.php', 
        dataType: "json",
        success: function(data){
            //SE LIMPIA LA TABLA
            $("#contHLP .items").empty();
            $("#datosHLP tbody").empty();
            $("#datosRelacionados tbody").empty();

            $(data).each(function(index, data) {
                console.log(data);
                index +=1;

                if(data.error == true){
                    alert(data.valor);
                }else{

                    if(index == 1){
                        items = "<span class='persona_id_hlp estilos'>"                 + data.persona_id               +"</span>";
                        items += "<span class='emision_pr estilos'>"                   + data.emision                  +"</span>";
                        items += "<span class='apellidos_nombres_hlp estilos'>"         + data.apellidos_nombres        +"</span>";
                       
                        $("#contHLP .items").append(items);
                    }
                    
                   
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
        //alert('Solo se permiten numeros');
        xNumero = xNumero;
    }
}