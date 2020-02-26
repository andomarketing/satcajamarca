<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HLP</title>

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
while ($contribuyente = $consulta_contribuyente->fetch_array()) { 

    $HLP_sql = "SELECT * FROM tempo_hlp_cabecera_2020 WHERE persona_id = '".$contribuyente["persona_id"]."'";
    //FALLO LA CONSULTA SQL
    if (!$consulta_HLP = $mysqli->query($HLP_sql)) {
        $data = array("error" => true, "valor" => "Error consultando el Relacionados para el contributyente: " . $mysqli->error);
        echo json_encode($data);
        exit;
    }

    $HLP_tramos_sql     = "SELECT * FROM tempo_hlp_tramos_2020 WHERE persona_id = '".$contribuyente["persona_id"]."'";
    //FALLO LA CONSULTA SQL
    if (!$consulta_tramos = $mysqli->query($HLP_tramos_sql)) {
        $data = array("error" => true, "valor" => "Error consultando el Relacionados para el contributyente: " . $mysqli->error);
        echo json_encode($data);
        exit;
    }

    $HLP_cronograma_sql = "SELECT * FROM tempo_hlp_cronograma_2020 WHERE persona_id = '".$contribuyente["persona_id"]."' ORDER BY nroCuota ASC";
    //FALLO LA CONSULTA SQL
    if (!$consulta_cronograma = $mysqli->query($HLP_cronograma_sql)) {
        $data = array("error" => true, "valor" => "Error consultando el Relacionados para el contributyente: " . $mysqli->error);
        echo json_encode($data);
        exit;
    }

?>
    <div style="width: 100%; height: 370mm;display:block; position:relative; font-size: 10pt; font-family: Arial; font-weight: bold; page-break-after: always;">
        <!-- DATOS DEL CONTRIBUYENTE -->
        <span style="position: absolute; top: 59.8mm; left: 194.8mm;"><?php echo $contribuyente["emision"]; ?> </span>
        <span style="position: absolute; top: 71.5mm; left: 80mm;" ><?php echo $contribuyente["persona_id"]; ?> </span>
        <span style="position: absolute; top: 85.5mm; left: 55mm;" ><?php echo $contribuyente["apellidos_nombres"]; ?> </span>
        <!-- DATOS DEL CONTRIBUYENTE -->

        <!-- DETERMINACION DE BASE IMPONIBLE HLP -->
        <table style="position: absolute; top: 118mm; width: 80%; font-size: 8pt; font-weight: bold; left: 10%; text-align: center;">
            <tbody>
        <?php while ($HLP = $consulta_HLP->fetch_array()) { ?>
                
                <tr style="display: flex;">
                    <td style="width: 25%; text-align: center; padding: 5px 0 !important;"> <?php echo number_format($HLP["totalBaseImponibel"], 2, ',', '.') ?></td>
                    <td style="width: 25%; text-align: center; padding: 5px 0 !important;"> <?php echo number_format($HLP["deduccionBaseImponible"], 2, ',', '.') ?></td>
                    <td style="width: 20%; text-align: center; padding: 5px 0 !important;"> <?php echo $HLP["PrediosAfectos"] ?></td>
                    <td style="width: 25%; text-align: center; padding: 5px 0 !important;"> <?php echo number_format($HLP["baseImponibleAfecta"], 2, ',', '.') ?></td>
                </tr>
        <?php } ?>
            </tbody>
        </table>
        <!-- DETERMINACION DE BASE IMPONIBLE HLP -->

        <!-- DETERMINACION DEL IMPUESTO PREDIAL -->
        <table style="position: absolute; top: 144mm; width: 30%; font-size: 9pt; font-weight: bold; left: 150mm; text-align: center;">
            <tbody>
        <?php while ($tramos = $consulta_tramos->fetch_array()) { ?>
                <span style="position: absolute; top: 153mm; width: 15%; font-size: 10pt; font-weight: bold; left: 15%; text-align: center;"><?php echo $tramos["base_afecta"] ?></span>
                <tr style="display: flex;">
                    <td style="width: 100%; text-align: center; padding: 2% !important;"> <?php echo $tramos["tramo_1"] ?> </td>
                </tr>
                <tr style="display: flex;">
                    <td style="width: 100%; text-align: center; padding: 2% !important;"> <?php echo $tramos["tramo_2"] ?> </td>
                </tr>
                <tr style="display: flex;">
                    <td style="width: 100%; text-align: center; padding: 2% !important;"> <?php echo $tramos["tramo_3"] ?> </td>
                </tr>
                <tr style="display: flex;">
                    <td style="width: 100%; text-align: center; padding: 2% !important;"> <?php echo $tramos["impuesto"] ?> </td>
                </tr>
        <?php } ?>
            </tbody>
        </table>
        <!-- DETERMINACION DEL IMPUESTO PREDIAL -->
    
        <!-- CRONOGRAMA DE PAGOS -->
        <table style="position: absolute; top: 199mm; width: 76%; font-size: 9pt; font-weight: bold; left: 12%; text-align: center;">
            <tbody>
        <?php while ($cronograma = $consulta_cronograma->fetch_array()) { ?>
                 <tr style="display: flex;">
                    <td style="width: 12%; padding: 0.8% 0.8% 0.8%  !important;"> <?php echo $cronograma["nroCuota"] ?> </td>
                    <td style="width: 18%; padding: 0.8% !important;"> <?php echo $cronograma["Vencimiento"] ?> </td>
                    <td style="width: 24%; padding: 0.8% !important;"> <?php echo number_format($cronograma["insoluto"], 2, ',', '.') ?> </td>
                    <td style="width: 21%; padding: 0.8% !important;"> <?php echo number_format($cronograma["derecho_emision"], 2, ',', '.') ?> </td>
                    <td style="width: 21%; padding: 0.8% !important;"> <?php echo number_format($cronograma["Impuesto"], 2, ',', '.') ?> </td>
                </tr>
        <?php } ?>
            </tbody>
        </table>
        <!-- CRONOGRAMA DE PAGOS -->

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