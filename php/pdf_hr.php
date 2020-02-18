<?php

// reference the Dompdf namespace
require_once "dompdf/autoload.inc.php";
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

//SE ESTABLECE COMO JSON EL HEADER
header('Content-Type: application/json');
$data = array();

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

$pdf_hr = "";

//GUARDAR CONSULTA EN ARRAY
while ($contribuyente = $consulta_contribuyente->fetch_array()) {

    $hr_sql     = "SELECT * FROM tempo_hr_2020              WHERE persona_id = '".$contribuyente["persona_id"]."'";
    //FALLO LA CONSULTA SQL
    if (!$consulta_hr = $mysqli->query($hr_sql)) {
        $data = array("error" => true, "valor" => "Error consultando el HR contributyente: " . $mysqli->error);
        echo json_encode($data);
        exit;
    }

    $hr_pie_sql = "SELECT * FROM tempo_hr_pie_2020          WHERE persona_id = '".$contribuyente["persona_id"]."'";
    //FALLO LA CONSULTA SQL
    if (!$consulta_pie_hr = $mysqli->query($hr_pie_sql)) {
        $data = array("error" => true, "valor" => "Error consultando el Relacionados para el contributyente: " . $mysqli->error);
        echo json_encode($data);
        exit;
    }

    $relacionados_sql   = "SELECT * FROM tempo_relacionados_2020    WHERE persona_id = '".$contribuyente["persona_id"]."'";
    //FALLO LA CONSULTA SQL
    if (!$consulta_relacionados = $mysqli->query($relacionados_sql)) {
        $data = array("error" => true, "valor" => "Error consultando el Relacionados para el contributyente: " . $mysqli->error);
        echo json_encode($data);
        exit;
    }


    $data_HR = array();
    while ($HR = $consulta_hr->fetch_array()) {
        array_push($data_HR, $HR);
    }
    $pie_HR = array();
    while ($HR = $consulta_pie_hr->fetch_array()) {
        array_push($pie_HR, $HR);
    }
    $data_relacionados = array();
    while ($relacionados = $consulta_relacionados->fetch_array()) {
        array_push($data_relacionados, $relacionados);
    }

    $pdf_hr .=  '<div style="position:relative;font-size: 10pt; font-family: Arial; font-weight: bold;">
                    <span style="position: absolute; top: 9%; left: 58.5%;">'.$contribuyente["NroDeclaracionJurada"].'</span>
                    <span style="position: absolute; top: 13%; right: 14%; font-size: 9pt;">'.$contribuyente["emision"].'</span>
                    <span style="position: absolute; top: 17.5%; left: 30%; font-size: 7pt;" >'.$contribuyente["persona_id"].'</span>
                    <span style="position: absolute; top: 20%; left: 18%; font-size: 7pt;" >'.$contribuyente["apellidos_nombres"].'</span>
                    <span style="position: absolute; right: 25.5%; top: 17.5%; font-size: 7pt;" >'.$contribuyente["nro_docu_identidad"].'</span>
                    <span style="position: absolute; top: 22%; left: 24%; width: 67%; font-size: 7pt; line-height: 7pt;" >'.$contribuyente["domicilio_completo"].'</span>    
                </div> <div style="page-break-before: always;"> </div>';
}

$dompdf->loadHtml($pdf_hr);
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('B5', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();