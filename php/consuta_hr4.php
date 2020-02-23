<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HR</title>

        <!-- CSS -->
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/estilos.css">
        <style>
        table td{
            padding-top: 2px !important;
            padding-bottom: 2px !important;
        }

        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            font-size: 7pt; font-family: Arial; font-weight: bold;
        }
        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }
        .page {
            position: relative !important;
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: 10mm auto;
            font-size: 7pt; font-family: Arial; font-weight: bold;            
        }
        
        @page {
            size: A4;
            margin: 0;
        }
        @media print {
            html, body {
                width: 210mm;
                height: 297mm;        
            }
            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }
    </style>
    </head>
    <body>

<?php

$pagina_contri = $_GET["pg"];

//CONEXION BASE DE DATOS
include "db.php";

//EXISTE UN ERROR DE CONEXION
if ($mysqli->connect_errno) {
    $data = array("error" => true, "valor" => "Error: " . $mysqli->connect_error);
    echo json_encode($data);
    exit;
}

//CONSULTAS SQL
$contribuyente_sql  = "SELECT * FROM tempo_contribuyentes_2020 ORDER BY persona_id LIMIT $pagina_contri, 200";

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
    $nro_registros_hr = 11;
    $conta_hr = 1;
    $offset_hr =  (1 - 1) * $nro_registros_hr;

    $nro_registros_relacionados = 5;
    $conta_relacionados = 1;
    $offset_relacionados =  (1 - 1) * $nro_registros_relacionados;

    if($cant_hr > 11 || $cant_realacionados > 5){

        
        $n_paginas_hr = ceil($cant_hr / 11);

        
        $n_paginas_relacionados = ceil($cant_realacionados / 5);

        while ( $n_paginas_hr >= $conta_hr || $n_paginas_relacionados >= $conta_relacionados) {

            

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

            <div class="page">

            <span style="position: absolute; top: 43mm; left: 118mm;"> <?php echo $contribuyente["NroDeclaracionJurada"]; ?> </span>
            <span style="position: absolute; top: 55.2mm; left: 155.2mm;"><?php echo $contribuyente["emision"]; ?> </span>
            <span style="position: absolute; top: 66mm; left: 136.7mm;" ><?php echo $contribuyente["nro_docu_identidad"]; ?> </span>
            <span style="position: absolute; top: 66mm; left: 65mm;" ><?php echo $contribuyente["persona_id"]; ?> </span>
            <span style="position: absolute; top: 71.5mm; left: 65mm;" ><?php echo $contribuyente["apellidos_nombres"]; ?> </span>
            <span style="position: absolute; top: 77.5mm; left: 65mm; width: 40%; font-size: 6pt; line-height: 6pt;" ><?php echo strtoupper($contribuyente["domicilio_completo"]); ?> </span>

            <table style="position: absolute; top: 92mm; width: 70.5%; font-size: 6pt; font-weight: bold;left: 30.5mm; text-align: center;">
                    <tbody>
    <?php
                while ($xrelacionado = $rela_paginas->fetch_array()) {
                    ?>
                        <tr style="display: flex;">
                            <td style="width: 6%;"><?php echo $relacionados["item"] ?></td>
                            <td style="width: 43%; text-align: left; padding-left: 0.5%;"><?php echo $relacionados["relacionado"] ?> </td>
                            <td style="width: 29.5%;"><?php echo $relacionados["Tporelacion"] ?> </td>
                            <td style="width: 21.5%;"><?php echo $relacionados["NroDocumento"] ?> </td>
                        </tr>
                    <?php
                }
    ?>
                     </tbody>
                </table>

            <table style="position: absolute; top: 129mm; width: 74%; font-size: 6pt; font-weight: bold;left: 28mm; text-align: center;">
                    <tbody>
    <?php
                while ($xHR = $hr_paginas->fetch_array()) {
                    ?>
                        <tr style="display: flex;">
                            <td style="width: 10%;"><?php echo $HR["item"] ?></td>
                            <td style="width: 38%; text-align: left; padding-left: 0.5%;"><?php echo $HR["UbicacionPredio"] ?> </td>
                            <td style="width: 12%;"><?php echo $HR["fecha_adquisicion"] ?> </td>
                            <td style="width: 9%;"><?php echo $HR["valor_Predio"] ?> </td>
                            <td style="width: 9%;"><?php echo $HR["porc_participacion"] ?> </td>
                            <td style="width: 10%;"><?php echo $HR["monto_inafecto"] ?> </td>
                            <td style="width: 10%;"><?php echo $HR["valor_afecto"] ?> </td>
                        </tr>
                    <?php
                }
    ?>
                    </tbody>
                </table>
    <?php
                while ($HR = $consulta_pie_hr->fetch_array()) {
                    ?>
                        <div style="position: relative; top: 203mm; font-size: 7pt;">
                        <span style="position: relative; left: 38mm; bottom:5px;"><?php echo $HR["cantidadPredios"];?></span>
                        <span style="position: relative; left: 69mm; bottom:5px;"><?php echo $HR["PrediosAfectos"];?></span>
                        <span style="position: relative; left: 101mm; bottom:5px;"><?php echo number_format($HR["valor_TotalAfecto"], 2, ',', '.');?></span>
                        <span style="position: relative; left: 130mm; bottom:5px;"><?php echo number_format($HR["impuestoPredial"], 2, ',', '.');?></span>
                    </div>
                    <?php
                }
    ?>
            </div>
    
           
    <?php

            if ($n_paginas_hr >= 1 && $conta_hr <= $n_paginas_hr) {
                $conta_hr +=1;
                $offset_hr =  ($conta_hr - 1) * $nro_registros_hr;
            }

            if ($n_paginas_relacionados >= 1 && $conta_relacionados <= $n_paginas_relacionados) {
                $conta_relacionados +=1;
                $offset_relacionados =  ($conta_relacionados - 1) * $nro_registros_relacionados;
            }

        }

    }else{

        ?>

            <div class="page">

            <span style="position: absolute; top: 43mm; left: 118mm;"> <?php echo $contribuyente["NroDeclaracionJurada"]; ?> </span>
            <span style="position: absolute; top: 55.2mm; left: 155.2mm;"><?php echo $contribuyente["emision"]; ?> </span>
            <span style="position: absolute; top: 66mm; left: 136.7mm;" ><?php echo $contribuyente["nro_docu_identidad"]; ?> </span>
            <span style="position: absolute; top: 66mm; left: 65mm;" ><?php echo $contribuyente["persona_id"]; ?> </span>
            <span style="position: absolute; top: 71.5mm; left: 65mm;" ><?php echo $contribuyente["apellidos_nombres"]; ?> </span>
            <span style="position: absolute; top: 77.5mm; left: 65mm; width: 40%; font-size: 6pt; line-height: 6pt;" ><?php echo strtoupper($contribuyente["domicilio_completo"]); ?> </span>

            <table style="position: absolute; top: 92mm; width: 70.5%; font-size: 6pt; font-weight: bold;left: 30.5mm; text-align: center;">
                <tbody>
<?php
            while ($relacionados = $consulta_relacionados->fetch_array()) {
                ?>
                    <tr style="display: flex;">
                        <td style="width: 6%;"><?php echo $relacionados["item"] ?></td>
                        <td style="width: 43%; text-align: left; padding-left: 0.5%;"><?php echo $relacionados["relacionado"] ?> </td>
                        <td style="width: 29.5%;"><?php echo $relacionados["Tporelacion"] ?> </td>
                        <td style="width: 21.5%;"><?php echo $relacionados["NroDocumento"] ?> </td>
                    </tr>
                <?php
            }
?>
                </tbody>
            </table>

            <table style="position: absolute; top: 129mm; width: 74%; font-size: 6pt; font-weight: bold;left: 28mm; text-align: center;">
                <tbody>
<?php
            while ($HR = $consulta_hr->fetch_array()) {
                ?>
                    <tr style="display: flex;">
                        <td style="width: 10%;"><?php echo $HR["item"] ?></td>
                        <td style="width: 38%; text-align: left; padding-left: 0.5%;"><?php echo $HR["UbicacionPredio"] ?> </td>
                        <td style="width: 12%;"><?php echo $HR["fecha_adquisicion"] ?> </td>
                        <td style="width: 9%;"><?php echo $HR["valor_Predio"] ?> </td>
                        <td style="width: 9%;"><?php echo $HR["porc_participacion"] ?> </td>
                        <td style="width: 10%;"><?php echo $HR["monto_inafecto"] ?> </td>
                        <td style="width: 10%;"><?php echo $HR["valor_afecto"] ?> </td>
                    </tr>
                <?php
            }
?>
                </tbody>
            </table>
<?php
            while ($HR = $consulta_pie_hr->fetch_array()) {
                ?>
                    <div style="position: relative; top: 203mm; font-size: 7pt;">
                        <span style="position: relative; left: 38mm; bottom:5px;"><?php echo $HR["cantidadPredios"];?></span>
                        <span style="position: relative; left: 69mm; bottom:5px;"><?php echo $HR["PrediosAfectos"];?></span>
                        <span style="position: relative; left: 101mm; bottom:5px;"><?php echo number_format($HR["valor_TotalAfecto"], 2, ',', '.');?></span>
                        <span style="position: relative; left: 130mm; bottom:5px;"><?php echo number_format($HR["impuestoPredial"], 2, ',', '.');?></span>
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
</body>
</html>