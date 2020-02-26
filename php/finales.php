<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <table>
        <thead>
            <tr>
                <td style="border: 1px solid; padding: 0 1em;">Serie </td>
                <td style="border: 1px solid; padding: 0 1em;">Inicio</td>
                <td style="border: 1px solid; padding: 0 1em;">Final</td>
            </tr>
        </thead>
        <tbody>
        
    <?php

    //SE ESTABLECE COMO JSON EL HEADER
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
    $contribuyente_sql  = "SELECT persona_id FROM tempo_contribuyentes_2020 ORDER BY persona_id";
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

    $cod_inicio = 0;
    $cod_final = 0;
    $serie_inicio = 0;
    $serie_final = 0;
    $cont_serie = 0;

    //GUARDAR CONSULTA EN ARRAY
    while ($contribuyente = $consulta_contribuyente->fetch_array()) {

        if ($cont_serie == 500) {
            $cod_final = $contribuyente["persona_id"];
            $serie_final += $cont_serie;
            $cont_serie = 0;
            ?>
                <tr>
                    <td style="border: 1px solid; padding: 0 1em;"><?= $serie_inicio ." - ".$serie_final ?></td>
                    <td style="border: 1px solid; padding: 0 1em;"><?= $cod_inicio ?></td>
                    <td style="border: 1px solid; padding: 0 1em;"><?= $cod_final ?></td>
                </tr>
            <?php
        }else{
            if ($cont_serie = 0) {
                $cod_inicio = $contribuyente["persona_id"];
                if ($serie_final == 0) {
                    $serie_inicio = 0;
                }else{
                    $serie_inicio = $serie_final;
                }
            }
            $cont_serie += 1;
        }
        
    }
    // El script automáticamente liberará el resultado y cerrará la conexión
    // a MySQL cuando finalice, aunque aquí lo vamos a hacer nostros mismos
    //$resultado->free();
    $mysqli->close();
?>
        </tbody>
    </table>

</body>
</html>    
    