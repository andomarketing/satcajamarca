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
    $contribuyente_sql  = "SELECT * FROM tempo_contribuyentes_2020  WHERE persona_id = 31239";
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


            $construcciones_sql = "SELECT * FROM tempo_construcciones_2020  WHERE persona_id = '$codigo_contribuyente' ORDER BY predio_id ASC";
            //FALLO LA CONSULTA SQL
            if (!$consulta_construcciones = $mysqli->query($construcciones_sql)) {
                $data = array("error" => true, "valor" => "Error consultando contrucciones para el contributyente: " . $mysqli->error);
                echo json_encode($data);
                exit;
            }

            $data_construcciones = array();
            while ($construcciones = $consulta_construcciones->fetch_array()) {
                array_push($data_construcciones, $construcciones);
            }

            $instalaciones_sql  = "SELECT * FROM tempo_instalaciones_2020   WHERE persona_id = '$codigo_contribuyente' ORDER BY predio_id ASC";
            //FALLO LA CONSULTA SQL
            if (!$consulta_instalaciones = $mysqli->query($instalaciones_sql)) {
                $data = array("error" => true, "valor" => "Error consultando instalaciones para el contributyente: " . $mysqli->error);
                echo json_encode($data);
                exit;
            }
            
            $data_instalaciones = array();
            while ($instalaciones = $consulta_instalaciones->fetch_array()) {
                array_push($data_instalaciones, $instalaciones);
            }

            ?>
<div class="main" style="display: block; width: 100% ; height: 155mm; font-size: 6pt; font-family: Arial; font-weight: bold; page-break-after: always;">
    
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
            <td class="pre4-td pre4-td-left"><span class="white-text">AREA DEL TERRENO HA: </span> <?php echo $PR["area"] ?></td>
            <td class="pre4-td pre4-td-center"><span class="white-text">VALOR ARANCELARIO: </span> <?php echo $PR["arancel"] ?></td>
            <td class="pre4-td pre4-td-rigth"><span class="white-text">VALOR TERNARIO: </span> <?php echo $PR["valor_terreno"] ?></td>
        </tr>
    </table>
    <!-- DETERMINACION DEL VALOR DEL PRECIO -->

    <!-- CONSTRUCCIONES -->
    <table class="const-table">
        <tr style="height: 23mm">
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
        <tr style="height: 27.5mm">
        <td><span class="vertical-text"></span></td>
            <td><span class="vertical-text"></span></td>
            <td><span class="vertical-text"></span></td>
            <td><span class="vertical-text"></span></td>
            <td><span class="vertical-text"></span></td>
            <td><span class="vertical-text"></span></td>
            <td><span class="horizontal-text">MC</span></td>
            <td><span class="horizontal-text">T</span></td>
            <td><span class="horizontal-text">P</span></td>
            <td><span class="horizontal-text">PV</span></td>
            <td><span class="horizontal-text">RV</span></td>
            <td><span class="horizontal-text">B</span></td>
            <td><span class="horizontal-text">IE</span></td>
            <td><span class="vertical-text"></span></td>
            <td><span class="vertical-text"></span></td>
            <td><span class="horizontal-text">%</span></td>
            <td><span class="horizontal-text"></span></td>
            <td><span class="vertical-text"></span></td>
            <td><span class="vertical-text"></span></td>
            <td><span class="vertical-text"></span></td>
            <td><span class="vertical-text"></span></td>
        </tr>
        <!-- TOTALES -->
        <tr style="height: 5mm">
            <td colspan="15">
            </td>
            <td colspan="2">
            </td>
            <td colspan="2"> <?php echo $pr[""] ?>
            </td>
            <td></td>
            <td> <?php echo $pr[""] ?></td>
        </tr>
        <!-- TOTALES -->
    </table>
    <!-- CONSTRUCCIONES -->

    <!-- DETERMINACION DEL VALOR DE LAS OBRAS -->
    <table class="comp-table">
        <tr style="height: 6mm">
            <td style="width: 8mm; font-size: 3pt">Item</td>
            <td style="width: 8mm; font-size: 3pt">Código</td>
            <td style="width: 31mm; font-size: 3pt">TI</td>
            <td style="width: 16mm; font-size: 3pt">AI</td>
            <td style="width: 10mm; font-size: 3pt">Medida</td>
            <td style="width: 9mm; font-size: 3pt">Tipo</td>
            <td style="width: 10mm; font-size: 3pt">VU</td>
            <td style="width: 13mm; font-size: 3pt">VI</td>
            <td style="width: 11mm; font-size: 3pt">VO</td>
            <td style="width: 11mm; font-size: 3pt">Valor Total</td>
        </tr>
        <!-- DATOS DE INSTALACIONES -->
        <tr style="height: 15mm">
            <td>Item</td>
            <td>Código</td>
            <td>Tipo Instalación</td>
            <td>Año Instalación</td>
            <td>Medida</td>
            <td>Tipo</td>
            <td>Valor Unitario</td>
            <td>Valor Instalación</td>
            <td>Valor Oficialzación</td>
            <td>Valor Total</td>
        </tr>
        <!-- DATOS DE INSTALACIONES -->
        <tr style="height: 2mm">
            <td colspan="10"></td>
        </tr>
        <tr style="height: 3mm">
            <td colspan="10"></td>
        </tr>
        <tr style="height: 3.666666666666667mm">
            <td colspan="4"></td>
            <td colspan="4" style="font-size: 3pt; text-align: left; padding: 1mm">VALOR DE LA CONSTRUCCIÓN</td>
            <td colspan="2"></td>
        </tr>
        <tr style="height: 3.666666666666667mm">
            <td colspan="4"></td>
            <td colspan="4" style="font-size: 3pt; text-align: left; padding: 1mm">VALOR DE LA CONSTRUCCIÓN</td>
            <td colspan="2"></td>
        </tr>
        <tr style="height: 3.666666666666667mm">
            <td colspan="4"></td>
            <td colspan="4" style="font-size: 3pt; text-align: left; padding: 1mm">VALOR DE LA CONSTRUCCIÓN</td>
            <td colspan="2"></td>
        </tr>
        <tr style="height: 3.3mm">
            <td colspan="4"></td>
            <td colspan="4" style="font-size: 3pt; text-align: left; padding: 1mm">VALOR DE LA CONSTRUCCIÓN</td>
            <td colspan="2"></td>
        </tr>
    </table>
    <!-- DETERMINACION DEL VALOR DE LAS OBRAS -->

</div>
            <?php

        }
    }
?>


</body>
</html>

