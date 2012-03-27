<?php

class Pricebook_model extends Model{
    
    private $projector = "Projector";
	private $whiteboard = "LCD Desktop Monitors";
	//private $display = "Commercial Flat Panel Display";
	private $display = "LCD Public Displays";
	private $lcd = "LCD & Plasma Television";
	private $whitegoods = "Whitegoods";
    
    function Pricebook_model(){
        
        parent::Model();
    }
	
	function get_pb_title(){
		$sql = 'SELECT * FROM wp_structure WHERE id = 2257';
		$query = $this->db->query($sql);
		if( $query->num_rows() > 0 )
			return $query->result_array();
		else
			return false;
	}
    
    function get_product_types(){
        
        $sql = 'SELECT * FROM nec_product_type';
        $query = $this->db->query($sql);
        if($query->num_rows()>0){
            return $query->result_array();
        }
        else
            return false;
    }
    
    function get_dealer_cate($pb_id){
        $sql = 'SELECT * FROM nec_dealer WHERE id='.$pb_id;
        $query = $this->db->query($sql);
        if($query->num_rows()>0){
            return $query->result_array();
        }
        else
            return false;
    }
    
    function get_categories($type_name){
        
        
        if($type_name==trim($this->projector)){
            $sql = 'SELECT * FROM nec_projector_cate';
            $query = $this->db->query($sql);
            if($query->num_rows()>0){
                return $query->result_array();
            }
            else
                return false;
        }
        
        
        if($type_name==trim($this->whiteboard)){
            $sql = 'SELECT * FROM nec_whiteboard_cate';
            $query = $this->db->query($sql);
            if($query->num_rows()>0){
                return $query->result_array();
            }
            else
                return false;
        }
        
        
        if($type_name==trim($this->display)){
            $sql = 'SELECT * FROM nec_panel_display_cate';
            $query = $this->db->query($sql);
            if($query->num_rows()>0){
                return $query->result_array();
            }
            else
                return false;
        }
        
        
        if($type_name==trim($this->lcd)){
            $sql = 'SELECT * FROM nec_lcd_tv_cate';
            $query = $this->db->query($sql);
            if($query->num_rows()>0){
                return $query->result_array();
            }
            else
                return false;
        }
        
        
        if($type_name==trim($this->whitegoods)){
            $sql = 'SELECT * FROM nec_whitegoods_cate';
            $query = $this->db->query($sql);
            if($query->num_rows()>0){
                return $query->result_array();
            }
            else
                return false;
        }
        
    }
    
    function getTypeId($type_name){
        
        $sql = "SELECT id FROM nec_product_type WHERE type_name='".$type_name."'";
            $query = $this->db->query($sql);
            $rs;
            if($query->num_rows()>0){
                $rs = $query->result_array();
                return $rs[0]['id'];
            }
            else
                return false;
    }
    
    function getTypeName($type_id){
        
        $sql = "SELECT type_name FROM nec_product_type WHERE id=".$type_id;
            $query = $this->db->query($sql);
            $rs;
            if($query->num_rows()>0){
                $rs = $query->result_array();
                return $rs[0]['type_name'];
            }
            else
                return false;
    }
    
    
    function getProductSize($type_id, $cate_id){
        
        $type_name = $this->getTypeName($type_id);
		
        
        
        if($type_name==trim($this->projector)){
            $sql = "SELECT COUNT(*) AS num FROM nec_projector WHERE cate_fk=".$cate_id;
            $query = $this->db->query($sql);
            $rs = $query->result_array();
            return $rs[0]['num'];
        }
        
        
        if($type_name==trim($this->whiteboard)){
            $sql = "SELECT COUNT(*) AS num FROM nec_whiteboard WHERE cate_fk=".$cate_id;
            $query = $this->db->query($sql);
            $rs = $query->result_array();
            return $rs[0]['num'];
        }
        
        
        if($type_name==trim($this->display)){
            $sql = "SELECT COUNT(*) AS num FROM nec_panel_display WHERE cate_fk=".$cate_id;
            $query = $this->db->query($sql);
            $rs = $query->result_array();
            return $rs[0]['num'];
        }
        
        
        if($type_name==trim($this->lcd)){
            $sql = "SELECT COUNT(*) AS num FROM nec_lcd_tv WHERE cate_fk=".$cate_id;
            $query = $this->db->query($sql);
            $rs = $query->result_array();
            return $rs[0]['num'];
        }
        
        
        if($type_name==trim($this->whitegoods)){
            $sql = "SELECT COUNT(*)  AS num FROM nec_whitegoods WHERE cate_fk=".$cate_id;
            $query = $this->db->query($sql);
            $rs = $query->result_array();
            return $rs[0]['num'];
        }
        
    }
	
