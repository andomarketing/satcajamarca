<?php 

if (isset($_POST["codigo"])) {
    if ($_POST["codigo"] != "" || $_POST["codigo"] != null) {
        $codigo = "CODIGO = '" . $_POST["codigo"] . "'";
    }else{
        $codigo = "";
    }
}else{
    $codigo = "";
}

if (isset($_POST["id_persona"])) {
    if ($_POST["id_persona"] != "" || $_POST["id_persona"] != null) {
        $id_persona = "PERSONA_ID = '" . $_POST["id_persona"] . "'";
    }else{
        $id_persona = "";
    }
}else{
    $id_persona = "";
}

if ($codigo != "" && $id_persona != "" || $codigo != null && $id_persona != null) {
    $condiciones = "$codigo && $id_persona";
}else{
    $condiciones = $codigo.$id_persona;
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
$sql = "SELECT * FROM pr_fija WHERE $condiciones";

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
                    "error"             => false,
                    "ID_AUXILIAR"       => $x["ID_AUXILIAR"],
                    "PERSONA_ID"        => $x["PERSONA_ID"],
                    "FECHA_EMISION"     => $x["FECHA_EMISION"],
                    "DETERMINACION_ID"  => $x["DETERMINACION_ID"],
                    "CODIGO"            => $x["CODIGO"],
                    "APELLIDOS_NOMBRES" => $x["APELLIDOS_NOMBRES"],
                    "CONYUGUE"          => $x["CONYUGUE"],
                    "EMISION_ID"        => $x["EMISION_ID"],
                );
    array_push($data, $temp);
}
echo json_encode($data);


// El script automáticamente liberará el resultado y cerrará la conexión
// a MySQL cuando finalice, aunque aquí lo vamos a hacer nostros mismos
$resultado->free();
$mysqli->close();
