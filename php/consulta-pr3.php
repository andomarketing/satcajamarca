<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PR !AL FIN x2!</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .main{

            /** DIFERENCIAS DE ALTURA ES 2.5mm y 1mm IZQUIERDA */
            margin-top: 39.5mm; 
            margin-left: 15.5mm;
            max-width: 129mm;
        }
        table {            
            border-spacing: 0px;
            width: 100%;
            border: 0.005mm solid blue;
        }
        .white-text {
            font-weight: 100;
        }
        .pre1-table {
            font-size: 6pt;
            height: 17mm;
            margin-bottom: 1mm;
        }
        .pre1-td {
            padding-left: 3mm;
        }
        .pre1-td-left {}
        .pre1-td-rigth {
            width: 57.4%;
        }
        .pre2-table {
            font-size: 5pt;
            height: 11mm;
            margin-bottom: 1mm;
        }
        .pre2-table td{
            position: relative;
        }
        .pre2-td-left {
            padding-left: 3mm;
            width: 37.1%;
        }
        .pre2-td-rigth {
            width:30%;
        }
        .pre3-table {
            font-size: 5pt;
            border: none;
            margin-bottom: 6mm;
        }
        .pre3-td {
            padding-left: 1.5mm;
        }
        .pre4-table{
            font-size: 4pt;
            height: 6mm;
            margin-bottom: 6mm;
        }
        .pre4-table td{
            position: relative;
        }
        .pre4-td-left {
            padding-left: 1mm;
            width: 36%;
        }
        .pre4-td-rigth {
            width:31%;
        }
        .vertical-text {
            writing-mode: vertical-lr;
            transform: rotate(180deg);
        }
        .horizontal-text {
            font-size: 4.5pt;
        }
        .const-table {
            font-size: 4.5pt;
            text-align: center;
            vertical-align: bottom;
            margin-left: -1mm;
            margin-bottom: 8mm;
            height: 55.5mm;
        }
        .const-table td{
            border-right: 0.005mm solid blue;
            border-bottom: 0.005mm solid blue;
        }
        .comp-table {
            font-size: 4pt;
            text-align: center;
        }
        .comp-table tr{
            vertical-align: top;
        }
        .comp-table td{
            border-right: 0.005mm solid blue;
            border-bottom: 0.005mm solid blue;
        }
        @media print{
            .white-text{
                visibility: hidden;
                color: #FFF !important;
            }
            table {            
                border: none;
            }
            .const-table td{
                border-right: none;
                border-bottom: none;
            }
            .comp-table td{
                border-right: none;
                border-bottom: none;
            }
        }
    </style>
</head>
<body>
<?php
//CONEXION BASE DE DATOS
include "db.php";

define("PR_TEMPLATE", "plantilla-pr.php");
$pg = $_GET["pg"];


function render($template, $info){
    ob_start();
    extract($info, EXTR_OVERWRITE);
    include($template);
    return ob_get_clean();
}

//EXISTE UN ERROR DE CONEXION
if ($mysqli->connect_errno) {
    $data = array("error" => true, "valor" => "Error: " . $mysqli->connect_error);
    echo json_encode($data);
    exit;
}

//TRAER LOS PREDIOS ORDENADOS POR EL ID CONTRIBUYENTE
//CONSULTAS SQL
//$prediosSQL  = "SELECT * FROM tempo_pr_2020 WHERE predio_id = 29612";
$prediosSQL  = "SELECT * FROM tempo_pr_2020 WHERE persona_id = $pg ";

//FALLO LA CONSULTA SQL
if (!$consulta_predio = $mysqli->query($prediosSQL)) {
    $data = array("error" => true, "valor" => "Error consultando el contributyente: " . $mysqli->error);
    echo json_encode($data);
    exit;
}

//RECORRER EL ARRAY DE PREDIOS OBTENIDOS DE BASE DE DATOS
while ($PR = $consulta_predio->fetch_array()) {
    
    //CONTRIBUYENTES DATOS
    $contribuSQL  = "SELECT * FROM  tempo_contribuyentes_2020 WHERE persona_id = ". $PR["persona_id"];
    //FALLO LA CONSULTA SQL
    if (!$consultaContri = $mysqli->query($contribuSQL)) { echo "Error en consulta SQL Contribuyente";}
    
    //POR CADA PREDIO TRAER TODAS LAS CONSTRUCCIONES
    $construSQL  = "SELECT * FROM  tempo_construcciones_2020 WHERE predio_id = ". $PR["predio_id"];
    //FALLO LA CONSULTA SQL
    if (!$consulta_constru = $mysqli->query($construSQL)) { echo "Error en consulta SQL Construccion";}
    //POR CADA PREDIO TRAER TODAS LAS INSTALACIONES
    $instaSQL  = "SELECT * FROM  tempo_instalaciones_2020 WHERE predio_id = ". $PR["predio_id"];
    //FALLO LA CONSULTA SQL
    if (!$consulta_insta = $mysqli->query($instaSQL)) { echo "Error en consulta SQL Instalacion";}
    
    $info = array();
    $info["PR"] = $PR;
    $info["contri"] = $consultaContri->fetch_all(MYSQLI_ASSOC)[0];
    $allConstru = $consulta_constru->fetch_all(MYSQLI_ASSOC);
    $allInsta = $consulta_insta->fetch_all(MYSQLI_ASSOC);

    $max_constru = 3;
    $max_insta = 3;
    
    //CASO EN QUE SUPEREN EL TAMAÑO DEL CUADRO.
    if (count($allConstru) > $max_constru || count($allInsta) > $max_insta ) {
        $allConstAndInst = [
            "constru" => [],
            "insta" => []
        ];

        $pg_constru = ceil(count($allConstru) / $max_constru);            
        $offsetCostru = 0;
        for ($i = 0; $i < $pg_constru; $i++) {
            $allConstAndInst["constru"][] = array_slice($allConstru, $offsetCostru, $max_constru);
            $offsetCostru += $max_constru;
        }
        
        $pg_insta = ceil(count($allInsta) / $max_insta);
        $offsetInsta = 0;
        for ($i = 0; $i < $pg_insta; $i++) {
            $allConstAndInst["insta"][] = array_slice($allInsta, $offsetInsta, $max_insta);
            $offsetInsta += $max_insta;
        }

        $constAndInstPages = [];

        foreach ($allConstAndInst["constru"] as $page => $construPerPage) {
            $constAndInstPages[$page]["constru"] = $construPerPage;
        }
        foreach ($allConstAndInst["insta"] as $page => $instaPerPage) {
            $constAndInstPages[$page]["insta"] = $instaPerPage;
        }

        foreach ($constAndInstPages as $page => $pagesForPrint) {
            if (isset($constAndInstPages[$page]["constru"])) {
                $info["constru"] = $constAndInstPages[$page]["constru"];
            } else {
                $info["constru"] = [];
            }
            if (isset($constAndInstPages[$page]["insta"])) {
                $info["insta"] = $constAndInstPages[$page]["insta"];
            } else {
                $info["insta"] = [];
            }
            echo render(PR_TEMPLATE, $info);
        }


    }else{
        $info["constru"] = $allConstru;
        $info["insta"] = $allInsta;
        echo render(PR_TEMPLATE, $info);
    }
}
?>
</body>
</html>