	function getPriceBookMainArticle(){
	
		$news_items = array();
		
		$nq = $this->db->query("SELECT `id` FROM `wp_structure` WHERE `online` = 1 AND `type` = 'article' AND `parent` = '4225' ORDER BY `position`");

		if ($nq->num_rows() > 0) foreach ($nq->result_array() as $row) {
				
				$news_items[] = $this->get_article_details($row['id']);
				
			}
		return $news_items;
	}
    function get_article_details($id) {
		
		$nq = $this->db->query("SELECT `id`, `title`, `content` FROM `wp_structure`, `wp_article` WHERE `online` = 1 AND `link` = `id` AND `id` = '{$id}' ORDER BY `position`");
		
		$news_item = array();
		
		if ($nq->num_rows() > 0) foreach ($nq->result_array() as $row) {
			
			$news_item = $row;
			
			$iq = $this->db->query("SELECT `id`, `title` FROM `wp_structure` WHERE `online` = 1 AND `type` = 'image' AND `parent` = '{$row['id']}' ORDER BY `position`");
			
			if ($iq->num_rows() > 0) {
				$news_item['images'] = $iq->result_array();
			}
			
			$fq = $this->db->query("SELECT `id`, `title`, `uri`, `extension` FROM `wp_structure`, `wp_file` WHERE `online` = 1 AND `link` = `id` AND `parent` = '{$row['id']}' ORDER BY `position`");
			
			if ($fq->num_rows() > 0) {
				$news_item['files'] = $fq->result_array();
			}
			
		}
		
		return $news_item;
		
	}
    function getAccessorySize($type_id, $cate_id){
        
        $type_name = $this->getTypeName($type_id);
        
        
        if($type_name==trim($this->projector)){
            $sql = "SELECT COUNT(*) AS num FROM nec_projector_access WHERE cate_fk=".$cate_id;
            $query = $this->db->query($sql);
            $rs = $query->result_array();
            return $rs[0]['num'];
        }
        
        
        if($type_name==trim($this->whiteboard)){
            
                return 0;
        }
        
        
        if($type_name==trim($this->display)){
            $sql = "SELECT COUNT(*) AS num FROM nec_panel_display_access WHERE cate_fk=".$cate_id;
            $query = $this->db->query($sql);
            $rs = $query->result_array();
            return $rs[0]['num'];
        }
        
        
        if($type_name==trim($this->lcd)){
            $sql = "SELECT COUNT(*) AS num FROM nec_lcd_tv_access WHERE cate_fk=".$cate_id;
            $query = $this->db->query($sql);
            $rs = $query->result_array();
            return $rs[0]['num'];
        }
        
        
        if($type_name==trim($this->whitegoods)){
            
                return 0;
        }
        
    }
    
