<?php

require_once('read_projector2.php');
require_once('read_whiteboard2.php');
require_once('read_display2.php');
//require_once('read_lcd.php');
//require_once('read_whitegoods.php');
error_reporting(E_ALL);
ini_set("display_errors", 1); 

class Upload{
    
    private $file;
    private $rname;
    private $type;
    private $obj_read;
    
    private $projector = "Projector";
	private $whiteboard = "LCD Desktop Monitors";
	//private $display = "Commercial Flat Panel Display";
	private $display = "LCD Public Displays";
	private $lcd = "LCD & Plasma Television";
	private $whitegoods = "Whitegoods";
    
    function __construct($u_file, $u_rname,$u_type){
        $this->file = $u_file;
        $this->rname = $u_rname;
        $this->type = $u_type;
    }
    
    function get_file_name(){
        return $this->file['name'];
    }
    
    function get_rname(){
        return $this->rname;
    }
    
    function load_file(){
        $fname = $this->file['name'];
        $dotpos = strrpos($fname,'.');
        $length = strlen($fname);
        $ext = substr($fname, $dotpos,$length-1);
        
        $this->rname = 'files/' . $this->rname . time() . $ext;
        
        if($this->type == trim($this->projector)){
            if (is_uploaded_file($this->file['tmp_name'])) {
                move_uploaded_file($this->file['tmp_name'], $this->rname);
                $this->obj_read = new Read_projector($this->rname,$this->type);
                $this->obj_read->read();
            }
        }
		
        else if($this->type == trim($this->whiteboard)){
            if (is_uploaded_file($this->file['tmp_name'])) {
                move_uploaded_file($this->file['tmp_name'], $this->rname);
                $this->obj_read = new Read_whiteboard($this->rname,$this->type);
                $this->obj_read->read();
            }
        }
        
        else if($this->type == trim($this->display)){
            if (is_uploaded_file($this->file['tmp_name'])) {
                move_uploaded_file($this->file['tmp_name'], $this->rname);
                $this->obj_read = new Read_display($this->rname,$this->type);
                $this->obj_read->read();
            }
        }
        
        else if($this->type == trim($this->lcd)){
            if (is_uploaded_file($this->file['tmp_name'])) {
                move_uploaded_file($this->file['tmp_name'], $this->rname);
                $this->obj_read = new Read_lcd($this->rname,$this->type);
                $this->obj_read->read();
            }
        }
        
        else if($this->type == trim($this->whitegoods)){
            if (is_uploaded_file($this->file['tmp_name'])) {
                move_uploaded_file($this->file['tmp_name'], $this->rname);
                $this->obj_read = new Read_whitegoods($this->rname,$this->type);
                $this->obj_read->read();
            }
        }
        
    }
    
    
}


?>
