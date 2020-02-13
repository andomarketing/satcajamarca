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

//CONSULTA SQL
$sql = "SELECT hr2_fija.*, datos_variables_hr1.*
FROM hr2_fija  
INNER JOIN datos_variables_hr1 ON hr2_fija.persona_id = '$codigo' && hr2_fija.persona_id = datos_variables_hr1.ID_AUXILIAR";

//FALLO LA CONSULTA SQL
if (!$resultado = $mysqli->query($sql)) {
    $data = array("error"=>true, "valor"=>"Error: " . $mysqli->error);
    echo json_encode($data);
    exit;
}

//NO SE ENCONTRARON REGISTROS
if ($resultado->num_rows === 0) {
    $data = array("error"=>true, "valor"=>"No se han encontrado registros.");
    echo json_encode($data);
    exit;
}

//GUARDAR CONSULTA EN ARRAY
while ($x = $resultado->fetch_array()) {
    $temp = array(  
                    "error"                 => false,
                    //FIJOS
                    "ID_AUXILIAR"           => $x["ID_AUXILIAR"],
                    "persona_id"            => $x["persona_id"],
                    "fecha_de_emision_1"    => date_format(date_create($x["fecha_de_emision_1"]), 'd-m-Y'),
                    "determinacion_id"      => $x["determinacion_id"],
                    "emision"               => $x["emision"],
                    "tipo_contribuyente"    => $x["tipo_contribuyente"],
                    "nro_docu_identidad"    => $x["nro_docu_identidad"],
                    "apellidos_nombres"     => $x["apellidos_nombres"],
                    "direccion_completa"    => $x["direccion_completa"],
                    "base_imponible"        => $x["base_imponible"],
                    "base_afecta"           => $x["base_afecta"],
                    "impuesto"              => $x["impuesto"],
                    "monto_de_la_cuota"     => $x["monto_de_la_cuota"],
                    "fecha_de_emision"      => date_format(date_create($x["fecha_de_emision"]), 'd-m-Y'),
                    //VARIABLES
                    "item"                  => $x["item"],
                    "predio_id"             => $x["predio_id"],
                    "cod_manzana"           => $x["cod_manzana"],
                    "direccion_predial"     => $x["direccion_predial"],
                    "referencia"            => $x["referencia"],
                    "porc_propiedad"        => $x["porc_propiedad"],
                    "valor_predio"          => $x["valor_predio"],
                    "base_imponible_variable" => $x["base_imponible"],
                    "monto_inafecto"        => $x["monto_inafecto"],
                    "fecha_adquisicion"     => date_format(date_create($x["fecha_adquisicion"]), 'd-m-Y'),
                );
    array_push($data, $temp);
}
echo json_encode($data);


// El script automáticamente liberará el resultado y cerrará la conexión
// a MySQL cuando finalice, aunque aquí lo vamos a hacer nostros mismos
$resultado->free();
$mysqli->close();
