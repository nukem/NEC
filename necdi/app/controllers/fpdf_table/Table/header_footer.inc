<?php

/**
 * Class extention for Header and Footer Definitions
 *
 */
class pdf_usage extends fpdf_table
{
	
	public function Header()
	{
		$this->SetStyle("head1","arial","",6,"160,160,160");
		$this->SetStyle("head2","arial","",6,"0,119,220");
		
	    $this->SetY(10);
	    
	    $this->MultiCellTag(100, 3, "<head2 href='http://www.nec-cds.com.au'>NEC Commercial Display Solutions\n</head2><head1>Price Book</head1>");
	    
	    //$this->Image('images/interpid_logo.png', 160, 10, 40, 0, '', 'http://www.interpid.eu');

	    $this->SetY($this->tMargin);
	}	
	
	public function Footer()
	{
	    $this->SetY(-10);
	    $this->SetFont('Arial','I',7);
	    $this->SetTextColor(170, 170, 170);
	    $this->MultiCell(0, 4, "Page {$this->PageNo()} / {nb}", 0, 'C');
	}
} 

?>