    function getProducts($type_id,$cate_id){
        
        $type_name = $this->getTypeName($type_id);
		
		#echo '<!-- tname ' . $type_id . '-' . $type_name . ' # ' . $cate_id . ' -->';
        
        
        if($type_name==trim($this->projector)){
            $sql = "SELECT * FROM nec_projector WHERE cate_fk=".$cate_id;
            $query = $this->db->query($sql);
            if($query->num_rows()>0){
                return $query->result_array();
            }
            else
                return false;
        }
        
        
        if($type_name==trim($this->whiteboard)){
            $sql = "SELECT * FROM nec_whiteboard WHERE cate_fk=".$cate_id;
            $query = $this->db->query($sql);
            if($query->num_rows()>0){
                return $query->result_array();
            }
            else
                return false;
        }
        
        
        if($type_name==trim($this->display)){
            $sql = "SELECT * FROM nec_panel_display WHERE cate_fk=".$cate_id;
            $query = $this->db->query($sql);
            if($query->num_rows()>0){
                return $query->result_array();
            }
            else
                return false;
        }
        
        
        if($type_name==trim($this->lcd)){
            $sql = "SELECT * FROM nec_lcd_tv WHERE cate_fk=".$cate_id;
            $query = $this->db->query($sql);
            if($query->num_rows()>0){
                return $query->result_array();
            }
            else
                return false;
        }
        
        
        if($type_name==trim($this->whitegoods)){
            $sql = "SELECT * FROM nec_whitegoods WHERE cate_fk=".$cate_id;
            $query = $this->db->query($sql);
            if($query->num_rows()>0){
                return $query->result_array();
            }
            else
                return false;
        }
        
    }
    
    
    function getAccessories($type_id,$cate_id){
        
        $type_name = $this->getTypeName($type_id);
        
        
        if($type_name==trim($this->projector)){
            $sql = "SELECT * FROM nec_projector_access WHERE cate_fk=".$cate_id;
            $query = $this->db->query($sql);
            if($query->num_rows()>0){
                return $query->result_array();
            }
            else
                return false;
        }
        
        
        if($type_name==trim($this->whiteboard)){
           
                return false;
        }
        
        
        if($type_name==trim($this->display)){
            $sql = "SELECT * FROM nec_panel_display_access WHERE cate_fk=".$cate_id;
            $query = $this->db->query($sql);
            if($query->num_rows()>0){
                return $query->result_array();
            }
            else
                return false;
        }
        
        
        if($type_name==trim($this->lcd)){
            $sql = "SELECT * FROM nec_lcd_tv_access WHERE cate_fk=".$cate_id;
            $query = $this->db->query($sql);
            if($query->num_rows()>0){
                return $query->result_array();
            }
            else
                return false;
        }
        
        
        if($type_name==trim($this->whitegoods)){
          
                return false;
        }
        
    }
    
    function getProductPriceList($cate_id, $product_type_id,$product_id){
        
        $sql = "SELECT * FROM nec_price_list WHERE cate_fk=".$cate_id." AND product_fk=".$product_id." AND product_type_fk=".$product_type_id;
            $query = $this->db->query($sql);
            if($query->num_rows()>0){
                return $query->result_array();
            }
            else
                return false;
        
    }
	
	function getProductPriceList2($cate_id, $product_type_id,$product_id,$dealer_type_id){
		
		$sql = "SELECT * FROM nec_price_list WHERE cate_fk=".$cate_id." AND product_fk=".$product_id." AND product_type_fk=".$product_type_id." AND dealer_type_fk=".$dealer_type_id;
            $query = $this->db->query($sql);
            if($query->num_rows()>0){
                return $query->result_array();
            }
            else
                return false;
	}
    
    function getAccessPriceList($cate_id, $product_type_id,$access_id){
        
        $sql = "SELECT * FROM nec_price_list WHERE cate_fk=".$cate_id." AND product_type_fk=".$product_type_id." AND access_fk=".$access_id;
            $query = $this->db->query($sql);
            if($query->num_rows()>0){
                return $query->result_array();
            }
            else
                return false;
    }
	
	function getAccessPriceList2($cate_id, $product_type_id,$access_id,$dealer_type_id){
        
        $sql = "SELECT * FROM nec_price_list WHERE cate_fk=".$cate_id." AND product_type_fk=".$product_type_id." AND access_fk=".$access_id." AND dealer_type_fk=".$dealer_type_id;
            $query = $this->db->query($sql);
            if($query->num_rows()>0){
                return $query->result_array();
            }
            else
                return false;
    }
    
    function get_Product_Price_List($cate_id, $product_type_id,$product_id, $dealer_type_id){
        
        $sql = "SELECT * FROM nec_price_list WHERE cate_fk=".$cate_id." AND product_fk=".$product_id." AND product_type_fk=".$product_type_id." AND dealer_type_fk=".$dealer_type_id;
            $query = $this->db->query($sql);
            if($query->num_rows()>0){
                return $query->result_array();
            }
            else
                return false;
        
    }
    
}


?>
