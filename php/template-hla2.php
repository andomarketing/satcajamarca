<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HLA</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .main{
            margin-top: 33.4mm; 
            margin-left: 17mm;
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
            padding-top: 2mm;
            font-size: 6pt;
            height: 21.6mm;
            margin-bottom: 19mm;
        }
        .pre1-td {
            padding-left: 4mm;
            position: relative;
        }
        .pre1-td-left {}
        .pre1-td-rigth {
            width: 57.4%;
        }
        .pre2-table {
            padding-top: 1mm;
            font-size: 6pt;
            height: 26mm;
            margin-bottom: 6mm;
        }
        .pre2-table td {
            padding-left: 0mm;
        }
        .pre2-td-left {            
            width: 54mm;
        }
        .pre2-td-rigth {            
            width: 76mm;
        }
        .pre3-table {
            padding-top: 0.5mm;
            font-size: 6pt;
            height: 24.5mm;
            margin-bottom: 5mm;
        }
        .pre3-table td {
            padding-left: 0mm;
        }
        .pre3-td-left {            
            width: 54mm;
        }
        .pre3-td-rigth {            
            width: 76mm;
        }
        .pre4-table {
            padding-top: 1mm;
            font-size: 6pt;
            height: 17.5mm;
            margin-bottom: 6.5mm;
        }
        .pre4-table td {
            padding-left: 0mm;
        }
        .pre4-td-left {            
            width: 54mm;
        }
        .pre4-td-rigth {            
            width: 76mm;
        }
        .pre5-table {
            padding-top: 0mm;
            font-size: 6pt;
            height: 18mm;
            margin-bottom: 6.5mm;
        }
        .pre5-table td {
            padding-left: 0mm;
        }
        .pre5-td-left {            
            width: 54mm;
        }
        .pre5-td-rigth {            
            width: 76mm;
        }
        @media print{
            .white-text{
                visibility: hidden;
                color: #FFF !important;
            }
            table {            
                border: none;
            }
        }
    </style>
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
$contribuyente_sql  = "SELECT * FROM tempo_contribuyentes_2020 ORDER BY persona_id LIMIT $pagina_contri, 500";

//FALLO LA CONSULTA SQL
if (!$consulta_contribuyente = $mysqli->query($contribuyente_sql)) {
    $data = array("error" => true, "valor" => "Error consultando el contributyente: " . $mysqli->error);
    echo json_encode($data);
    exit;
}

