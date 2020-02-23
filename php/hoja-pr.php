<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PR</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .main{
            margin-top: 36.5mm; 
            margin-left: 15mm;
            max-width: 129mm;
        }
        table {            
            border-spacing: 0px;
            width: 100%;
            border: 0.005mm solid blue;
        }
        .white-text {
            font-weight: 100;
        }
        .pre1-table {
            font-size: 6pt;
            height: 17mm;
            margin-bottom: 1mm;
        }
        .pre1-td {
            padding-left: 3mm;
        }
        .pre1-td-left {}
        .pre1-td-rigth {
            width: 57.4%;
        }
        .pre2-table {
            font-size: 5pt;
            height: 11mm;
            margin-bottom: 1mm;
        }
        .pre2-table td{
            position: relative;
        }
        .pre2-td-left {
            padding-left: 3mm;
            width: 37.1%;
        }
        .pre2-td-rigth {
            width:30%;
        }
        .pre3-table {
            font-size: 5pt;
            border: none;
            margin-bottom: 6mm;
        }
        .pre3-td {
            padding-left: 1.5mm;
        }
        .pre4-table{
            font-size: 4pt;
            height: 6mm;
            margin-bottom: 6mm;
        }
        .pre4-table td{
            position: relative;
        }
        .pre4-td-left {
            padding-left: 1mm;
            width: 36%;
        }
        .pre4-td-rigth {
            width:31%;
        }
        .vertical-text {
            writing-mode: vertical-lr;
            transform: rotate(180deg);
        }
        .horizontal-text {
            font-size: 3pt;
        }
        .const-table {
            font-size: 4pt;
            text-align: center;
            vertical-align: bottom;
            margin-left: -2.5mm;
            margin-bottom: 8mm;
        }
        .const-table td{
            border-right: 0.005mm solid blue;
            border-bottom: 0.005mm solid blue;
        }
        .comp-table {
            font-size: 4pt;
            text-align: center;
        }
        .comp-table tr{
            vertical-align: top;
        }
        .comp-table td{
            border-right: 0.005mm solid blue;
            border-bottom: 0.005mm solid blue;
        }
        @media print{
            .white-text{
                visibility: hidden;
                color: #FFF !important;
            }
            table {            
                border: none;
            }
            .const-table td{
                border-right: none;
                border-bottom: none;
            }
            .comp-table td{
                border-right: none;
                border-bottom: none;
            }
        }
    </style>
</head>
<body>

