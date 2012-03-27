<?php

require_once('db_connection.php');

class Read_lcd{
    
    private $file_name;
    private $file_type;
    private $obj_con;
    
    private $tag;
    private $cate_size;
    private $access_size;
    private $product_size;
    private $product_type_size;
    
    public function __construct($file, $type){
        $this->file_name = $file;
        $this->file_type = $type;
        $this->obj_con = new Db_connection();
        $vals = array('type_name'=>$this->file_type);
        $this->obj_con->insert('nec_product_type',$vals);
        $this->product_type_size = $this->obj_con->getId('nec_product_type');
    }
    
    function get_fname(){
        return $this->file_name;
    }
    
    function read(){
        ini_set('auto_detect_line_endings',TRUE);
        //$handle = fopen('file.csv','r');
        $handle = fopen($this->file_name,'r');
        
        $data;
        
        //deal with headings
        for($i=0; $i<3; $i++){
            $data = fgetcsv($handle);
        }
        
        //caption line
        $data = fgetcsv($handle);
        
        //price type
        $data = fgetcsv($handle);
        
        //data begins here
        while (!feof($handle)){
            $data = fgetcsv($handle);//print_r($data);
            if(count($data)!=1){
                $this->process($data);
            }
            else
                continue;
        }
        
        fclose($handle);
    }

    function process($line){
        
        if($line[0] != null){
            
            if(substr_count(trim($line[0]),'Access')==0){
                $this->tag = 'c';
        
                //add to category table
                $vals = array("cate_name"=>$line[0]);
                $this->obj_con->insert('nec_lcd_tv_cate',$vals);
                $this->cate_size = $this->obj_con->getId('nec_lcd_tv_cate');
            }
            else{
                $this->tag ='a';
            }
        }
        
        if($this->tag == 'c' && trim($line[2]) != null && trim($line[2]) != ""){//if($this->tag == 'c'){
            $this->add_data($line, $this->cate_size);
        }
        else if($this->tag == 'a' && trim($line[2]) != null && trim($line[2]) != ""){  
            //add to accessories
            $this->add_accessories($line,$this->cate_size);
        }
    }
    
    function add_data($line_data,$counter){
        
        //add to projector table
        $vals = array("code"=>$line_data[2],
                      "notes"=>$line_data[3],
                      "scr"=>$line_data[4],
                      "description"=>$line_data[5],
                      "wty"=>$line_data[6],
                      "cate_fk"=>$counter);

        //print_r($vals);
        $this->obj_con->insert('nec_lcd_tv',$vals);
        $this->product_size = $this->obj_con->getId('nec_lcd_tv');
        
        $this->add_price_list($this->product_size,0, $line_data);
    }
    
    function add_accessories($line_data,$counter){
        //$counter is category id
        $vals = array('code'=>$line_data[2],
                      'description'=>$line_data[5],
                      'cate_fk'=>$counter);
        //print_r($vals);
        $this->obj_con->insert('nec_lcd_tv_access',$vals);
        $access_fk = $this->obj_con->getId('nec_lcd_tv_access');
        
        $this->add_price_list(0,$access_fk, $line_data);
    }
    
    function add_price_list($product_id, $access_id, $line){
        //add to price_list table
        //$counter is category id
        
        //add distributor price list
        $vals = array("exGST"=>$line[7],
                      "incGST"=>$line[8],
                      "cate_fk"=>$this->cate_size,
                      "product_type_fk"=>$this->product_type_size,
                      "dealer_type_fk"=>"1",
                      "product_fk"=>$product_id,
                      "access_fk"=>$access_id);
        $this->obj_con->insert('nec_price_list',$vals);
        
        //add key partner price list
        $vals = array("exGST"=>$line[9],
                      "incGST"=>$line[10],
                      "cate_fk"=>$this->cate_size,
                      "product_type_fk"=>$this->product_type_size,
                      "dealer_type_fk"=>"2",
                      "product_fk"=>$product_id,
                      "access_fk"=>$access_id);
        $this->obj_con->insert('nec_price_list',$vals);
        
        //add pro av price list
        $vals = array("exGST"=>$line[11],
                      "incGST"=>$line[12],
                      "cate_fk"=>$this->cate_size,
                      "product_type_fk"=>$this->product_type_size,
                      "dealer_type_fk"=>"3",
                      "product_fk"=>$product_id,
                      "access_fk"=>$access_id);
        $this->obj_con->insert('nec_price_list',$vals);
    
        //add gov price list
        $vals = array("exGST"=>$line[13],
                      "incGST"=>$line[14],
                      "cate_fk"=>$this->cate_size,
                      "product_type_fk"=>$this->product_type_size,
                      "dealer_type_fk"=>"4",
                      "product_fk"=>$product_id,
                      "access_fk"=>$access_id);
        $this->obj_con->insert('nec_price_list',$vals);
        
        //add wholesale 1 price list
        $vals = array("exGST"=>$line[15],
                      "incGST"=>$line[16],
                      "cate_fk"=>$this->cate_size,
                      "product_type_fk"=>$this->product_type_size,
                      "dealer_type_fk"=>"5",
                      "product_fk"=>$product_id,
                      "access_fk"=>$access_id);
        $this->obj_con->insert('nec_price_list',$vals);
        
        //add wholesale 2 price list
        $vals = array("exGST"=>$line[17],
                      "incGST"=>$line[18],
                      "cate_fk"=>$this->cate_size,
                      "product_type_fk"=>$this->product_type_size,
                      "dealer_type_fk"=>"6",
                      "product_fk"=>$product_id,
                      "access_fk"=>$access_id);
        $this->obj_con->insert('nec_price_list',$vals);
        
        //add h/norman comm price list
        $vals = array("exGST"=>$line[19],
                      "incGST"=>$line[20],
                      "cate_fk"=>$this->cate_size,
                      "product_type_fk"=>$this->product_type_size,
                      "dealer_type_fk"=>"7",
                      "product_fk"=>$product_id,
                      "access_fk"=>$access_id);
        $this->obj_con->insert('nec_price_list',$vals);
        
        //add int vision price list
        $vals = array("exGST"=>$line[21],
                      "incGST"=>$line[22],
                      "cate_fk"=>$this->cate_size,
                      "product_type_fk"=>$this->product_type_size,
                      "dealer_type_fk"=>"8",
                      "product_fk"=>$product_id,
                      "access_fk"=>$access_id);
        $this->obj_con->insert('nec_price_list',$vals);
        
        //add RRP price list
        $vals = array("exGST"=>"0",
                      "incGST"=>$line[23],
                      "cate_fk"=>$this->cate_size,
                      "product_type_fk"=>$this->product_type_size,
                      "dealer_type_fk"=>"9",
                      "product_fk"=>$product_id,
                      "access_fk"=>$access_id);
        $this->obj_con->insert('nec_price_list',$vals);
    }
    //echo "read whole file";
    
}
?>
