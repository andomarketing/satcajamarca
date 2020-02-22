<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>EC</title>

        <!-- CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/estilos.css">
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

    $emision = $contribuyente["emision"];
    $persona_id = $contribuyente["persona_id"];
    $apellidos_nombres = $contribuyente["apellidos_nombres"];

    $EC_sql = "SELECT * FROM tempo_ec_2020 WHERE persona_id = '".$contribuyente["persona_id"]."'";
    //FALLO LA CONSULTA SQL
    if (!$consulta_EC = $mysqli->query($EC_sql)) {
        $data = array("error" => true, "valor" => "Error consultando el Relacionados para el contributyente: " . $mysqli->error);
        echo json_encode($data);
        exit;
    }
    $cant_ec = $consulta_EC->num_rows;
    $nro_registros_ec = 7;
    $contar_ec = 1;
    $offset_ec =  (1 - 1) * $nro_registros_ec;

    $EC_totales_sql = "SELECT * FROM tempo_ec_totales_2020 WHERE persona_id = '".$contribuyente["persona_id"]."'";
    //FALLO LA CONSULTA SQL
    if (!$consulta_totales_EC = $mysqli->query($EC_totales_sql)) {
        $data = array("error" => true, "valor" => "Error consultando el Relacionados para el contributyente: " . $mysqli->error);
        echo json_encode($data);
        exit;
    }

    $deudas_anteriores_sql  = "SELECT * FROM tempo_deudas_anteriores_2020 WHERE persona_id = '".$contribuyente["persona_id"]."'";
    //FALLO LA CONSULTA SQL
    if (!$consulta_deudas_anteriores = $mysqli->query($deudas_anteriores_sql)) {
        $data = array("error" => true, "valor" => "Error consultando el Deudas ¡1! para el contributyente: " . $mysqli->error);
        echo json_encode($data);
        exit;
    }

    if ($cant_ec > 7) {
        $n_paginas_ec = ceil($cant_ec / 7);
        while ($contar_ec <= $n_paginas_ec) {

            $EC_sql = "SELECT * FROM tempo_ec_2020 WHERE persona_id = '".$contribuyente["persona_id"]."' LIMIT $offset_ec, $nro_registros_ec";
            //FALLO LA CONSULTA SQL
            if (!$consulta_EC = $mysqli->query($EC_sql)) {
            $data = array("error" => true, "valor" => "Error consultando el Relacionados para el contributyente: " . $mysqli->error);
            echo json_encode($data);
            exit;
    }

?>

    <div style="width: 100%; height: 370mm;display:block; position:relative; font-size: 10pt; font-family: Arial; font-weight: bold; page-break-after: always;">
        <!-- DATOS DEL CONTRIBUYENTE -->
        <span style="position: absolute; top: 54.5mm; left: 194.8mm;"><?php echo $emision ?> </span>
        <span style="position: absolute; top: 69mm; left: 80mm;" ><?php echo $persona_id ?> </span>
        <span style="position: absolute; top: 81mm; left: 55mm;" ><?php echo $apellidos_nombres ?> </span>
        <!-- DATOS DEL CONTRIBUYENTE -->
   
        <!-- ESTADO DE CUENTAS EC -->
        <table style="position: absolute; top: 110mm; width: 74%; font-size: 8pt; font-weight: bold; left: 13%; text-align: center;">
            <tbody>
        <?php while ($EC = $consulta_EC->fetch_array()) { ?>
                <tr style="display: flex;">
                    <td style="width: 16.6666%; text-align: center; padding: 5px 0 !important;"> <?php echo $EC["tributo"] ?></td>
                    <td style="width: 16.6666%; text-align: center; padding: 5px 0 5px 10px !important;"> <?php echo $EC["descripcion"] ?></td>
                    <td style="width: 16.6666%; text-align: center; padding: 5px 0 5px 10px !important;"> <?php echo $EC["Cuotas"] ?></td>
                    <td style="width: 16.6666%; text-align: center; padding: 5px 0 5px 10px !important;"> <?php echo number_format($EC["insoluto"], 2, ',', '.') ?></td>
                    <td style="width: 16.6666%; text-align: center; padding: 5px 0 5px 10px !important;"> <?php echo number_format($EC["derecho_emision"], 2, ',', '.') ?></td>
                    <td style="width: 16.6666%; text-align: center; padding: 5px 0 !important;"> <?php echo number_format($EC["subTotal"], 2, ',', '.') ?></td>
                </tr>
        <?php } ?>
            </tbody>
        </table>
        <!-- ESTADO DE CUENTAS EC -->
        <?php
        $EC_totales_sql = "SELECT * FROM tempo_ec_totales_2020 WHERE persona_id = '$persona_id'";
        //FALLO LA CONSULTA SQL
        if (!$consulta_totales_EC = $mysqli->query($EC_totales_sql)) {
            $data = array("error" => true, "valor" => "Error consultando el Relacionados para el contributyente: " . $mysqli->error);
            echo json_encode($data);
            exit;
        }?>
        <!-- TOTALES EC -->
        <?php while ($TEC = $consulta_totales_EC->fetch_array()) { ?>

            <span style="position: absolute; top: 178.5mm; right: 50mm; font-size: 11pt;"><?php echo number_format($TEC["totalDeuda_actual"], 2, ',', '.') ?></span>
            <span style="position: absolute; top: 200mm; right: 60mm; font-size: 11pt;"><?php echo number_format($TEC["descuento"], 2, ',', '.') ?></span>
            <span style="position: absolute; top: 212mm; right: 70mm; font-size: 11pt;"><?php echo number_format($TEC["totalConDescuento"], 2, ',', '.') ?></span>

        <?php } ?>
        <!-- TOTALES EC -->

        
        <!-- DEUDAS ANTERIORES -->
        <table style="position: absolute; top: 256.4mm; width: 74%; font-size: 8pt; font-weight: bold; left: 13%; text-align: center;">
            <tbody>
        <?php while ($deudas = $consulta_deudas_anteriores->fetch_array()) { ?>
                 <tr style="display: flex;">
                    <td style="width: 12.5%; padding: 0.8% !important;"> <?php echo number_format($deudas["predial"], 2, ',', '.') ?> </td>
                    <td style="width: 12.5%; padding: 0.8% !important;"> <?php echo number_format($deudas["barrido"], 2, ',', '.') ?> </td>
                    <td style="width: 12.5%; padding: 0.8% !important;"> <?php echo number_format($deudas["recojo"], 2, ',', '.') ?> </td>
                    <td style="width: 12.5%; padding: 0.8% !important;"> <?php echo number_format($deudas["parques"], 2, ',', '.') ?> </td>
                    <td style="width: 12.5%; padding: 0.8% !important;"> <?php echo number_format($deudas["serenazgo"], 2, ',', '.') ?> </td>
                    <td style="width: 12.5%; padding: 0.8% !important;"> <?php echo number_format($deudas["reajuste"], 2, ',', '.') ?> </td>
                    <td style="width: 12.5%; padding: 0.8% !important;"> <?php echo number_format($deudas["interes"], 2, ',', '.') ?> </td>
                    <td style="width: 12.5%; padding: 0.8% !important;"> <?php echo number_format($deudas["emision"], 2, ',', '.') ?> </td>
                </tr>
                <span style="position: absolute; bottom: 82mm; right: 50mm; font-size: 11pt;"><?php echo number_format($deudas["TotalDeuda"], 2, ',', '.') ?> </td></span>
        <?php } ?>
            </tbody>
        </table>
        <!-- DEUDAS ANTERIORES -->

    </div>

<?php
            if ($n_paginas_ec >= 1 && $contar_ec <= $n_paginas_ec) {
                $contar_ec +=1;
                $offset_ec =  ($contar_ec - 1) * $nro_registros_ec;
            }
        }
    }else{ 
?>

<div style="width: 100%; height: 370mm;display:block; position:relative; font-size: 10pt; font-family: Arial; font-weight: bold; page-break-after: always;">
        <!-- DATOS DEL CONTRIBUYENTE -->
        <span style="position: absolute; top: 54.5mm; left: 194.8mm;"><?php echo $contribuyente["emision"]; ?> </span>
        <span style="position: absolute; top: 69mm; left: 80mm;" ><?php echo $contribuyente["persona_id"]; ?> </span>
        <span style="position: absolute; top: 81mm; left: 55mm;" ><?php echo $contribuyente["apellidos_nombres"]; ?> </span>
        <!-- DATOS DEL CONTRIBUYENTE -->
   
        <!-- ESTADO DE CUENTAS EC -->
        <table style="position: absolute; top: 110mm; width: 74%; font-size: 8pt; font-weight: bold; left: 13%; text-align: center;">
            <tbody>
        <?php while ($EC = $consulta_EC->fetch_array()) { ?>
                <tr style="display: flex;">
                    <td style="width: 16.6666%; text-align: center; padding: 5px 0 !important;"> <?php echo $EC["tributo"] ?></td>
                    <td style="width: 16.6666%; text-align: center; padding: 5px 0 5px 10px !important;"> <?php echo $EC["descripcion"] ?></td>
                    <td style="width: 16.6666%; text-align: center; padding: 5px 0 5px 10px !important;"> <?php echo $EC["Cuotas"] ?></td>
                    <td style="width: 16.6666%; text-align: center; padding: 5px 0 5px 10px !important;"> <?php echo number_format($EC["insoluto"], 2, ',', '.') ?></td>
                    <td style="width: 16.6666%; text-align: center; padding: 5px 0 5px 10px !important;"> <?php echo number_format($EC["derecho_emision"], 2, ',', '.') ?></td>
                    <td style="width: 16.6666%; text-align: center; padding: 5px 0 !important;"> <?php echo number_format($EC["subTotal"], 2, ',', '.') ?></td>
                </tr>
        <?php } ?>
            </tbody>
        </table>
        <!-- ESTADO DE CUENTAS EC -->

        <!-- TOTALES EC -->
        <?php while ($TEC = $consulta_totales_EC->fetch_array()) { ?>

            <span style="position: absolute; top: 178.5mm; right: 50mm; font-size: 11pt;"><?php echo number_format($TEC["totalDeuda_actual"], 2, ',', '.') ?></span>
            <span style="position: absolute; top: 200mm; right: 60mm; font-size: 11pt;"><?php echo number_format($TEC["descuento"], 2, ',', '.') ?></span>
            <span style="position: absolute; top: 212mm; right: 70mm; font-size: 11pt;"><?php echo number_format($TEC["totalConDescuento"], 2, ',', '.') ?></span>

        <?php } ?>
        <!-- TOTALES EC -->
    
        <!-- DEUDAS ANTERIORES -->
        <table style="position: absolute; top: 256.4mm; width: 74%; font-size: 8pt; font-weight: bold; left: 13%; text-align: center;">
            <tbody>
        <?php while ($deudas = $consulta_deudas_anteriores->fetch_array()) { ?>
                 <tr style="display: flex;">
                    <td style="width: 12.5%; padding: 0.8% !important;"> <?php echo number_format($deudas["predial"], 2, ',', '.') ?> </td>
                    <td style="width: 12.5%; padding: 0.8% !important;"> <?php echo number_format($deudas["barrido"], 2, ',', '.') ?> </td>
                    <td style="width: 12.5%; padding: 0.8% !important;"> <?php echo number_format($deudas["recojo"], 2, ',', '.') ?> </td>
                    <td style="width: 12.5%; padding: 0.8% !important;"> <?php echo number_format($deudas["parques"], 2, ',', '.') ?> </td>
                    <td style="width: 12.5%; padding: 0.8% !important;"> <?php echo number_format($deudas["serenazgo"], 2, ',', '.') ?> </td>
                    <td style="width: 12.5%; padding: 0.8% !important;"> <?php echo number_format($deudas["reajuste"], 2, ',', '.') ?> </td>
                    <td style="width: 12.5%; padding: 0.8% !important;"> <?php echo number_format($deudas["interes"], 2, ',', '.') ?> </td>
                    <td style="width: 12.5%; padding: 0.8% !important;"> <?php echo number_format($deudas["emision"], 2, ',', '.') ?> </td>
                </tr>
                <span style="position: absolute; bottom: 82mm; right: 50mm; font-size: 11pt;"><?php echo number_format($deudas["TotalDeuda"], 2, ',', '.') ?> </td></span>
        <?php } ?>
            </tbody>
        </table>
        <!-- DEUDAS ANTERIORES -->

    </div>

<?php }
} ?>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="/js/funciones.js"></script>
    <style>
        html {
            margin: 0 auto;        
        }
        body {
            width: 100% ; height: 370mm;
            margin: 0 auto;
        }
        hr {
            page-break-after: always;
            border: 0;
            margin: 0;
            padding: 0;
        }
        @media print{
            html {
                margin: 0 auto;
            }
            body {
                width: 100% ; height: 370mm;
                margin: 0 auto;
            }
        }
    </style>
</body>
</html>