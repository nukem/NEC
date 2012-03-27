<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

ini_set("memory_limit", "30M");

function pdf_create($html, $filename, $stream=TRUE)
{
    require_once("dompdf/dompdf_config.inc.php");
    
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper('a4', 'landscape');
    $dompdf->render();
    if ($stream) {
        $dompdf->stream("pricebook.pdf");
    } else {
        write_file("pricebook.pdf", $dompdf->output());
    }
}

