<?php 

//SE RECIBE EL NUMERO DE PÁGINA
if (isset($_POST['pageno'])) {
    if ($_POST["pageno"] != "" || $_POST["pageno"] != null) {
        $pageno = $_POST['pageno'];
    }else{
        $pageno = 1;
    }
    
} else {
    $pageno = 1;
}

$no_de_registros = 15;
$offset = ($pageno-1) * $no_de_registros;

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

// SE CONSULTA EL TOTAL DE REGISTROS EN LA BASE DE DATOS
$paginas_totales_sql = "SELECT COUNT(*) FROM hr1_fija";
$pag_resultado = $mysqli->query($paginas_totales_sql);
$filas_totales = mysqli_fetch_array($pag_resultado)[0];
$paginas_totales = ceil($filas_totales / $no_de_registros);

//CONSULTA SQL
$sql = "SELECT codigo_persona, nro_docu_identidad, apellidos_nombres FROM hr1_fija ORDER BY codigo_persona ASC LIMIT $offset, $no_de_registros";

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
                    "codigo_persona"        => $x["codigo_persona"],
                    "nro_docu_identidad"    => $x["nro_docu_identidad"],
                    "apellidos_nombres"     => $x["apellidos_nombres"],
                    "n_paginas"             => $paginas_totales,
                    "pagina_actual"         => $pageno
                );
    array_push($data, $temp);
}
echo json_encode($data);


// El script automáticamente liberará el resultado y cerrará la conexión
// a MySQL cuando finalice, aunque aquí lo vamos a hacer nostros mismos
$resultado->free();
$mysqli->close();
