<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PU</title>

        <!-- CSS -->
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/estilos.css">
    </head>
    <body>

<?php

$pagina_contri = $_GET["pg"];

//CONEXION BASE DE DATOS
include "db.php";

//EXISTE UN ERROR DE CONEXION
if ($mysqli->connect_errno) {
    $data = array("error" => true, "valor" => "Error: " . $mysqli->connect_error);
    echo json_encode($data);
    exit;
}

//CONSULTAS SQL
$contribuyente_sql  = "SELECT * FROM tempo_contribuyentes_2020 ORDER BY persona_id = 21";

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

    $emision = $contribuyente["emision"];
    $persona_id = $contribuyente["persona_id"];
    $apellidos_nombres = $contribuyente["apellidos_nombres"];

    $PU_sql = "SELECT * FROM tempo_pu_2020 WHERE persona_id = '$persona_id' ORDER BY predio_id ASC";
    //FALLO LA CONSULTA SQL
    if (!$consulta_PU = $mysqli->query($PU_sql)) {
        $data = array("error" => true, "valor" => "Error consultando el PU para el contributyente: " . $mysqli->error);
        echo json_encode($data);
        exit;
    }

    $construcciones_sql = "SELECT * FROM tempo_construcciones_2020 WHERE persona_id = '$persona_id' ORDER BY predio_id ASC";
    //FALLO LA CONSULTA SQL
    if (!$consulta_construcciones = $mysqli->query($construcciones_sql)) {
        $data = array("error" => true, "valor" => "Error consultando contrucciones para el contributyente: " . $mysqli->error);
        echo json_encode($data);
        exit;
    }
    $cant_construcciones = $consulta_construcciones->num_rows;
    $conta_construcciones = 1;
    $offset_construcciones =  (1 - 1) * 3;

    $instalaciones_sql  = "SELECT * FROM tempo_instalaciones_2020 WHERE persona_id = '$persona_id' ORDER BY predio_id ASC";
    //FALLO LA CONSULTA SQL
    if (!$consulta_instalaciones = $mysqli->query($instalaciones_sql)) {
        $data = array("error" => true, "valor" => "Error consultando instalaciones para el contributyente: " . $mysqli->error);
        echo json_encode($data);
        exit;
    }
    $cant_instalaciones = $consulta_instalaciones->num_rows;
    $conta_instalaciones = 1;
    $offset_instalaciones =  (1 - 1) * 4;


    if($cant_construcciones > 3 || $cant_instalaciones > 5){

        
        $n_paginas_construcciones = ceil($cant_construcciones / 3);
        $n_paginas_instalaciones = ceil($cant_instalaciones / 5);

        while ( $n_paginas_construcciones >= $conta_construcciones || $n_paginas_instalaciones >= $conta_instalaciones) {

            $PU_sql = "SELECT * FROM tempo_pu_2020 WHERE persona_id = '$codigo' ORDER BY predio_id ASC";
            //FALLO LA CONSULTA SQL
            if (!$consulta_PU = $mysqli->query($PU_sql)) {
                $data = array("error" => true, "valor" => "Error consultando el PU para el contributyente: " . $mysqli->error);
                echo json_encode($data);
                exit;
            }

            $construcciones_sql = "SELECT * FROM tempo_construcciones_2020 WHERE persona_id = '".$contribuyente["persona_id"]."' ORDER BY item LIMIT $offset_relacionados, $nro_registros_relacionados";
            //FALLO LA CONSULTA SQL
            if (!$consulta_construcciones = $mysqli->query($construcciones_sql)) {
                $data = array("error" => true, "valor" => "Error consultando contrucciones para el contributyente: " . $mysqli->error);
                echo json_encode($data);
                exit;
            }
            $instalaciones_sql  = "SELECT * FROM tempo_instalaciones_2020 WHERE persona_id = '$codigo' ORDER BY predio_id ASC";
            //FALLO LA CONSULTA SQL
            if (!$consulta_instalaciones = $mysqli->query($instalaciones_sql)) {
                $data = array("error" => true, "valor" => "Error consultando instalaciones para el contributyente: " . $mysqli->error);
                echo json_encode($data);
                exit;
            }
            ?>

                <div style="display: block; width: 100% ; height: 370mm; position:relative; font-size: 6pt; font-family: Arial; font-weight: bold; page-break-after: always;">
        
                    <!-- DATOS DEL CONTRIBUYENTE -->
                    <span style="position: absolute; top: 35mm; left: 101mm;"> <?php echo $contribuyente["NroDeclaracionJurada"]; ?> </span>
                    <span style="position: absolute; top: 45.5mm; left: 135.2mm;"><?php echo $contribuyente["emision"]; ?> </span>
                    <span style="position: absolute; top: 54.5mm; left: 55.7mm;" ><?php echo $contribuyente["persona_id"]; ?> </span>
                    <span style="position: absolute; top: 60mm; left: 38mm;" ><?php echo $contribuyente["apellidos_nombres"]; ?> </span>
                    <!-- DATOS DEL CONTRIBUYENTE -->
        
                </div>

            <?php


            if ($n_paginas_construcciones >= 1 && $conta_construcciones <= $n_paginas_construcciones) {
                $conta_construcciones +=1;
                $offset_construcciones =  ($conta_construcciones - 1) * 3;
            }

            if ($n_paginas_instalaciones >= 1 && $conta_instalaciones <= $n_paginas_instalaciones) {
                $conta_instalaciones +=1;
                $offset_instalaciones =  ($conta_instalaciones - 1) * 5;
            }

        }

    }else{ ?>

        <div style="display: block; width: 100% ; height: 370mm; position:relative; font-size: 6pt; font-family: Arial; font-weight: bold; page-break-after: always;">

            <!-- DATOS DEL CONTRIBUYENTE -->
            <span style="position: absolute; top: 35mm; left: 101mm;"> <?php echo $contribuyente["NroDeclaracionJurada"]; ?> </span>
            <span style="position: absolute; top: 45.5mm; left: 135.2mm;"><?php echo $contribuyente["emision"]; ?> </span>
            <span style="position: absolute; top: 54.5mm; left: 55.7mm;" ><?php echo $contribuyente["persona_id"]; ?> </span>
            <span style="position: absolute; top: 60mm; left: 38mm;" ><?php echo $contribuyente["apellidos_nombres"]; ?> </span>
            <!-- DATOS DEL CONTRIBUYENTE -->

    
            
            <? while ($PU = $consulta_PU->fetch_array()) { ?>
                <!-- DATOS DEL PREDIO -->
                <span style="position: absolute; top: 35mm; left: 10mm;"> <?php echo $PU["predio_id"]; ?> </span>
                <span style="position: absolute; top: 45mm; left: 13mm;"> <?php echo $PU["codigoCatastral"]; ?> </span>
                <span style="position: absolute; top: 54mm; left: 55mm;"> <?php echo $PU["direccion_completa"]; ?> </span>
                <span style="position: absolute; top: 60mm; left: 38mm;"> <?php echo $PU["lugar"]; ?> </span>
                <span style="position: absolute; top: 35mm; left: 10mm;"> <?php echo $PU["sector"]; ?> </span>
                <table>
                    <tbody>
                        <tr>
                            <td> <?php echo $PU["ubicacion_predio"]; ?> </td>
                            <td> <?php echo $PU["condicion_propiedad"]; ?> </td>
                            <td> <?php echo $PU["porc_paticipacion"]; ?> </td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <tbody>
                        <tr>
                            <td> <?php echo $PU["area_terreno"]; ?> </td>
                            <td> <?php echo $PU["arancel"]; ?> </td>
                            <td> <?php echo $PU[""]; ?> </td>
                        </tr>
                    </tbody>
                </table>

                <table>
                    <tbody>
                        <td></td>
                        <td><?php echo $PU["area_construida"]; ?></td>
                        <td></td>
                        <td><?php echo $PU[""]; ?></td>
                    </tbody>
                </table>
                <table>
                    <tbody>
                        <td><?php echo $PU["valor_terreno"]; ?></td>
                        <td><?php echo $PU["valor_construccion"]; ?></td>
                        <td><?php echo $PU["valor_instalacion"]; ?></td>
                        <td><?php echo $PU["base_imponible"]; ?></td>
                    </tbody>
                </table>

            <?php } ?>
            <!-- DATOS DEL PREDIO -->


        </div>
<?php
    }
}
?>
    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="/js/funciones.js"></script>
    <style>
        html {
            margin: 0;  
            width: 100% ; height: 370mm;     
        }
        body {
            width: 100% ; height: 370mm;
            margin: 0;
        }
        hr {
            page-break-after: always;
            border: 0;
            margin: 0;
            padding: 0;
        }
        table td{
            padding-top: 2px !important;
            padding-bottom: 2px !important;
        }

        @media print{
            html {
                margin: 0;
                width: 100% ; height: 370mm;
            }
            body {
                width: 100% ; height: 370mm;
                margin: 0;
            }
        }
    </style>
</body>
</html>