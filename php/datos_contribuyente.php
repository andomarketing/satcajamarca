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
include "db.php";

//EXISTE UN ERROR DE CONEXION
if ($mysqli->connect_errno) {
    $data = array("error"=>true, "valor"=>"Error: " . $mysqli->connect_error);
    echo json_encode($data);
    exit;
}

//CONSULTAS SQL
$contribuyente_sql  = "SELECT * FROM tempo_contribuyentes_2020  WHERE persona_id = '$codigo'";
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

$hr_sql             = "SELECT * FROM tempo_hr_2020              WHERE persona_id = '$codigo'";
//FALLO LA CONSULTA SQL
if (!$consulta_hr = $mysqli->query($hr_sql)) {
    $data = array("error"=>true, "valor"=>"Error consultando el HR contributyente: " . $mysqli->error);
    echo json_encode($data);
    exit;
}

$hr_pie_sql         = "SELECT * FROM tempo_hr_pie_2020          WHERE persona_id = '$codigo'";
//FALLO LA CONSULTA SQL
if (!$consulta_pie_hr = $mysqli->query($hr_pie_sql)) {
    $data = array("error"=>true, "valor"=>"Error consultando el Relacionados para el contributyente: " . $mysqli->error);
    echo json_encode($data);
    exit;
}

$relacionados_sql   = "SELECT * FROM tempo_relacionados_2020    WHERE persona_id = '$codigo'";
//FALLO LA CONSULTA SQL
if (!$consulta_relacionados = $mysqli->query($relacionados_sql)) {
    $data = array("error"=>true, "valor"=>"Error consultando el Relacionados para el contributyente: " . $mysqli->error);
    echo json_encode($data);
    exit;
}

$PU_sql             = "SELECT * FROM tempo_pu_2020              WHERE persona_id = '$codigo' ORDER BY predio_id ASC";
//FALLO LA CONSULTA SQL
if (!$consulta_PU = $mysqli->query($PU_sql)) {
    $data = array("error"=>true, "valor"=>"Error consultando el PU para el contributyente: " . $mysqli->error);
    echo json_encode($data);
    exit;
}

$construcciones_sql = "SELECT * FROM tempo_construcciones_2020  WHERE persona_id = '$codigo' ORDER BY predio_id ASC";
//FALLO LA CONSULTA SQL
if (!$consulta_construcciones = $mysqli->query($construcciones_sql)) {
    $data = array("error"=>true, "valor"=>"Error consultando contrucciones para el contributyente: " . $mysqli->error);
    echo json_encode($data);
    exit;
}

$instalaciones_sql  = "SELECT * FROM tempo_instalaciones_2020   WHERE persona_id = '$codigo' ORDER BY predio_id ASC";
//FALLO LA CONSULTA SQL
if (!$consulta_instalaciones = $mysqli->query($instalaciones_sql)) {
    $data = array("error"=>true, "valor"=>"Error consultando instalaciones para el contributyente: " . $mysqli->error);
    echo json_encode($data);
    exit;
}

$PR_sql             = "SELECT * FROM tempo_pr_2020              WHERE persona_id = '$codigo' ORDER BY predio_id ASC";
//FALLO LA CONSULTA SQL
if (!$consulta_PR = $mysqli->query($PR_sql)) {
    $data = array("error"=>true, "valor"=>"Error consultando el Relacionados para el contributyente: " . $mysqli->error);
    echo json_encode($data);
    exit;
}

$HLP_sql            = "SELECT * FROM tempo_hlp_cabecera_2020    WHERE persona_id = '$codigo'";
//FALLO LA CONSULTA SQL
if (!$consulta_HLP = $mysqli->query($HLP_sql)) {
    $data = array("error"=>true, "valor"=>"Error consultando el Relacionados para el contributyente: " . $mysqli->error);
    echo json_encode($data);
    exit;
}

$HLP_tramos_sql     = "SELECT * FROM tempo_hlp_tramos_2020      WHERE persona_id = '$codigo'";
//FALLO LA CONSULTA SQL
if (!$consulta_tramos = $mysqli->query($HLP_tramos_sql)) {
    $data = array("error"=>true, "valor"=>"Error consultando el Relacionados para el contributyente: " . $mysqli->error);
    echo json_encode($data);
    exit;
}

$HLP_cronograma_sql = "SELECT * FROM tempo_hlp_cronograma_2020  WHERE persona_id = '$codigo'";
//FALLO LA CONSULTA SQL
if (!$consulta_cronograma = $mysqli->query($HLP_cronograma_sql)) {
    $data = array("error"=>true, "valor"=>"Error consultando el Relacionados para el contributyente: " . $mysqli->error);
    echo json_encode($data);
    exit;
}

$arbitrios_sql      = "SELECT * FROM tempo_arbitrios_2020       WHERE persona_id = '$codigo' ORDER BY predio_id ASC";
//FALLO LA CONSULTA SQL
if (!$consulta_arbitrios = $mysqli->query($arbitrios_sql)) {
    $data = array("error"=>true, "valor"=>"Error consultando el Relacionados para el contributyente: " . $mysqli->error);
    echo json_encode($data);
    exit;
}

$EC_sql             = "SELECT * FROM tempo_ec_2020              WHERE persona_id = '$codigo'";
//FALLO LA CONSULTA SQL
if (!$consulta_EC = $mysqli->query($EC_sql)) {
    $data = array("error"=>true, "valor"=>"Error consultando el Relacionados para el contributyente: " . $mysqli->error);
    echo json_encode($data);
    exit;
}

$EC_totales_sql     = "SELECT * FROM tempo_ec_totales_2020      WHERE persona_id = '$codigo'";
//FALLO LA CONSULTA SQL
if (!$consulta_totales_EC = $mysqli->query($EC_totales_sql)) {
    $data = array("error"=>true, "valor"=>"Error consultando el Relacionados para el contributyente: " . $mysqli->error);
    echo json_encode($data);
    exit;
}

$deudas_anteriores_sql  = "SELECT * FROM tempo_deudas_anteriores_2020 WHERE persona_id = '$codigo'";
//FALLO LA CONSULTA SQL
if (!$consulta_deudas_anteriores = $mysqli->query($deudas_anteriores_sql)) {
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
                    "pie_HR"                    => $consulta_pie_hr->fetch_array(),
                    "relacionados"              => $consulta_relacionados->fetch_array(),
                    "PU"                        => $consulta_PU->fetch_array(),
                    "construcciones"            => $consulta_construcciones->fetch_array(),
                    "instalaciones"             => $consulta_instalaciones->fetch_array(),
                    "PR"                        => $consulta_PR->fetch_array(),
                    "HLP"                       => $consulta_HLP->fetch_array(),
                    "HLP_tramos"                => $consulta_tramos->fetch_array(),
                    "HLP_cronograma"            => $consulta_cronograma->fetch_array(),
                    "arbitrios"                 => $consulta_arbitrios->fetch_array(),
                    "EC"                        => $consulta_EC->fetch_array(),
                    "EC_totales"                => $consulta_totales_EC->fetch_array(),
                    "deudas_anteriores"         => $consulta_deudas_anteriores->fetch_array(),
                );

    array_push($data, $temp);
}

echo json_encode($data);

// El script automáticamente liberará el resultado y cerrará la conexión
// a MySQL cuando finalice, aunque aquí lo vamos a hacer nostros mismos
//$resultado->free();
$mysqli->close();