//GUARDAR CONSULTA EN ARRAY
while ($contribuyente = $consulta_contribuyente->fetch_array()):
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
    while ($PU = $consulta_PU->fetch_array()): 
    
           $arbitrios_sql = "SELECT * FROM tempo_arbitrios_2020 WHERE predio_id = '".$PU["predio_id"]."' ORDER BY predio_id ASC";
           //FALLO LA CONSULTA SQL
           if (!$consulta_arbitrios = $mysqli->query($arbitrios_sql)) {
               $data = array("error" => true, "valor" => "Error consultando el PU para el contributyente: " . $mysqli->error);
               echo json_encode($data);
               exit;
           }

            $Frente = "";
            $costoMLBarrido = "";
            $MontoRealAnualBarrido = "";
            $MontoAnualBarridoSubvencion = "";
            $MontoTRimestreBarrido = "";
            $AreaUtilizadaUso = "";
            $Uso = "";
            $Costo_m2_anualRecojo = "";
            $MontoAnualRealRecojo = "";
            $MontoAnualSubvencionRecojo = "";
            $MontoTRimestreRecojo = "";
            $UbicacionParque = "";
            $IndicedisfruteParque = "";
            $MontoRealAnualParque = "";
            $FOrmulaSubvencion = "";
            $MontoSubvencionParques = "";
            $MontoTRimestreParque = "";
            $zonaSeguridad = "";
            $usoSeguridad = "";
            $indice_peligrosidad = "";
            $MontoAnualSeguridad = "";
            $MontoTRimestreSeguridad = "";

           while($arbitrio = $consulta_arbitrios->fetch_array()): 
                //BARRIDO DE CALLES
                if ($arbitrio["Arbitrio"] == "LP - Barrido Calle") {
                    $Frente = $arbitrio["Frente"];
                    $costoMLBarrido = $arbitrio["costoMLBarrido"];
                    $MontoRealAnualBarrido = $arbitrio["MontoRealAnualBarrido"];
                    $MontoAnualBarridoSubvencion = $arbitrio["MontoAnualBarridoSubvencion"];
                    $MontoTRimestreBarrido = $arbitrio["MontoTRimestreBarrido"];
                }
                //RECOLECCION DE RESIDUOS SOLIDOS
                if ($arbitrio["Arbitrio"] == "LP - Recojo Basura") {

                    $AreaUtilizadaUso = $arbitrio["AreaUtilizadaUso"];
                    $Uso = $arbitrio["Uso"];
                    $Costo_m2_anualRecojo = $arbitrio["Costo_m2_anualRecojo"];
                    $MontoAnualRealRecojo = $arbitrio["MontoAnualRealRecojo"];
                    $MontoAnualSubvencionRecojo = $arbitrio["MontoAnualSubvencionRecojo"];
                    $MontoTRimestreRecojo = $arbitrio["MontoTRimestreRecojo"];

                }
                //PARQUES Y JARDINES
                if ($arbitrio["Arbitrio"] == "Parques Jardines") {
                    $UbicacionParque = $arbitrio["UbicacionParque"];
                    $IndicedisfruteParque = $arbitrio["IndicedisfruteParque"];
                    $MontoRealAnualParque = $arbitrio["MontoRealAnualParque"];
                    $FOrmulaSubvencion = $arbitrio["FOrmulaSubvencion"]. " =";
                    $MontoSubvencionParques = $arbitrio["MontoSubvencionParques"];
                    $MontoTRimestreParque = $arbitrio["MontoTRimestreParque"];
                }
                //SEGURIDAD CIUDADANA
                if ($arbitrio["Arbitrio"] == "Serenazgo") {
                    $zonaSeguridad = $arbitrio["zonaSeguridad"];
                    $usoSeguridad = $arbitrio["usoSeguridad"];
                    $indice_peligrosidad = $arbitrio["indice_peligrosidad"];
                    $MontoAnualSeguridad = $arbitrio["MontoAnualSeguridad"];
                    $MontoTRimestreSeguridad = $arbitrio["MontoTRimestreSeguridad"];
                }
           endwhile;