<?php 
    //CONEXION BASE DE DATOS
    include "db.php";

    //EXISTE UN ERROR DE CONEXION
    if ($mysqli->connect_errno) {
        $data = array("error" => true, "valor" => "Error: " . $mysqli->connect_error);
        echo json_encode($data);
        exit;
    }
    //CONSULTAS SQL
    $contribuyente_sql  = "SELECT * FROM tempo_contribuyentes_2020  WHERE persona_id = 131725";
    //FALLO LA CONSULTA SQL
    if (!$consulta_contribuyente = $mysqli->query($contribuyente_sql)) {
        $data = array("error" => true, "valor" => "Error consultando el contributyente: " . $mysqli->error);
        echo json_encode($data);
        exit;
    }
    while ($contribuyente = $consulta_contribuyente->fetch_array()) {
        //DATOS DEL CONTRIBUYENTE
        $declaracion_jurada = $contribuyente["NroDeclaracionJurada"];
        $emision = $contribuyente["emision"];
        $codigo_contribuyente = $contribuyente["persona_id"];
        $nombre = $contribuyente["apellidos_nombres"];

        $PR_sql = "SELECT * FROM tempo_pr_2020 WHERE persona_id = '$codigo_contribuyente' ORDER BY predio_id ASC";
        //FALLO LA CONSULTA SQL
        if (!$consulta_PR = $mysqli->query($PR_sql)) {
            $data = array("error" => true, "valor" => "Error consultando el PR para el contributyente: " . $mysqli->error);
            echo json_encode($data);
            exit;
        }

        while ($PR = $consulta_PR->fetch_array()) {

            $predio_id = $PR["predio_id"];

            $construcciones_sql = "SELECT * FROM tempo_construcciones_2020  WHERE predio_id = '$predio_id' ORDER BY predio_id ASC";
            //FALLO LA CONSULTA SQL
            if (!$consulta_construcciones = $mysqli->query($construcciones_sql)) {
                $data = array("error" => true, "valor" => "Error consultando contrucciones para el contributyente: " . $mysqli->error);
                echo json_encode($data);
                exit;
            }
            $cantidad_construcciones = $consulta_construcciones->num_rows;
            $contat_contru = 1;
            $offset_contru = 0;

            $instalaciones_sql  = "SELECT * FROM tempo_instalaciones_2020   WHERE predio_id = '$predio_id' ORDER BY predio_id ASC";
            //FALLO LA CONSULTA SQL
            if (!$consulta_instalaciones = $mysqli->query($instalaciones_sql)) {
                $data = array("error" => true, "valor" => "Error consultando instalaciones para el contributyente: " . $mysqli->error);
                echo json_encode($data);
                exit;
            }
            $cantidad_instalaciones = $consulta_instalaciones->num_rows;
            $contat_insta = 1;
            $offset_insta = 0;
            
            if ($cantidad_construcciones > 3 || $cantidad_instalaciones > 4):
                echo "Entro al IF :D Holis ---> ";
                $n_paginas_construcciones = ceil($cantidad_construcciones / 3);
                $n_paginas_instalaciones = ceil($cantidad_instalaciones / 4);
                while ($contat_contru <= $n_paginas_construcciones || $contat_insta <= $n_paginas_instalaciones) : 
                    echo "Mis contadores son $contat_contru -- $contat_insta Y Mis n Paginas $n_paginas_construcciones -- $contat_insta";
                    $construcciones_sql = "SELECT * FROM tempo_construcciones_2020  WHERE predio_id = '$predio_id' ORDER BY predio_id ASC LIMIT $offset_contru, 3";
                    //FALLO LA CONSULTA SQL
                    if (!$consulta_construcciones = $mysqli->query($construcciones_sql)) {
                        $data = array("error" => true, "valor" => "Error consultando contrucciones para el contributyente: " . $mysqli->error);
                        echo json_encode($data);
                        exit;
                    }
                    $instalaciones_sql  = "SELECT * FROM tempo_instalaciones_2020   WHERE predio_id = '$predio_id' ORDER BY predio_id ASC LIMIT $offset_insta, 4";
                    //FALLO LA CONSULTA SQL
                    if (!$consulta_instalaciones = $mysqli->query($instalaciones_sql)) {
                        $data = array("error" => true, "valor" => "Error consultando instalaciones para el contributyente: " . $mysqli->error);
                        echo json_encode($data);
                        exit;
                    }
                
                ?>

                <div class="main" style="display: block; width: 100% ; height: 155mm; font-size: 6pt; font-family: Arial; font-weight: bold; page-break-after: always;">

                    <div style="position: relative; width: 100%;">
                        <span style="position: absolute; top: -11mm; right: 44mm;"> <?= $declaracion_jurada ?> </span>
                        <span style="position: absolute; top: -6.5mm; right: 15mm;"> <?= $emision ?> </span>
                    </div>

                    <!-- DATOS DEL PREDIO -->
                    <table class="pre1-table">
                        <tr class="pre1-tr">
                            <td class="pre1-td pre1-td-left" colspan="2"><span class="white-text">CÓDIGO CONTRIBUYENTE: </span> <?php echo $codigo_contribuyente; ?></td>
                        </tr>
                        <tr class="pre1-tr">
                            <td class="pre1-td pre1-td-left" colspan="2"><span class="white-text">NOMBRE: </span> <?php echo $nombre; ?></td>
                        </tr> 
                        <tr class="pre1-tr">
                            <td class="pre1-td pre1-td-left"><span class="white-text">CÓDIGO PREDIO: </span> <?php echo $PR["predio_id"]; ?></td>
                            <td class="pre1-td pre1-td-rigth"><span class="white-text">CÓDIGO CATASTRAL: </span> <?php echo $PR["codigoCatastral"]; ?></td>
                        </tr>
                        <tr class="pre1-tr">
                            <td class="pre1-td pre1-td-left" colspan="2"><span class="white-text">DIRECCIÓN DE PREDIO:</span> <span style="font-size: 5pt;"> <?php echo strtoupper( $PR["direccion_completa"] ); ?></span></td>
                        </tr>
                    </table>
                    <!-- DATOS DEL PREDIO -->

                    <!-- DESCRIPCION DE PROPIEDAD -->
                    <table class="pre2-table">
                        <tr class="pre2-tr">
                            <td class="pre2-td pre2-td-left"><span class="white-text">COND. PROPIEDAD: </span> <span style="position: absolute; left: 21mm; top: 2.6mm;"> <?php echo $PR["condicion_propiedad"]; ?></td>
                            <td class="pre2-td pre2-td-center"><span class="white-text">% DE PARTICIPACIÓN: </span> <span style="position: absolute; left: 21mm; top: 2.6mm;"> <?php echo $PR["porc_propiedad"]; ?></td>
                            <td class="pre2-td pre2-td-rigth"><span class="white-text">TIPO DE TIERRA: </span> <span style="position: absolute;right: 10px;width: 53%;font-size: 4.5pt;top: 2.5mm;"> <?php echo $PR["tipo_tierra"]; ?></span></td>
                        </tr>
                        <tr class="pre2-tr">
                            <td class="pre2-td pre2-td-left"><span class="white-text">ALTITUD: </span> <?php echo $PR["altitud"]; ?></td>
                            <td class="pre2-td pre2-td-center"><span class="white-text">CATEGORIA: </span> <?php echo $PR["categoria_rustico"]; ?></td>
                            <td class="pre2-td pre2-td-rigth"><span class="white-text">USO: </span> <?php echo $PR["uso"]; ?></td>
                        </tr>
                    </table>
                    <!-- DESCRIPCION DE PROPIEDAD -->

                    <!-- TITULO X -->
                    <table class="pre3-table">
                        <tr>
                            <td class="pre3-td">
                                <span class="white-text">CONDICIÓN DE PROPIEDAD:</span>
                            </td>
                        </tr>
                    </table>
                    <!-- TITULO X -->    

                    <!-- DETERMINACION DEL VALOR DEL PRECIO -->
                    <table class="pre4-table">
                        <tr class="pre4-tr">
                            <td class="pre4-td pre4-td-left"><span class="white-text">AREA DEL TERRENO HA: </span> <span style="font-size: 6pt; position: absolute; top: 2.7mm; right: 9mm"> <?php echo $PR["area"] ?> </span> </td>
                            <td class="pre4-td pre4-td-center"><span class="white-text">VALOR ARANCELARIO: </span> <span style="font-size: 6pt; position: absolute; top: 2.7mm; right: 8mm"> <?php echo $PR["arancel"] ?> </span> </td>
                            <td class="pre4-td pre4-td-rigth"><span class="white-text">VALOR TERNARIO: </span> <span style="font-size: 6pt; position: absolute; top: 2.7mm; right: 2.5mm"> <?php echo $PR["valor_terreno"] ?> </span> </td>
                        </tr>
                    </table>
                    <!-- DETERMINACION DEL VALOR DEL PRECIO -->

                    <!-- CONSTRUCCIONES -->
                    <table class="const-table">
                        <tr style="height: 23mm">
                            <td style="width: 2.5mm; vertical-align: bottom; padding-bottom: 2mm;"></td>
                            <td style="width: 5mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">TN</span></td>
                            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">NN</span></td>
                            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">SECCIÓN</span></td>
                            <td style="width: 3.5mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">ANTIGUEDAD</span></td>
                            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">MP</span></td>
                            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">EDC</span></td>
                            <td style="width: 3.5mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">MC</span></td>
                            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">T</span></td>
                            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">P</span></td>
                            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">PV</span></td>
                            <td style="width: 3.5mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">RV</span></td>
                            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">B</span></td>
                            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">IE</span></td>
                            <td style="width: 7mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">VUPM2</span></td>
                            <td style="width: 6mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">ID5%</span></td>
                            <td style="width: 9mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">%</span></td>
                            <td style="width: 10mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">VALOR</span></td>
                            <td style="width: 9mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">VUD</span></td>
                            <td style="width: 8.8mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">ÁC</span></td>
                            <td style="width: 12.5mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">ÁCM2</span></td>
                            <td style="width: 18mm; vertical-align: bottom; padding-bottom: 2mm;border-bottom: 0.01mm solid blue"><span class="vertical-text white-text">VDLC</span></td>
                        </tr>
                        <?php
                        while ($construcciones = $consulta_construcciones->fetch_array()):
                        ?>
                        <!-- height: 27.5mm -->
                        <tr style="height: 9.1666mm">
                            <td><span class="horizontal-text"> <?php echo $construcciones["item"] ?></span></td>
                            <td><span class="vertical-text"> <?php echo $construcciones["TipoNivel"] ?></span></td>
                            <td><span class="vertical-text"> <?php echo $construcciones["nro_nivel"] ?></span></td>
                            <td><span class="vertical-text"> <?php echo $construcciones["seccion"] ?></span></td>
                            <td><span class="vertical-text"> <?php echo $construcciones["anno_construccion"] ?></span></td>
                            <td><span class="vertical-text"> <?php echo $construcciones["material_predominante"] ?></span></td>
                            <td><span class="vertical-text"> <?php echo $construcciones["estado_concervacion"] ?></span></td>
                            <td><span class="horizontal-text"> <?php echo $construcciones["muros"] ?></span></td>
                            <td><span class="horizontal-text"> <?php echo $construcciones["techo"] ?></span></td>
                            <td><span class="horizontal-text"> <?php echo $construcciones["pisos"] ?></span></td>
                            <td><span class="horizontal-text"> <?php echo $construcciones["puertas"] ?></span></td>
                            <td><span class="horizontal-text"> <?php echo $construcciones["revestimientos"] ?></span></td>
                            <td><span class="horizontal-text"> <?php echo $construcciones["bannos"] ?></span></td>
                            <td><span class="horizontal-text"> <?php echo $construcciones["electricos"] ?></span></td>
                            <td><span class="vertical-text"> <?php echo $construcciones["valor_unitario"] ?></span></td>
                            <td><span class="vertical-text"> <?php echo $construcciones["valor_incremento"] ?></span></td>
                            <td><span class="horizontal-text"> <?php echo $construcciones["porc_depreciacion"] ?></span></td>
                            <td><span class="horizontal-text"> <?php echo $construcciones["valor_depreciacion"] ?></span></td>
                            <td><span class="vertical-text"> <?php echo $construcciones["valor_unitario_depre"] ?></span></td>
                            <td><span class="vertical-text"> <?php echo $construcciones["valor_unitario_depre"] ?></span></td>
                            <td><span class="vertical-text"> <?php echo $construcciones["valor_area_construida"] ?></span></td>
                            <td><span class="vertical-text"> <?php echo $construcciones["valor_construccion"] ?></span></td>
                        </tr>
                        <?php
                        endwhile;
                        ?>
                        <!-- TOTALES -->
                        <tr style="height: 5mm">
                            <td colspan="16">
                            </td>
                            <td colspan="2">
                            </td>
                            <td colspan="2" style="font-size: 6pt;"> <?php echo $PR["area_construida"] ?>
                            </td>
                            <td></td>
                            <td style="font-size: 6pt;"> <?php echo $PR["valor_construccion"] ?></td>
                        </tr>
                        <!-- TOTALES -->
                    </table>
                    <!-- CONSTRUCCIONES -->

                    <!-- DETERMINACION DEL VALOR DE LAS OBRAS -->
                    <table class="comp-table" style="height: 21mm">
                        <tr style="height: 6mm">
                            <td style="width: 8mm; font-size: 3pt"></td>
                            <td style="width: 8mm; font-size: 3pt"></td>
                            <td style="width: 31mm; font-size: 3pt"></td>
                            <td style="width: 16mm; font-size: 3pt"></td>
                            <td style="width: 10mm; font-size: 3pt"></td>
                            <td style="width: 9mm; font-size: 3pt"></td>
                            <td style="width: 10mm; font-size: 3pt"></td>
                            <td style="width: 13mm; font-size: 3pt"></td>
                            <td style="width: 11mm; font-size: 3pt"></td>
                            <td style="width: 11mm; font-size: 3pt"></td>
                        </tr>
                        <!-- DATOS DE INSTALACIONES -->
                        <?php 
                        while ($instalaciones = $consulta_instalaciones->fetch_array()): ?>
                            <!-- 15mm -->
                            <tr style="height: 3mm">
                                <td> <?php echo $instalaciones["item"] ?></td>
                                <td> <?php echo $instalaciones["tipo_obra_id"] ?></td>
                                <td> <?php echo $instalaciones["descripcion"] ?></td>
                                <td> <?php echo $instalaciones["anno_instalacion"] ?></td>
                                <td> <?php echo $instalaciones["medida"] ?></td>
                                <td> <?php echo $instalaciones["unidad_medida"] ?></td>
                                <td> <?php echo $instalaciones["valor_unitario"] ?></td>
                                <td> <?php echo $instalaciones["valor_instalacion"] ?></td>
                                <td> <?php echo $instalaciones["factor_oficializacion"] ?></td>
                                <td> <?php echo $instalaciones["valor_total"] ?></td>
                            </tr>
                            <?php
                            if ($n_paginas_construcciones >= 1 && $contat_contru <= $n_paginas_construcciones) {
                                $contat_contru +=1;
                                $offset_contru =  ($contat_contru - 1) * 3;
                            }
                            if ($n_paginas_instalaciones >= 1 && $contat_insta <= $n_paginas_instalaciones) {
                                $contat_insta +=1;
                                $offset_insta =  ($contat_insta - 1) * 3;
                            }
                        endwhile;
                        ?>
                        <!-- DATOS DE INSTALACIONES -->
                    </table>

                    <table class="comp-table">
                        <tr>
                            <td style="width: 8mm; font-size: 3pt"></td>
                            <td style="width: 8mm; font-size: 3pt"></td>
                            <td style="width: 31mm; font-size: 3pt"></td>
                            <td style="width: 16mm; font-size: 3pt"></td>
                            <td style="width: 10mm; font-size: 3pt"></td>
                            <td style="width: 9mm; font-size: 3pt"></td>
                            <td style="width: 10mm; font-size: 3pt"></td>
                            <td style="width: 13mm; font-size: 3pt"></td>
                            <td style="width: 11mm; font-size: 3pt"></td>
                            <td style="width: 11mm; font-size: 3pt"></td>
                        </tr>
                        <!-- DATOS DE INSTALACIONES -->
                        <tr style="height: 2mm">
                            <td colspan="10"></td>
                        </tr>
                        <tr style="height: 3mm">
                            <td colspan="10"></td>
                        </tr>
                        <tr style="height: 0.2mm">
                            <td colspan="10"></td>
                        </tr>
                        <tr style="height: 3.666666666666667mm">
                            <td colspan="4"></td>
                            <td colspan="4" style="font-size: 3pt; text-align: left; padding: 1mm;"> <span class="white-text">VALOR DE LA CONSTRUCCIÓN</span></td>
                            <td colspan="2" style="font-size: 6pt"><?php echo $PR["valor_construccion"] ?></td>
                        </tr>
                        <tr style="height: 3.666666666666667mm">
                            <td colspan="4"></td>
                            <td colspan="4" style="font-size: 3pt; text-align: left; padding: 1mm"> <span class="white-text">VALOR DE LA CONSTRUCCIÓN</span></td>
                            <td colspan="2" style="font-size: 6pt"><?php echo $PR["valor_terreno"] ?></td>
                        </tr>
                        <tr style="height: 3.666666666666667mm">
                            <td colspan="4"></td>
                            <td colspan="4" style="font-size: 3pt; text-align: left; padding: 1mm"> <span class="white-text">VALOR DE LA CONSTRUCCIÓN</span></td>
                            <td colspan="2" style="font-size: 6pt"><?php echo $PR["valor_instalacion"] ?></td>
                        </tr>
                        <tr style="height: 3.3mm">
                            <td colspan="4"></td>
                            <td colspan="4" style="font-size: 3pt; text-align: left; padding: 1mm"> <span class="white-text">VALOR DE LA CONSTRUCCIÓN</span></td>
                            <td colspan="2" style="font-size: 6pt"><?php echo $PR["base_imponible"] ?></td>
                        </tr>
                    </table>
                    <!-- DETERMINACION DEL VALOR DE LAS OBRAS -->

                </div> 
<?php
                endwhile;
            else: ?>

                <div class="main" style="display: block; width: 100% ; height: 155mm; font-size: 6pt; font-family: Arial; font-weight: bold; page-break-after: always;">

                    <div style="position: relative; width: 100%;">
                            <span style="position: absolute; top: -11mm; right: 44mm;"> <?= $declaracion_jurada ?> </span>
                            <span style="position: absolute; top: -6.5mm; right: 15mm;"> <?= $emision ?> </span>
                    </div>

                    <!-- DATOS DEL PREDIO -->
                    <table class="pre1-table">
                        <tr class="pre1-tr">
                            <td class="pre1-td pre1-td-left" colspan="2"><span class="white-text">CÓDIGO CONTRIBUYENTE: </span> <?php echo $codigo_contribuyente; ?></td>
                        </tr>
                        <tr class="pre1-tr">
                            <td class="pre1-td pre1-td-left" colspan="2"><span class="white-text">NOMBRE: </span> <?php echo $nombre; ?></td>
                        </tr> 
                        <tr class="pre1-tr">
                            <td class="pre1-td pre1-td-left"><span class="white-text">CÓDIGO PREDIO: </span> <?php echo $PR["predio_id"]; ?></td>
                            <td class="pre1-td pre1-td-rigth"><span class="white-text">CÓDIGO CATASTRAL: </span> <?php echo $PR["codigoCatastral"]; ?></td>
                        </tr>
                        <tr class="pre1-tr">
                            <td class="pre1-td pre1-td-left" colspan="2"><span class="white-text">DIRECCIÓN DE PREDIO:</span> <span style="font-size: 5pt;"> <?php echo strtoupper( $PR["direccion_completa"] ); ?></span></td>
                        </tr>
                    </table>
                    <!-- DATOS DEL PREDIO -->

                    <!-- DESCRIPCION DE PROPIEDAD -->
                    <table class="pre2-table">
                        <tr class="pre2-tr">
                            <td class="pre2-td pre2-td-left"><span class="white-text">COND. PROPIEDAD: </span> <span style="position: absolute; left: 21mm; top: 2.6mm;"> <?php echo $PR["condicion_propiedad"]; ?></td>
                            <td class="pre2-td pre2-td-center"><span class="white-text">% DE PARTICIPACIÓN: </span> <span style="position: absolute; left: 21mm; top: 2.6mm;"> <?php echo $PR["porc_propiedad"]; ?></td>
                            <td class="pre2-td pre2-td-rigth"><span class="white-text">TIPO DE TIERRA: </span> <span style="position: absolute;right: 10px;width: 53%;font-size: 4.5pt;top: 2.5mm;"> <?php echo $PR["tipo_tierra"]; ?></span></td>
                        </tr>
                        <tr class="pre2-tr">
                            <td class="pre2-td pre2-td-left"><span class="white-text">ALTITUD: </span> <?php echo $PR["altitud"]; ?></td>
                            <td class="pre2-td pre2-td-center"><span class="white-text">CATEGORIA: </span> <?php echo $PR["categoria_rustico"]; ?></td>
                            <td class="pre2-td pre2-td-rigth"><span class="white-text">USO: </span> <?php echo $PR["uso"]; ?></td>
                        </tr>
                    </table>
                    <!-- DESCRIPCION DE PROPIEDAD -->

                    <!-- TITULO X -->
                    <table class="pre3-table">
                        <tr>
                            <td class="pre3-td">
                                <span class="white-text">CONDICIÓN DE PROPIEDAD:</span>
                            </td>
                        </tr>
                    </table>
                    <!-- TITULO X -->    

                    <!-- DETERMINACION DEL VALOR DEL PRECIO -->
                    <table class="pre4-table">
                        <tr class="pre4-tr">
                            <td class="pre4-td pre4-td-left"><span class="white-text">AREA DEL TERRENO HA: </span> <span style="font-size: 6pt; position: absolute; top: 2.7mm; right: 9mm"> <?php echo $PR["area"] ?> </span> </td>
                            <td class="pre4-td pre4-td-center"><span class="white-text">VALOR ARANCELARIO: </span> <span style="font-size: 6pt; position: absolute; top: 2.7mm; right: 8mm"> <?php echo $PR["arancel"] ?> </span> </td>
                            <td class="pre4-td pre4-td-rigth"><span class="white-text">VALOR TERNARIO: </span> <span style="font-size: 6pt; position: absolute; top: 2.7mm; right: 2.5mm"> <?php echo $PR["valor_terreno"] ?> </span> </td>
                        </tr>
                    </table>
                    <!-- DETERMINACION DEL VALOR DEL PRECIO -->

                    <!-- CONSTRUCCIONES -->
                    <table class="const-table">
                        <tr style="height: 23mm">
                            <td style="width: 2.5mm; vertical-align: bottom; padding-bottom: 2mm;"></td>
                            <td style="width: 5mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">TN</span></td>
                            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">NN</span></td>
                            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">SECCIÓN</span></td>
                            <td style="width: 3.5mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">ANTIGUEDAD</span></td>
                            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">MP</span></td>
                            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">EDC</span></td>
                            <td style="width: 3.5mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">MC</span></td>
                            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">T</span></td>
                            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">P</span></td>
                            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">PV</span></td>
                            <td style="width: 3.5mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">RV</span></td>
                            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">B</span></td>
                            <td style="width: 4mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">IE</span></td>
                            <td style="width: 7mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">VUPM2</span></td>
                            <td style="width: 6mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">ID5%</span></td>
                            <td style="width: 9mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">%</span></td>
                            <td style="width: 10mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="horizontal-text white-text">VALOR</span></td>
                            <td style="width: 9mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">VUD</span></td>
                            <td style="width: 8.8mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">ÁC</span></td>
                            <td style="width: 12.5mm; vertical-align: bottom; padding-bottom: 2mm;"><span class="vertical-text white-text">ÁCM2</span></td>
                            <td style="width: 18mm; vertical-align: bottom; padding-bottom: 2mm;border-bottom: 0.01mm solid blue"><span class="vertical-text white-text">VDLC</span></td>
                        </tr>
                        <?php
                        while ($construcciones = $consulta_construcciones->fetch_array()):
                        ?>
                        <!-- height: 27.5mm -->
                        <tr style="height: 9.1666mm">
                            <td><span class="horizontal-text"> <?php echo $construcciones["item"] ?></span></td>
                            <td><span class="vertical-text"> <?php echo $construcciones["TipoNivel"] ?></span></td>
                            <td><span class="vertical-text"> <?php echo $construcciones["nro_nivel"] ?></span></td>
                            <td><span class="vertical-text"> <?php echo $construcciones["seccion"] ?></span></td>
                            <td><span class="vertical-text"> <?php echo $construcciones["anno_construccion"] ?></span></td>
                            <td><span class="vertical-text"> <?php echo $construcciones["material_predominante"] ?></span></td>
                            <td><span class="vertical-text"> <?php echo $construcciones["estado_concervacion"] ?></span></td>
                            <td><span class="horizontal-text"> <?php echo $construcciones["muros"] ?></span></td>
                            <td><span class="horizontal-text"> <?php echo $construcciones["techo"] ?></span></td>
                            <td><span class="horizontal-text"> <?php echo $construcciones["pisos"] ?></span></td>
                            <td><span class="horizontal-text"> <?php echo $construcciones["puertas"] ?></span></td>
                            <td><span class="horizontal-text"> <?php echo $construcciones["revestimientos"] ?></span></td>
                            <td><span class="horizontal-text"> <?php echo $construcciones["bannos"] ?></span></td>
                            <td><span class="horizontal-text"> <?php echo $construcciones["electricos"] ?></span></td>
                            <td><span class="vertical-text"> <?php echo $construcciones["valor_unitario"] ?></span></td>
                            <td><span class="vertical-text"> <?php echo $construcciones["valor_incremento"] ?></span></td>
                            <td><span class="horizontal-text"> <?php echo $construcciones["porc_depreciacion"] ?></span></td>
                            <td><span class="horizontal-text"> <?php echo $construcciones["valor_depreciacion"] ?></span></td>
                            <td><span class="vertical-text"> <?php echo $construcciones["valor_unitario_depre"] ?></span></td>
                            <td><span class="vertical-text"> <?php echo $construcciones["valor_unitario_depre"] ?></span></td>
                            <td><span class="vertical-text"> <?php echo $construcciones["valor_area_construida"] ?></span></td>
                            <td><span class="vertical-text"> <?php echo $construcciones["valor_construccion"] ?></span></td>
                        </tr>
                        <?php
                        endwhile;
                        ?>
                        <!-- TOTALES -->
                        <tr style="height: 5mm">
                            <td colspan="16">
                            </td>
                            <td colspan="2">
                            </td>
                            <td colspan="2" style="font-size: 6pt;"> <?php echo $PR["area_construida"] ?>
                            </td>
                            <td></td>
                            <td style="font-size: 6pt;"> <?php echo $PR["valor_construccion"] ?></td>
                        </tr>
                        <!-- TOTALES -->
                    </table>
                    <!-- CONSTRUCCIONES -->

                    <!-- DETERMINACION DEL VALOR DE LAS OBRAS -->
                    <table class="comp-table" style="height: 21mm">
                        <tr style="height: 6mm">
                            <td style="width: 8mm; font-size: 3pt"></td>
                            <td style="width: 8mm; font-size: 3pt"></td>
                            <td style="width: 31mm; font-size: 3pt"></td>
                            <td style="width: 16mm; font-size: 3pt"></td>
                            <td style="width: 10mm; font-size: 3pt"></td>
                            <td style="width: 9mm; font-size: 3pt"></td>
                            <td style="width: 10mm; font-size: 3pt"></td>
                            <td style="width: 13mm; font-size: 3pt"></td>
                            <td style="width: 11mm; font-size: 3pt"></td>
                            <td style="width: 11mm; font-size: 3pt"></td>
                        </tr>
                        <!-- DATOS DE INSTALACIONES -->
                        <?php 
                        while ($instalaciones = $consulta_instalaciones->fetch_array()): ?>
                            <!-- 15mm -->
                            <tr style="height: 3mm">
                                <td> <?php echo $instalaciones["item"] ?></td>
                                <td> <?php echo $instalaciones["tipo_obra_id"] ?></td>
                                <td> <?php echo $instalaciones["descripcion"] ?></td>
                                <td> <?php echo $instalaciones["anno_instalacion"] ?></td>
                                <td> <?php echo $instalaciones["medida"] ?></td>
                                <td> <?php echo $instalaciones["unidad_medida"] ?></td>
                                <td> <?php echo $instalaciones["valor_unitario"] ?></td>
                                <td> <?php echo $instalaciones["valor_instalacion"] ?></td>
                                <td> <?php echo $instalaciones["factor_oficializacion"] ?></td>
                                <td> <?php echo $instalaciones["valor_total"] ?></td>
                            </tr>
                            <?php
                        endwhile;
                        ?>
                        <!-- DATOS DE INSTALACIONES -->
                    </table>

                    <table class="comp-table">
                        <tr>
                            <td style="width: 8mm; font-size: 3pt"></td>
                            <td style="width: 8mm; font-size: 3pt"></td>
                            <td style="width: 31mm; font-size: 3pt"></td>
                            <td style="width: 16mm; font-size: 3pt"></td>
                            <td style="width: 10mm; font-size: 3pt"></td>
                            <td style="width: 9mm; font-size: 3pt"></td>
                            <td style="width: 10mm; font-size: 3pt"></td>
                            <td style="width: 13mm; font-size: 3pt"></td>
                            <td style="width: 11mm; font-size: 3pt"></td>
                            <td style="width: 11mm; font-size: 3pt"></td>
                        </tr>
                        <!-- DATOS DE INSTALACIONES -->
                        <tr style="height: 2mm">
                            <td colspan="10"></td>
                        </tr>
                        <tr style="height: 3mm">
                            <td colspan="10"></td>
                        </tr>
                        <tr style="height: 0.2mm">
                            <td colspan="10"></td>
                        </tr>
                        <tr style="height: 3.666666666666667mm">
                            <td colspan="4"></td>
                            <td colspan="4" style="font-size: 3pt; text-align: left; padding: 1mm;"> <span class="white-text">VALOR DE LA CONSTRUCCIÓN</span></td>
                            <td colspan="2" style="font-size: 6pt"><?php echo $PR["valor_construccion"] ?></td>
                        </tr>
                        <tr style="height: 3.666666666666667mm">
                            <td colspan="4"></td>
                            <td colspan="4" style="font-size: 3pt; text-align: left; padding: 1mm"> <span class="white-text">VALOR DE LA CONSTRUCCIÓN</span></td>
                            <td colspan="2" style="font-size: 6pt"><?php echo $PR["valor_terreno"] ?></td>
                        </tr>
                        <tr style="height: 3.666666666666667mm">
                            <td colspan="4"></td>
                            <td colspan="4" style="font-size: 3pt; text-align: left; padding: 1mm"> <span class="white-text">VALOR DE LA CONSTRUCCIÓN</span></td>
                            <td colspan="2" style="font-size: 6pt"><?php echo $PR["valor_instalacion"] ?></td>
                        </tr>
                        <tr style="height: 3.3mm">
                            <td colspan="4"></td>
                            <td colspan="4" style="font-size: 3pt; text-align: left; padding: 1mm"> <span class="white-text">VALOR DE LA CONSTRUCCIÓN</span></td>
                            <td colspan="2" style="font-size: 6pt"><?php echo $PR["base_imponible"] ?></td>
                        </tr>
                    </table>
                    <!-- DETERMINACION DEL VALOR DE LAS OBRAS -->

                </div> 
<?php
            endif;
        }
    }
?>


</body>
</html>

