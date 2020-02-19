<?php

// reference the Dompdf namespace
require_once "dompdf/autoload.inc.php";
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$html = file_get_contents( "http://satcajamarca.test/php/consulta_hr.php" );

$dompdf->loadHtml( utf8_decode( $html ) );
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('B5', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();