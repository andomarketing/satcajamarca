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

$sql = "SELECT * FROM pu_fija 
INNER JOIN datos_variables_pu_predio ON pu_fija.persona_id = datos_variables_pu_predio.AUXILIAR_ID 
INNER JOIN datos_variables_pu ON datos_variables_pu_predio.predio_id = datos_variables_pu.ID_AUXILIAR_COD_PREDIO WHERE $condiciones ";
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
                    "PERSONA_ID"        => $x["persona_id"],
                    "FECHA_EMISION"     => date_format(date_create($x["fecha_de_emision"]), 'd-m-Y'),
                    "DETERMINACION_ID"  => $x["determinacion_id"],
                    "CODIGO"            => $x["codigo"],
                    "APELLIDOS_NOMBRES" => $x["apellidos_nombres"],
                    "CONYUGUE"          => $x["conyuge"],
                    "EMISION_ID"        => $x["emision_id"],

                    "ESTADO_CONSTRUCCCION" => $x["estado"],
                    "DESCRIPCION"          => $x["descripcion"],
                    "PORC_PROPIEDAD"       => $x["porc_propiedad"],
                    "AREA_TERRENO"         => $x["area_terreno"],
                    "VALOR_ARANCEL"        => $x["valor_arancel"],
                    "VALOR_TERRENO"        => $x["valor_terreno"],
                    "DIRECCION"            => $x["direccion_completa"],
                    "VALOR_AREA_CONSTRUIDA" => $x["valor_area_construida"],
                    "VALOR_DE_CONSTRUCCION" => $x["valor_de_construccion"],

                    //tercera tabbla
                    "ITEM"                     =>  $x["item"],
                    "DENTIPONIVEL"             =>  $x["dentiponivel"],
                    "NIVEL"                    =>  $x["nivel"],
                    "ANTIGUEDAD"               =>  $x["antiguedad"],
                    "MAT_PREDOMINANTE_ID"      =>  $x["mat_predominante_id"],
                    "CONSERVACION_ID"          =>  $x["conservacion_id"],
                    "CLASI_DEPRECIACION_ID"    =>  $x["clasi_depreciacion_id"],
                    "DENMUROS"                 =>  $x["denmuros"],
                    "DENTECHO"                 =>  $x["dentecho"],
                    "DENPISOS"                 =>  $x["denpisos"],
                    "DENPUERTAS"               =>  $x["denpuertas"],
                    "DENREVESTIMIENTO"         =>  $x["denrevestimiento"],
                    "DENBANNOS"                =>  $x["denbannos"],
                    "DENELECTRICO"             =>  $x["denelectrico"],
                    "VALOR_UNITARIO"           =>  $x["valor_unitario"],
                    "VALOR_INCREMENTO"         =>  $x["valor_incremento"],
                    "PORC_DEPRECIACION"        =>  $x["porc_depreciacion"],
                    "VALOR_DEPRECIACION"       =>  $x["valor_depreciacion"],
                    "AREA_CONSTRUIDA"          =>  $x["area_construida"],
                    "A_CONST_M2"               =>  $x["a_const_m2"],
                    "A_CONST"                  =>  $x["a_const"],

                    

                );
    array_push($data, $temp);
}
echo json_encode($data);


// El script automáticamente liberará el resultado y cerrará la conexión
// a MySQL cuando finalice, aunque aquí lo vamos a hacer nostros mismos
$resultado->free();
$mysqli->close();
