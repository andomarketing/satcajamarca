<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HR</title>

        <!-- CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/estilos.css">
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
$contribuyente_sql  = "SELECT * FROM tempo_contribuyentes_2020  LIMIT 5";

//FALLO LA CONSULTA SQL
if (!$consulta_contribuyente = $mysqli->query($contribuyente_sql)) {
    $data = array("error" => true, "valor" => "Error consultando el contributyente: " . $mysqli->error);
    echo json_encode($data);
    exit;
}

//NO SE ENCONTRARON REGISTROS
if ($consulta_contribuyente->num_rows === 0) {
    $data = array("error" => true, "valor" => "No se han encontrado registros de ese contribuyente.");
    echo json_encode($data);
    exit;
}


//GUARDAR CONSULTA EN ARRAY
while ($contribuyente = $consulta_contribuyente->fetch_array()) {

    $relacionados_sql   = "SELECT * FROM tempo_relacionados_2020    WHERE persona_id = '".$contribuyente["persona_id"]."'";
    //FALLO LA CONSULTA SQL
    if (!$consulta_relacionados = $mysqli->query($relacionados_sql)) {
        $data = array("error" => true, "valor" => "Error consultando el Relacionados para el contributyente: " . $mysqli->error);
        echo json_encode($data);
        exit;
    }
    $cant_realacionados = $consulta_relacionados->num_rows;

    $hr_sql = "SELECT * FROM tempo_hr_2020 WHERE persona_id = '".$contribuyente["persona_id"]."'";
    //FALLO LA CONSULTA SQL
    if (!$consulta_hr = $mysqli->query($hr_sql)) {
        $data = array("error" => true, "valor" => "Error consultando el HR contributyente: " . $mysqli->error);
        echo json_encode($data);
        exit;
    }
    $cant_hr = $consulta_hr->num_rows;

    $hr_pie_sql = "SELECT * FROM tempo_hr_pie_2020 WHERE persona_id = '".$contribuyente["persona_id"]."'";
    //FALLO LA CONSULTA SQL
    if (!$consulta_pie_hr = $mysqli->query($hr_pie_sql)) {
        $data = array("error" => true, "valor" => "Error consultando el Relacionados para el contributyente: " . $mysqli->error);
        echo json_encode($data);
        exit;
    }

    $conta_hr = 0;
    $conta_relacionados = 0;

    if($cant_hr > 6 || $cant_realacionados > 5){

        $nro_registros_hr = 6;
        $n_paginas_hr = ceil($cant_hr / 6);

        $nro_registros_relacionados = 5;
        $n_paginas_relacionados = ceil($cant_realacionados / 5);

        while ( $n_paginas_hr >= $conta_hr || $n_paginas_relacionados >= $conta_relacionados) {

            if ($n_paginas_hr >= 1 && $conta_hr <= $n_paginas_hr) {
                $conta_hr +=1;
                $offset_hr =  ($conta_hr - 1) * $nro_registros_hr;
            }else{
                $conta_hr = 1;
                $offset_hr =  ($conta_hr - 1) * $nro_registros_hr;
            }

            if ($n_paginas_relacionados >= 1 && $conta_relacionados <= $n_paginas_relacionados) {
                $conta_relacionados +=1;
                $offset_relacionados =  ($conta_relacionados - 1) * $nro_registros_relacionados;
            }else{
                $conta_relacionados = 1;
                $offset_relacionados =  ($conta_relacionados - 1) * $nro_registros_relacionados;
            }            

            $relacionados_fraccionado = "SELECT * FROM tempo_relacionados_2020 WHERE persona_id = '".$contribuyente["persona_id"]."' LIMIT $offset_relacionados, $nro_registros_relacionados";
            //FALLO LA CONSULTA SQL
            if (!$rela_paginas = $mysqli->query($relacionados_fraccionado)) {
                $data = array("error" => true, "valor" => "Error consultando el Relacionados para el contributyente: " . $mysqli->error);
                echo json_encode($data);
                exit;
            }

            $HR_fraccioado = "SELECT * FROM tempo_hr_2020 WHERE persona_id = '".$contribuyente["persona_id"]."' LIMIT $offset_hr, $nro_registros_hr";
            //FALLO LA CONSULTA SQLnro_registros_hr
            if (!$hr_paginas = $mysqli->query($HR_fraccioado)) {
                $data = array("error" => true, "valor" => "Error consultando el HR contributyente: " . $mysqli->error);
                echo json_encode($data);
                exit;
            }
            ?>

            <div style="width:221mm; height: 297mm; position:relative; font-size: 9pt; font-family: Arial; font-weight: bold; page-break-after: always; background: url('../img/CuponeraFINAL5 CONTORNOS-04.png'); background-size: cover;">
                <span style="position: absolute; top: 54.5mm; left: 148mm;"> <?php echo $contribuyente["NroDeclaracionJurada"]; ?> </span>
                <span style="position: absolute; top: 69.8mm; left: 196mm;"><?php echo $contribuyente["emision"]; ?> </span>
                <span style="position: absolute; top: 82.8mm; left: 84mm;" ><?php echo $contribuyente["persona_id"]; ?> </span>
                <span style="position: absolute; top: 90.6mm; left: 60mm;" ><?php echo $contribuyente["apellidos_nombres"]; ?> </span>
                <span style="position: absolute; top: 82.8mm; left: 170mm;" ><?php echo $contribuyente["nro_docu_identidad"]; ?> </span>
                <span style="position: absolute; top: 99mm; left: 71mm; width: 67%; font-size: 8pt; line-height: 8pt;" ><?php echo $contribuyente["domicilio_completo"]; ?> </span>
    
                <table style="position: absolute; top: 117mm; width: 86%; font-size: 8pt; font-weight: bold;left: 36mm; text-align: center;">
                    <tbody>
    <?php
                while ($xrelacionado = $rela_paginas->fetch_array()) {
                    ?>
                        <tr style="display: flex;">
                            <td style="width: 10%;"><?php echo $xrelacionado["item"] ?></td>
                            <td style="width: 40%; text-align: left; padding-left: 0.5%;"><?php echo $xrelacionado["relacionado"] ?> </td>
                            <td style="width: 25%;"><?php echo $xrelacionado["Tporelacion"] ?> </td>
                            <td style="width: 25%;"><?php echo $xrelacionado["NroDocumento"] ?> </td>
                        </tr>
                    <?php
                }
    ?>
                    </tbody>
                </table>
    
                <table style="position: absolute; top: 163mm; width: 86%; font-size: 8pt; font-weight: bold;left: 36mm; text-align: center;">
                    <tbody>
    <?php
                while ($xHR = $hr_paginas->fetch_array()) {
                    ?>
                        <tr style="display: flex;">
                            <td style="width: 10%;"><?php echo $xHR["item"] ?></td>
                            <td style="width: 36%; text-align: left; padding-left: 0.5%;"><?php echo $xHR["UbicacionPredio"] ?> </td>
                            <td style="width: 11%;"><?php echo $xHR["fecha_adquisicion"] ?> </td>
                            <td style="width: 11%;"><?php echo $xHR["valor_Predio"] ?> </td>
                            <td style="width: 11%;"><?php echo $xHR["porc_participacion"] ?> </td>
                            <td style="width: 11%;"><?php echo $xHR["monto_inafecto"] ?> </td>
                            <td style="width: 12%;"><?php echo $xHR["valor_afecto"] ?> </td>
                        </tr>
                    <?php
                }
    ?>
                    </tbody>
                </table>
    <?php
                while ($HR = $consulta_pie_hr->fetch_array()) {
                    ?>
                        <div style="position: relative; top: 276mm; font-size: 10pt;">
                            <span style="position: absolute; left: 68mm;"><?php echo $HR["cantidadPredios"];?></span>
                            <span style="position: absolute; left: 108mm;"><?php echo $HR["PrediosAfectos"];?></span>
                            <span style="position: absolute; left: 155mm;"><?php echo number_format($HR["valor_TotalAfecto"], 2, ',', ' ');?></span>
                            <span style="position: absolute; left: 203mm;"><?php echo number_format($HR["impuestoPredial"], 2, ',', ' ');?></span>
                        </div>
                    <?php
                }
    ?>
            </div>
    
           
    <?php

        }

    }else{

        ?>

            <div style="width:221mm; height: 297mm; position:relative; font-size: 9pt; font-family: Arial; font-weight: bold; page-break-after: always; background: url('../img/CuponeraFINAL5 CONTORNOS-04.png'); background-size: cover;">
            <span style="position: absolute; top: 54.5mm; left: 148mm;"> <?php echo $contribuyente["NroDeclaracionJurada"]; ?> </span>
            <span style="position: absolute; top: 69.8mm; left: 196mm;"><?php echo $contribuyente["emision"]; ?> </span>
            <span style="position: absolute; top: 82.8mm; left: 84mm;" ><?php echo $contribuyente["persona_id"]; ?> </span>
            <span style="position: absolute; top: 90.6mm; left: 60mm;" ><?php echo $contribuyente["apellidos_nombres"]; ?> </span>
            <span style="position: absolute; top: 82.8mm; left: 170mm;" ><?php echo $contribuyente["nro_docu_identidad"]; ?> </span>
            <span style="position: absolute; top: 99mm; left: 71mm; width: 67%; font-size: 8pt; line-height: 8pt;" ><?php echo $contribuyente["domicilio_completo"]; ?> </span>

            <table style="position: absolute; top: 117mm; width: 86%; font-size: 8pt; font-weight: bold;left: 36mm; text-align: center;">
                <tbody>
<?php
            while ($relacionados = $consulta_relacionados->fetch_array()) {
                ?>
                    <tr style="display: flex;">
                        <td style="width: 10%;"><?php echo $relacionados["item"] ?></td>
                        <td style="width: 40%; text-align: left; padding-left: 0.5%;"><?php echo $relacionados["relacionado"] ?> </td>
                        <td style="width: 25%;"><?php echo $relacionados["Tporelacion"] ?> </td>
                        <td style="width: 25%;"><?php echo $relacionados["NroDocumento"] ?> </td>
                    </tr>
                <?php
            }
?>
                </tbody>
            </table>

            <table style="position: absolute; top: 163mm; width: 86%; font-size: 8pt; font-weight: bold;left: 36mm; text-align: center;">
                <tbody>
<?php
            while ($HR = $consulta_hr->fetch_array()) {
                ?>
                    <tr style="display: flex;">
                        <td style="width: 10%;"><?php echo $HR["item"] ?></td>
                        <td style="width: 36%; text-align: left; padding-left: 0.5%;"><?php echo $HR["UbicacionPredio"] ?> </td>
                        <td style="width: 11%;"><?php echo $HR["fecha_adquisicion"] ?> </td>
                        <td style="width: 11%;"><?php echo $HR["valor_Predio"] ?> </td>
                        <td style="width: 11%;"><?php echo $HR["porc_participacion"] ?> </td>
                        <td style="width: 11%;"><?php echo $HR["monto_inafecto"] ?> </td>
                        <td style="width: 12%;"><?php echo $HR["valor_afecto"] ?> </td>
                    </tr>
                <?php
            }
?>
                </tbody>
            </table>
<?php
            while ($HR = $consulta_pie_hr->fetch_array()) {
                ?>
                    <div style="position: relative; top: 276mm; font-size: 10pt;">
                        <span style="position: absolute; left: 68mm;"><?php echo $HR["cantidadPredios"];?></span>
                        <span style="position: absolute; left: 108mm;"><?php echo $HR["PrediosAfectos"];?></span>
                        <span style="position: absolute; left: 155mm;"><?php echo number_format($HR["valor_TotalAfecto"], 2, ',', ' ');?></span>
                        <span style="position: absolute; left: 203mm;"><?php echo number_format($HR["impuestoPredial"], 2, ',', ' ');?></span>
                    </div>
                <?php
            }
?>
        </div>

       
<?php
    }
  
}
?>
    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="/js/funciones.js"></script>
    <style>
        html {
            margin: 0;
        }
        body {
            font-family: "Times New Roman", serif;
            margin: 0;
        }
        hr {
            page-break-after: always;
            border: 0;
            margin: 0;
            padding: 0;
        }
        table td{
            padding-top: 2px !important;
            padding-bottom: 2px !important;
        }
    </style>
</body>
</html>