?>            
        <div class="main" style="display: block; width: 100% ; height: 155mm; font-size: 6pt; font-family: Arial; font-weight: bold; page-break-after: always;">
            <div style="position: relative; width: 100%;">
                <span style="position: absolute; top: -6.5mm; right: 15mm;"> <?= $emision ?> </span>
            </div>
           <table class="pre1-table">
                <tr class="pre1-tr">
                    <td class="pre1-td pre1-td-left"><span class="white-text" >CÓDIGO CONTRIBUYENTE</span> <?= $persona_id ?></td>
                    <td class="pre1-td pre1-td-rigth"></td>
                </tr>
                <tr class="pre1-tr">
                    <td class="pre1-td pre1-td-left" colspan="2"><span class="white-text">NOMBRE</span> <?= $apellidos_nombres ?></td>
                </tr>
                <tr class="pre1-tr">
                    <td class="pre1-td pre1-td-left"><span class="white-text" >CÓDIGO PREDIO</span> <?= $PU["predio_id"] ?></td>
                    <td class="pre1-td pre1-td-rigth"></td>
                </tr>
                <tr class="pre1-tr">
                    <td class="pre1-td pre1-td-left" colspan="2"><span class="white-text">DIRECCIÓN DE PREDIO</span> <span style="position: absolute; width: 74%; right: 2mm; top: 0.2mm"> <?= strtoupper($PU["direccion_completa"]) ?> </span></td>
                </tr>
            </table>

            <table class="pre2-table">
                <tr class="pre2-tr">
                    <td class="pre2-td pre2-td-left"><span class="white-text">Frecuencia de barrido de calles</span></td>
                    <td class="pre2-td pre2-td-rigth"><span class="white-text" style="margin-right: 2mm;">Diaria</span> <?= $Frente ?></td>
                </tr>
                <tr class="pre2-tr">
                    <td class="pre2-td pre2-td-left"><span class="white-text">Longitud determinada por</span></td>
                    <td class="pre2-td pre2-td-rigth"><span class="white-text">Metros lineales</span></td>
                </tr>
                <tr class="pre2-tr">
                    <td class="pre2-td pre2-td-left"><span class="white-text">Longitud de frontis</span></td>
                    <td class="pre2-td pre2-td-rigth"><span class="white-text" style="margin-right: 2mm;">(a)</span> <?= $Frente ?></td>
                </tr>
                <tr class="pre2-tr">
                    <td class="pre2-td pre2-td-left"><span class="white-text">*Costo anual por metros lineales</span></td>
                    <td class="pre2-td pre2-td-rigth"><span class="white-text" style="margin-right: 2mm;">(b)</span> <?= $costoMLBarrido ?></td>
                </tr>
                <tr class="pre2-tr">
                    <td class="pre2-td pre2-td-left"><span class="white-text">*Monto real anual</span></td>
                    <td class="pre2-td pre2-td-rigth"><span class="white-text" style="margin-right: 2mm;">(c) = (a) x (b)</span> <?= $MontoRealAnualBarrido ?></td>
                </tr>
                <tr class="pre2-tr">
                    <td class="pre2-td pre2-td-left"><span class="white-text">Monto subvencionado anual</span></td>
                    <td class="pre2-td pre2-td-rigth"><span class="white-text" style="margin-right: 2mm;">(d) = (c) x 0.2</span> <?= $MontoAnualBarridoSubvencion ?></td>
                </tr>
                <tr class="pre2-tr">
                    <td class="pre2-td pre2-td-left"><span class="white-text">Tasa trimestral 2020</span></td>
                    <td class="pre2-td pre2-td-rigth"><span class="white-text" style="margin-right: 2mm;">(e) = [(c) - (d)]/4</span> <?= $MontoTRimestreBarrido ?></td>
                </tr>
            </table>

            <table class="pre3-table">
                <tr class="pre3-tr">
                    <td class="pre3-td pre3-td-left"><span class="white-text">*Habitantes Promedio</span></td>
                    <td class="pre3-td pre3-td-rigth"><span class="white-text">3</span></td>
                </tr>
                <tr class="pre3-tr">
                    <td class="pre3-td pre3-td-left"><span class="white-text">Área promedio /Área utilizada m2</span></td>
                    <td class="pre3-td pre3-td-rigth"><span class="white-text" style="margin-right: 2mm;">(a)</span><?= $AreaUtilizadaUso ?></td>
                </tr>
                <tr class="pre3-tr">
                    <td class="pre3-td pre3-td-left"><span class="white-text">Uso del predio</span></td>
                    <td class="pre3-td pre3-td-rigth"><span class="white-text"></span><?= $Uso ?></td>
                </tr>
                <tr class="pre3-tr">
                    <td class="pre3-td pre3-td-left"><span class="white-text">*Costo anual por m2</span></td>
                    <td class="pre3-td pre3-td-rigth"><span class="white-text" style="margin-right: 2mm;">(b)</span><?= $Costo_m2_anualRecojo ?></td>
                </tr>
                <tr class="pre3-tr">
                    <td class="pre3-td pre3-td-left"><span class="white-text">*Monto real anual</span></td>
                    <td class="pre3-td pre3-td-rigth"><span class="white-text" style="margin-right: 2mm;">(c) = (a) x (b)</span><?= $MontoAnualRealRecojo ?></td>
                </tr>
                <tr class="pre3-tr">
                    <td class="pre3-td pre3-td-left"><span class="white-text">Monto subvencionado anual</span></td>
                    <td class="pre3-td pre3-td-rigth"><span class="white-text" style="margin-right: 2mm;">(d) = (c) x 0.2</span><?= $MontoAnualSubvencionRecojo ?></td>
                </tr>
                <tr class="pre3-tr">
                    <td class="pre3-td pre3-td-left"><span class="white-text">Tasa trimestral 2020</span></td>
                    <td class="pre3-td pre3-td-rigth"><span class="white-text" style="margin-right: 2mm;">(e) = [(c) - (d)]/4</span><?= $MontoTRimestreRecojo ?></td>
                </tr>
            </table>

            <table class="pre4-table">
                <tr class="pre4-tr">
                    <td class="pre4-td pre4-td-left"><span class="white-text">Descripción de la ubicación</span></td>
                    <td class="pre4-td pre4-td-rigth"><span class="white-text"></span><?= $UbicacionParque ?></td>
                </tr>
                <tr class="pre4-tr">
                    <td class="pre4-td pre4-td-left"><span class="white-text">*Índice de disfrute</span></td>
                    <td class="pre4-td pre4-td-rigth"><span class="white-text"></span><?= $IndicedisfruteParque ?></td>
                </tr>
                <tr class="pre4-tr">
                    <td class="pre4-td pre4-td-left"><span class="white-text">*Monto real anual</span></td>
                    <td class="pre4-td pre4-td-rigth"><span class="white-text" style="margin-right: 2mm;">(a)</span><?= $MontoRealAnualParque ?></td>
                </tr>
                <tr class="pre4-tr">
                    <td class="pre4-td pre4-td-left"><span class="white-text">Monto subvencionado anual</span></td>
                    <td class="pre4-td pre4-td-rigth"><span class="white-text"></span><?= $FOrmulaSubvencion. " ".$MontoSubvencionParques ?></td>
                </tr>
                <tr class="pre4-tr">
                    <td class="pre4-td pre4-td-left"><span class="white-text">Tasa trimestral 2020</span></td>
                    <td class="pre4-td pre4-td-rigth"><span class="white-text" style="margin-right: 2mm;">(a) - (b) /4</span><?= $MontoTRimestreParque ?></td>
                </tr>
            </table>

            <table class="pre5-table">
                <tr class="pre5-tr">
                    <td class="pre5-td pre5-td-left"><span class="white-text">Zona</span></td>
                    <td class="pre5-td pre5-td-rigth"><span class="white-text"></span><?= $zonaSeguridad ?></td>
                </tr>
                <tr class="pre5-tr">
                    <td class="pre5-td pre5-td-left"><span class="white-text">Uso del predio</span></td>
                    <td class="pre5-td pre5-td-rigth"><span class="white-text"></span><?= $usoSeguridad ?></td>
                </tr>
                <tr class="pre5-tr">
                    <td class="pre5-td pre5-td-left"><span class="white-text">*Índice de peligrosidad</span></td>
                    <td class="pre5-td pre5-td-rigth"><span class="white-text"></span><?= $indice_peligrosidad ?></td>
                </tr>
                <tr class="pre5-tr">
                    <td class="pre5-td pre5-td-left"><span class="white-text">*Monto real anual</span></td>
                    <td class="pre5-td pre5-td-rigth"><span class="white-text" style="margin-right: 2mm;">(a)</span><?= $MontoAnualSeguridad ?></td>
                </tr>
                <tr class="pre5-tr">
                    <td class="pre5-td pre5-td-left"><span class="white-text">Tasa trimestral 2020</span></td>
                    <td class="pre5-td pre5-td-rigth"><span class="white-text" style="margin-right: 2mm;">(b) = (a) /4</span><?= $MontoTRimestreSeguridad ?></td>
                </tr>
            </table> 
        </div> 
<?php
    endwhile;

endwhile;
?>
</body>
</html>

