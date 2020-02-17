<?php 

if (isset($_POST["codigo"])) {
    if ($_POST["codigo"] != "" || $_POST["codigo"] != null) {
        $codigo = $_POST["codigo"];
    }else{
        $codigo = "";
    }
}else{
    $codigo = "";
}

//SE ESTABLECE COMO JSON EL HEADER
header('Content-Type: application/json');
$data = array();

//CONEXION BASE DE DATOS
include "../db.php";

//EXISTE UN ERROR DE CONEXION
if ($mysqli->connect_errno) {
    $data = array("error"=>true, "valor"=>"Error: " . $mysqli->connect_error);
    echo json_encode($data);
    exit;
}

//CONSULTAS SQL
$contribuyente_sql  = "SELECT * FROM tempo_contribuyentes_2020  WHERE persona_id = '$codigo'";
$hr_sql             = "SELECT * FROM tempo_hr_2020              WHERE persona_id = '$codigo'";
$hr_pie_sql         = "SELECT * FROM tempo_hr_pie_2020          WHERE persona_id = '$codigo'";
$relacionados_sql   = "SELECT * FROM tempo_relacionados_2020    WHERE persona_id = '$codigo'";

//FALLO LA CONSULTA SQL
if (!$consulta_contribuyente = $mysqli->query($contribuyente_sql)) {
    $data = array("error"=>true, "valor"=>"Error consultando el contributyente: " . $mysqli->error);
    echo json_encode($data);
    exit;
}

//NO SE ENCONTRARON REGISTROS
if ($consulta_contribuyente->num_rows === 0) {
    $data = array("error"=>true, "valor"=>"No se han encontrado registros de ese contribuyente.");
    echo json_encode($data);
    exit;
}

//FALLO LA CONSULTA SQL
if (!$consulta_hr = $mysqli->query($hr_sql)) {
    $data = array("error"=>true, "valor"=>"Error consultando el HR contributyente: " . $mysqli->error);
    echo json_encode($data);
    exit;
}

//FALLO LA CONSULTA SQL
if (!$consulta_relacionados = $mysqli->query($relacionados_sql)) {
    $data = array("error"=>true, "valor"=>"Error consultando el Relacionados para el contributyente: " . $mysqli->error);
    echo json_encode($data);
    exit;
}


//GUARDAR CONSULTA EN ARRAY
while ($contribuyente = $consulta_contribuyente->fetch_array()) {

    $temp = array(  
                    "error"                     => false,
                    "fechaEmision_completa"     => date_format(date_create($contribuyente["fechaEmision_completa"]), 'd-m-Y'),
                    "emision"                   => $contribuyente["emision"],
                    "NroDeclaracionJurada"      => $contribuyente["NroDeclaracionJurada"],
                    "persona_id"                => $contribuyente["persona_id"],
                    "apellidos_nombres"         => $contribuyente["apellidos_nombres"],
                    "tipo_Contribuyente"        => $contribuyente["tipo_Contribuyente"],
                    "tipo_documento_identidad"  => $contribuyente["tipo_documento_identidad"],
                    "nro_docu_identidad"        => $contribuyente["nro_docu_identidad"],
                    "domicilio_completo"        => $contribuyente["domicilio_completo"],
                    "referencia"                => $contribuyente["referencia"],
                    "ManCatastral"              => $contribuyente["ManCatastral"],
                    "HR"                        => $consulta_hr->fetch_array(),
                    "relacionados"              => $consulta_relacionados->fetch_array()
                );

    array_push($data, $temp);
}

echo json_encode($data);

// El script automáticamente liberará el resultado y cerrará la conexión
// a MySQL cuando finalice, aunque aquí lo vamos a hacer nostros mismos
//$resultado->free();
$mysqli->close();
