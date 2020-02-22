<?php

require "../vendor/autoload.php";

$generator = new Picqer\Barcode\BarcodeGeneratorHTML();


function render($template, $param){
    ob_start();
    extract($param, EXTR_OVERWRITE);
    include($template);
    return ob_get_clean();
}

define("CARGO_TEMPLATE", "template-cargo.php");

$offset = $_GET["pg"];

//CONEXION BASE DE DATOS
include "db.php";

//EXISTE UN ERROR DE CONEXION
if ($mysqli->connect_errno) {
    $data = array("error" => true, "valor" => "Error: " . $mysqli->connect_error);
    echo json_encode($data);
    exit;
}

//CONSULTAS SQL
$contribuyenteSql  = "SELECT * FROM tempo_contribuyentes_2020 ORDER BY persona_id LIMIT $offset, 10";

//FALLO LA CONSULTA SQL
if (!$consultaContribuyente = $mysqli->query($contribuyenteSql)) {
    $data = array("error" => true, "valor" => "Error consultando el contributyente: " . $mysqli->error);
    echo json_encode($data);
    exit;
}

//NO SE ENCONTRARON REGISTROS
if ($consultaContribuyente->num_rows === 0) {
    $data = array("error" => true, "valor" => "No se han encontrado registros de ese contribuyente.");
    echo json_encode($data);
    exit;
}

//GUARDAR CONSULTA EN ARRAY
while ($contribuyente = $consultaContribuyente->fetch_array()): 
    $params = [
        "declaracionJurada" => $contribuyente["NroDeclaracionJurada"],
        "codBarra" => $generator->getBarcode( $contribuyente["NroDeclaracionJurada"] , $generator::TYPE_CODE_128),
        "emision" => $contribuyente["emision"],
        "codigoContribuyente" => $contribuyente["persona_id"],
        "dni" => $contribuyente["nro_docu_identidad"],
        "nombresYApellidos" => $contribuyente["apellidos_nombres"],
        "tipoContribuyente" => $contribuyente["tipo_Contribuyente"],
        "domicilioFiscal" => $contribuyente["domicilio_completo"],
        "referencia" => $contribuyente["referencia"],
        "mzUbicacion" => $contribuyente["ManCatastral"],
    ];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .main {
            margin-top: 18mm;
            margin-left: 9mm;
            font-size: 8pt;
            max-width: 130mm;
        }
        table { 
            width: 100%;
            border: 0.05mm solid black;
        }
        .white-text {
            font-weight: 100;
        }
        .pre1-table {
            padding-top: 1mm;
            padding-left: 0.5mm;
            font-size: 8pt;
            font-weight: bold;
            height: 9mm;
            margin-bottom: 1.5mm;
        }
        .pre1-td-left {
            width: 87mm;
        }
        .pre2-table {
            padding-top: 0mm;
            padding-left: 0mm;
            font-size: 8pt;
            font-weight: bold;
            min-height: 13mm;
            margin-bottom: -2.5mm;
        }
        .pre2-td-left {
            width: 87mm;
        }
        .pre3-table {
            padding-top: 0mm;
            padding-left: 0mm;
            font-size: 8pt;
            font-weight: bold;
            height: 4mm;
            margin-bottom: 3mm;
        }
        .pre3-td-left {
            width: 87mm;
        }
        .white-text {
            color: transparent;
        }

        @media print {
            table {
                border: none;
            }
        }
    </style>
</head>
<body>
<?php
  echo render(CARGO_TEMPLATE, $params);
?>
</body>
</html>
<?php 
endwhile;
