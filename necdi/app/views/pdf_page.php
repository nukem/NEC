<?php

require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');


$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 002');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
//$pdf->setPrintHeader(false);
//$pdf->setPrintFooter(false); 

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

//set some language-dependent strings
$pdf->setLanguageArray($l);

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

$pdf->writeHTML($html_pagec, true, 0, true, 0);

$pdf->lastPage();

$pdf->Output('test.pdf', 'I');

//print "pdf_page here!!";
//print $html_page;
?>