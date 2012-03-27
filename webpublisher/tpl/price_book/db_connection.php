<?php

//require_once('config.php');
require_once('cfg.php');

class Db_connection{
    
    private $con;
    
    private $projector = "Projector";
	private $whiteboard = "LCD Desktop Monitors";
	//private $display = "Commercial Flat Panel Display";
	private $display = "LCD Public Displays";
	private $lcd = "LCD & Plasma Television";
	private $whitegoods = "Whitegoods";
    
    public function __construct(){
        
        global $cfg; 

        $host = $cfg['db']['address'];
        $user = $cfg['db']['username'];
        //$cfg['db']['host'];
        //$user = $cfg['db']['user'];
        $password = $cfg['db']['password'];
        $db = $cfg['db']['name'];
                
        $this->con = mysql_connect($host,$user,$password) or die('Conn Error');
        if (!$this->con) die('Could not connect: ' . mysql_error($this->con));
        mysql_select_db($db,$this->con) or die('Select error');
    }
    
    public function insert($table, $field_values){
        $fields = array_keys($field_values);
        $values = array_values($field_values);
        
        $escVals = array();
        for($i=0; $i<count($fields); $i++) {
            $fields[$i] = trim($fields[$i]);
            $values[$i] = trim($values[$i]);
            if(! is_numeric($values[$i])) {
                $escVals[$i] = "'" . $values[$i] . "'";
            }
            else
                $escVals[$i] = $values[$i];
            
        }
        
        //generate the SQL statement
        $sql = " INSERT INTO $table (";
        $sql .= join(', ', $fields);
        $sql .= ") VALUES (";
        $sql .= join(', ', $escVals);
        $sql .= ")";

        $rs = mysql_query($sql, $this->con) or die('Insert Error' . $sql);
        
    }
    
    public function getId($table){
        $sql = " SELECT COUNT(*) AS size FROM $table";
        
        $rs = mysql_query($sql, $this->con) or die('Query error');
        
        $size;
        while(($row = mysql_fetch_array($rs)) ) {
          $size = $row['size'];
        }
    
        return $size;


    }
    
    public function truncate_table(){
        
        $sql = "TRUNCATE TABLE nec_product_type";
        $rs = mysql_query($sql, $this->con) or die ('Truncate Error' . mysql_error());
        
        $sql = "TRUNCATE TABLE nec_projector";
        $rs = mysql_query($sql, $this->con);
        
        $sql ="TRUNCATE TABLE nec_projector_cate";
        $rs = mysql_query($sql, $this->con);
        
        $sql = "TRUNCATE TABLE nec_projector_access";
        $rs = mysql_query($sql, $this->con);
        
        $sql = "TRUNCATE TABLE nec_price_list";
        $rs = mysql_query($sql, $this->con);
        
        $sql = "TRUNCATE TABLE nec_whiteboard";
        $rs = mysql_query($sql, $this->con);
        
        $sql = "TRUNCATE TABLE nec_whiteboard_cate";
        $rs = mysql_query($sql, $this->con);
        
        $sql = "TRUNCATE TABLE nec_panel_display";
        $rs = mysql_query($sql, $this->con);
        
        $sql = "TRUNCATE TABLE nec_panel_display_cate";
        $rs = mysql_query($sql, $this->con);
        
        $sql = "TRUNCATE TABLE nec_panel_display_access";
        $rs = mysql_query($sql, $this->con);
        
        $sql = "TRUNCATE TABLE nec_whitegoods";
        $rs = mysql_query($sql, $this->con);
        
        $sql = "TRUNCATE TABLE nec_whitegoods_cate";
        $rs = mysql_query($sql, $this->con);
        
        $sql = "TRUNCATE TABLE nec_lcd_tv";
        $rs = mysql_query($sql, $this->con);
        
        $sql = "TRUNCATE TABLE nec_lcd_tv_cate";
        $rs = mysql_query($sql, $this->con);
        
        $sql = "TRUNCATE TABLE nec_lcd_tv_access";
        $rs = mysql_query($sql, $this->con);
    }
	
	public function update_pricebook_title($title = '')
	{
		if (trim($title) == '')
		{
			return false;
		}
		
		mysql_query("UPDATE wp_structure SET title = '" . mysql_real_escape_string($title) . "' WHERE id = 2257", $this->con);
		
		return true;
	}
    
    
    public function __destruct(){
        if(is_resource($this->con)){
            mysql_close($this->con);
        }
    }
    
    
}


?>

