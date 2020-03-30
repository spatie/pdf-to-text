<?php
/**
 * Created by PhpStorm.
 * User: julius hernandez alvarado
 * Date: 3/27/2020
 * Time: 12:24 PM
 */

require 'vendor/autoload.php';

use \Smalot\PdfParser\Parser;
use \Spatie\PdfToText\Pdf;

$pdfFiles = glob("pdf-input\*.pdf");

usePdfToText($pdfFiles);

function usePdfToText ($pdfFiles) {
    foreach($pdfFiles as $pdfFile) {
        //$pdfObj = (new Pdf())->setPdf($pdfFile)->text();
        $text = Pdf::getText($pdfFile);
        $debug = 1;
    }
}

// at the moment PdfParser can't parse these PDFs
function usePdfParser ($pdfFiles) {
    $parser = new Parser();
    
    foreach($pdfFiles as $pdfFile) {
        //echo "\n_> scanning: " . basename($pdfFile) . "\n";
        $pdf = $parser->parseFile($pdfFile);
        $text = $pdf->getText();
        $debug = 1;
    }
}






//