<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
* PDF library for Code Igniter applications
* Author: Phil Went, May 2007
* uses HTMLDOC http://www.htmldoc.org/ to create the pdfs
* modelled on the specialpdf mediawiki plugin by Thomas Hempel
*/

    function pdf_create($bhtml, $filename)
    {
        
        $bhtml = utf8_decode($bhtml);
   
        $page = $filename;

        $html = $bhtml;

        $mytemp = dirname(FCPATH) . "/tmp/f" .time(). "-" . mt_rand(111,999) . ".html";
        
        $article_f = fopen($mytemp,'w+');
        fwrite($article_f,$html);
        fclose($article_f);
        putenv("HTMLDOC_NOCGI=1");
        
        # Write the content type to the client...
        header("Content-Type: application/pdf");
        header(sprintf('Content-Disposition: attachment; filename="%s.pdf"', $page));
        flush();

        # if the page is on a HTTPS server and contains images that are on the HTTPS server AND also reachable with HTTP
        # uncomment the next line
        
        #system("perl -pi -e 's/img src=\"https:\/\//img src=\"http:\/\//g' '$mytemp'");

        # Run HTMLDOC to provide the PDF file to the user...
        passthru("htmldoc -t pdf14 --charset iso-8859-1 --color --quiet --jpeg --webpage '$mytemp'");
        
        //unlink ($mytemp);

/*sample
function outputpdf()
{
     $this->load->plugin('to_htmldoc'); //or autoload
     $html = $this->load->view('viewfile', $data, true);
     $filename = 'pdf_output';
     pdf_create($html, $filename);
}

*/
}
?> 