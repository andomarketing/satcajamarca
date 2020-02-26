<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Hoja Contribuyente</title>

        <!-- CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
$contribuyente_sql  = "SELECT * FROM tempo_contribuyentes_2020 ORDER BY persona_id LIMIT $pagina_contri, 200";

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
while ($contribuyente = $consulta_contribuyente->fetch_array()) { ?>

    <div style="width: 100%; height: 370mm;display:block; position:relative; font-size: 10pt; font-family: Arial; font-weight: bold; page-break-after: always;">
        <span style="position: absolute; bottom: 45.5mm; right: 92mm;"><?php echo $contribuyente["emision"]; ?> </span>
        <span style="position: absolute; bottom: 45.5mm; left: 38mm;" ><?php echo $contribuyente["persona_id"]; ?> </span>
        <span style="position: absolute; bottom: 38.5mm; left: 72mm;" ><?php echo $contribuyente["apellidos_nombres"]; ?> </span>
        <span style="position: absolute; bottom: 29.5mm; left: 72mm; width: 50%; font-size: 9pt; line-height: 12pt;" ><?php echo strtoupper($contribuyente["domicilio_completo"]); ?> </span>
        <span style="position: absolute; bottom: 23mm; left: 72mm;"> <?php echo $contribuyente["NroDeclaracionJurada"]; ?> </span>
        <span style="position: absolute; bottom: 16.5mm; left: 42mm;" ><?php echo $contribuyente["referencia"]; ?> </span>
    </div>

<?php } ?>
    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="/js/funciones.js"></script>
    <style>
        html {
            margin: 0 auto;        
        }
        body {
            width: 100% ; height: 370mm;
            margin: 0 auto;
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
                margin: 0 auto;
            }
            body {
                width: 100% ; height: 370mm;
                margin: 0 auto;
            }
        }
    </style>
</body>
</html>