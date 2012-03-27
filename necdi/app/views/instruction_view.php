<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?= $this->config->item('base_url') ?>" />
<title>print NEC price list</title>
<style type="text/css" media="screen,print">
body{
    background: #A1B5CC;
    font-family: sans-serif;
    
}
</style>
</head>
<body>
<center>
    
    <h3>Printing Instructions</h3>

    <p>
    When printing the NEC PriceBook, please ensure the following printing settings are enabled on your browser
    </p>
    </center>
    <ul>
        <li>Please use the "page-setup" on the browser file menu to get the page orientation to be landscape</li>
        <li>Also on your printer properties/preference select the preferred paper size and select option to "shrink to fit to page width" or "scale to fit" in order to get all the contents of the page gets printed on the paper.</li>
    </ul>
    </p>
<br /><br />
<center>
    <input type="button" value="Continue To Print" onclick="window.opener.print(); window.close();" />
    <input type="button" value="Cancel" onclick="window.close();" />
</center>
</body>
</html>