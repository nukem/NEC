<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Extra extends Controller {

	function Extra() {
		
		parent::Controller();
		
	}
	
	function index() {
	
	}
	
	function tdc() {
	
		$fp = fopen('http://www.necdisplay.com/SupportCenter/ImageCalculator/', 'r');

		$html = stream_get_contents($fp);
		fclose($fp);
		
		$new_css = "
		<style type=\"text/css\">
		#headercontainer {
			display:none;
		}
		#imenus0 {
			display:none;
		}
		#footercontainer {
			display:none;
		}
		</style>
		";
		
		$new_js = "
		<script type=\"text/javascript\">
		var el = document.getElementById('printdata');
		var pel = el.previousSibling.previousSibling;
		pel.style.display = 'none';
		</script>
		";
				
		$search[0] = '|<head>|';
		$replace[0] = '<head><base href="http://www.necdisplay.com/SupportCenter/ImageCalculator/" />';
		
		$search[1] = '|</head>|';
		$replace[1] = $new_css . '</head>';
		
		$search[2] = '|<title>[^<]+</title>|';
		$replace[2] = '<title>Throw Distance Calculator</title>';
		
		$search[3] = '|<input type="button" onclick="getaQuote();" value="get a dealer quote" name="get_qoute" class="smallTextBold"/>|';
		$replace[3] = '';
		
		$search[4] = '</body>';
		$replace[4] = $new_js . '</body>';
		
		$html = preg_replace($search, $replace, $html);
		header("Content-Type: text/html");
		echo $html;
	
	}
	
}