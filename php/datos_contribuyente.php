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
                <td style="border: 1px solid; padding: 0 1em;">Cod.</td>
                <td style="border: 1px solid; padding: 0 1em;">Apellidos Nombres</td>
                <td style="border: 1px solid; padding: 0 1em;">HR</td>
                <td style="border: 1px solid; padding: 0 1em;">PU</td>
                <td style="border: 1px solid; padding: 0 1em;">PR</td>
                <td style="border: 1px solid; padding: 0 1em;">HLP</td>
                <td style="border: 1px solid; padding: 0 1em;">HLA</td>
                <td style="border: 1px solid; padding: 0 1em;">EC</td>
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
    
    if (isset($_GET["pg"])) {
        $pg = $_GET["pg"];
    }else{
        $pg = 0;
    }

    //CONSULTAS SQL
    $contribuyente_sql  = "SELECT * FROM tempo_contribuyentes_2020 ORDER BY persona_id LIMIT $pg, 500";
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

    

    //GUARDAR CONSULTA EN ARRAY
    while ($contribuyente = $consulta_contribuyente->fetch_array()) {

        $codigo = $contribuyente["persona_id"];

        $hr_sql = "SELECT * FROM tempo_hr_2020 WHERE persona_id = '$codigo'";
        //FALLO LA CONSULTA SQL
        if (!$consulta_hr = $mysqli->query($hr_sql)) {
            $data = array("error" => true, "valor" => "Error consultando el HR contributyente: " . $mysqli->error);
            echo json_encode($data);
            exit;
        }

        $HR = "";
        //NO SE ENCONTRARON REGISTROS
        if ($consulta_hr->num_rows === 0) {
            $HR = "No";
        } else {
            $HR = "Si [$consulta_hr->num_rows]";
        }


        $PU_sql = "SELECT * FROM tempo_pu_2020 WHERE persona_id = '$codigo' ORDER BY predio_id ASC";
        //FALLO LA CONSULTA SQL
        if (!$consulta_PU = $mysqli->query($PU_sql)) {
            $data = array("error" => true, "valor" => "Error consultando el PU para el contributyente: " . $mysqli->error);
            echo json_encode($data);
            exit;
        }
        $PU = "";
        //NO SE ENCONTRARON REGISTROS
        if ($consulta_PU->num_rows === 0) {
            $PU = "No";
        } else {
            $PU = "Si [$consulta_PU->num_rows]";
        }

        $PR_sql = "SELECT * FROM tempo_pr_2020 WHERE persona_id = '$codigo' ORDER BY predio_id ASC";
        //FALLO LA CONSULTA SQL
        if (!$consulta_PR = $mysqli->query($PR_sql)) {
            $data = array("error" => true, "valor" => "Error consultando el Relacionados para el contributyente: " . $mysqli->error);
            echo json_encode($data);
            exit;
        }
        $PR = "";
        //NO SE ENCONTRARON REGISTROS
        if ($consulta_PR->num_rows === 0) {
            $PR = "No";
        } else {
            $PR = "Si [$consulta_PR->num_rows]";
        }

        $HLP_sql            = "SELECT * FROM tempo_hlp_cabecera_2020    WHERE persona_id = '$codigo'";
        //FALLO LA CONSULTA SQL
        if (!$consulta_HLP = $mysqli->query($HLP_sql)) {
            $data = array("error" => true, "valor" => "Error consultando el Relacionados para el contributyente: " . $mysqli->error);
            echo json_encode($data);
            exit;
        }
        $HLP = "";
        //NO SE ENCONTRARON REGISTROS
        if ($consulta_HLP->num_rows === 0) {
            $HLP = "No";
        } else {
            $HLP = "Si [$consulta_HLP->num_rows]";
        }

        $arbitrios_sql = "SELECT * FROM tempo_arbitrios_2020 WHERE persona_id = '$codigo' ORDER BY predio_id ASC";
        //FALLO LA CONSULTA SQL
        if (!$consulta_arbitrios = $mysqli->query($arbitrios_sql)) {
            $data = array("error" => true, "valor" => "Error consultando el Relacionados para el contributyente: " . $mysqli->error);
            echo json_encode($data);
            exit;
        }
        $arbitrios = "";
        //NO SE ENCONTRARON REGISTROS
        if ($consulta_arbitrios->num_rows === 0) {
            $arbitrios = "No";
        } else {
            $arbitrios = "Si [". ( ceil((int)$consulta_arbitrios->num_rows / 4 ))."]";
        }

        $EC_sql             = "SELECT * FROM tempo_ec_2020              WHERE persona_id = '$codigo'";
        //FALLO LA CONSULTA SQL
        if (!$consulta_EC = $mysqli->query($EC_sql)) {
            $data = array("error" => true, "valor" => "Error consultando el Relacionados para el contributyente: " . $mysqli->error);
            echo json_encode($data);
            exit;
        }
        $EC = "";
        //NO SE ENCONTRARON REGISTROS
        if ($consulta_EC->num_rows === 0) {
            $EC = "No";
        } else {
            $EC = "Si";
        }

        ?>

            <tr>
                <td style="border: 1px solid; padding: 0 1em;"><?= $codigo ?></td>
                <td style="border: 1px solid; padding: 0 1em;"><?= $contribuyente["apellidos_nombres"] ?></td>
                <td style="border: 1px solid; padding: 0 1em;"><?= $HR ?></td>
                <td style="border: 1px solid; padding: 0 1em;"><?= $PU ?></td>
                <td style="border: 1px solid; padding: 0 1em;"><?= $PR ?></td>
                <td style="border: 1px solid; padding: 0 1em;"><?= $HLP ?></td>
                <td style="border: 1px solid; padding: 0 1em;"><?= $arbitrios ?></td>
                <td style="border: 1px solid; padding: 0 1em;"><?= $EC ?></td>
            </tr>

        <?php
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
    