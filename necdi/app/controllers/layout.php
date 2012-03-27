<?php

class Layout extends controller {

	function __construct() {
		parent::controller();

		$this->load->helper('cookie');
	}


	function index() {

		set_cookie('layout', 'new', 12 * 60 * 60, '.nec-cds.com.au');

		echo 'Cookie successfully set. Please continue browsing the <a href="http://www.nec-cds.com.au">NEC Dealer Intranet</a>';

	}

	function revert() {

		set_cookie('layout', '', -12 * 60 * 60, '.nec-cds.com.au');

		echo 'Cookie successfully removed. Please continue browsing the <a href="http://www.nec-cds.com.au">NEC Dealer Intranet</a>';

	}


}

