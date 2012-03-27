<?php

    $projector = "Projector";
    $whiteboard = "LCD Desktop Monitors";
    $display = "LCD Public Displays";$lpd = "Ls";
    $lcd = "LCD & Plasma Television";
    $whitegoods = "Whitegoods";
    
    $distributor = "DISTRIBUTOR";
    $key_partner = "KEY PARTNER";
    $pro_av = "PRO AV";
    $govt = "GOVT";
    $wholesale1 = "WHOLESALE1";
    $wholesale2 = "WHOLESALE2";
    $comm = "H/NORMAN COMM";
    $int_vision = "INT VISION";
    $rrp = "RRP";
    
    $isAdmin = ($user_fk == 181 || $user_fk == 1620);
	


	$csv = "NEC ".$name."-".$cate. " price list\n\n";

        $csv .= "CAT.,";
        $csv .= "Product code,";
        

        if($name == $projector||$name == $whiteboard){

        $csv .= "res,";
        $csv .= "chip set,";

        }
        if($name == $display){

        $csv .= "Color,";
        $csv .= "SCR Size,";

        }
        if($name == $lcd){

        $csv .= "Notes,";
        $csv .= "Size,";

        }

        $csv .= "Product description,";
        $csv .= "Wty,";

        if($pricebook_cate == trim($distributor)|| $isAdmin){

        $csv .= "DISTRIBUTOR,,";

        }
        if($pricebook_cate == trim($key_partner)|| $isAdmin){

        $csv .= "KEY PARTNER,,";

        }
        if($pricebook_cate == trim($pro_av) || $isAdmin){

        $csv .= "PRO AV,,";

        }
        if($pricebook_cate == trim($govt) || $isAdmin){

        $csv .= "GOVT,,";

        }
        if($pricebook_cate == trim($wholesale1) || $isAdmin){

        $csv .= "WHOLESALE 1,,";

        }
        if($pricebook_cate == trim($wholesale2) || $isAdmin){

        $csv .= "WHOLESALE 2,,";

        }
        if($pricebook_cate == trim($comm) || $isAdmin){

        $csv .= "H/NORMAN COMM,,";

        }
        if($pricebook_cate == trim($int_vision) || $isAdmin){

        $csv .= "INT VISION,,";

        }

        $csv .= "RRP\n";
        
        if($name == $whitegoods){
            $csv .= ",,,,";
        }
        else{
            $csv .= ",,,,,,";
        }
        
        if($isAdmin){
            
            //for($a=0; $a<8; $a++){
            //    $csv .= "exGST,";
            //    $csv .= "incGST,";
            //}
        }
        else{
            $csv .= "exGST,";
            $csv .= "incGST,";
        }

        $csv .= "inGST\n";
   

for( $i=0; $i < count ( $table ) ; $i++ ) {
        
        if( $i == 0 ){
            $csv .= $cate;
        }

        $csv .= ",".$table[$i]['code'].",";
                   
        
        if($name == $projector||$name == $whiteboard){

        $csv .= $table[$i]['res'].",";
        $csv .= $table[$i]['chipset'].",";

        }
        if($name == $display){

        $csv .= $table[$i]['color'].",";
        $csv .= $table[$i]['scr'].",";

        }
        if($name == $lcd){

        $csv .= $table[$i]['notes'].",";
        $csv .= $table[$i]['scr'].",";

        }

        $csv .= "\"" . str_ireplace( "\"" , "''" , $table[$i]['description'] )."\",";
        $csv .= $table[$i]['wty'].",";

        if($pricebook_cate == trim($distributor) || $isAdmin){

        $csv .= "\"".$table[$i]['0_ex']."\",";
        $csv .= "\"".$table[$i]['0_inc']."\",";

        }
        if($pricebook_cate == trim($key_partner) || $isAdmin){

        $csv .= "\"".$table[$i]['1_ex']."\",";
        $csv .= "\"".$table[$i]['1_inc']."\",";

        }
        if($pricebook_cate == trim($pro_av) || $isAdmin){

        $csv .= "\"".$table[$i]['2_ex']."\",";
        $csv .= "\"".$table[$i]['2_inc']."\",";
        }
        if($pricebook_cate == trim($govt) || $isAdmin){

        $csv .= "\"".$table[$i]['3_ex']."\",";
        $csv .= "\"".$table[$i]['3_inc']."\",";

        }
        if($pricebook_cate == trim($wholesale1) || $isAdmin){

        $csv .= "\"".$table[$i]['4_ex']."\",";
        $csv .= "\"".$table[$i]['4_inc']."\",";

        }
        if($pricebook_cate == trim($wholesale2) || $isAdmin){

        $csv .= "\"".$table[$i]['5_ex']."\",";
        $csv .= "\"".$table[$i]['5_inc']."\",";

        }
        if($pricebook_cate == trim($comm) || $isAdmin){

        $csv .= "\"".$table[$i]['6_ex']."\",";
        $csv .= "\"".$table[$i]['6_inc']."\",";

        }
        if($pricebook_cate == trim($int_vision) || $isAdmin){

        $csv .= "\"".$table[$i]['7_ex']."\",";
        $csv .= "\"".$table[$i]['7_inc']."\",";

        }

        $csv .= "\"".$table[$i]['8_inc']."\"\n";

        

}
        
for ( $j = 0 ; $j < count ( $access_table ); $j++ ){
    
        if($j == 0){
            $csv .= "Accessories";
        }

        if($name == $projector||$name == $whiteboard){

        $csv .= ",".$access_table[$j]['code'].",,,";

        }
        else{

        $csv .= ",".$access_table[$j]['code'].",";

        }

        

        if($name == $display){

        $csv .= $access_table[$j]['color'].",";
        $csv .= ",";

        }
        if($name == $lcd){

        $csv .= ",,";

        }

        $csv .= "\"" . str_ireplace ( "\"" , "''" , $access_table[$j]['description'] ) . "\",";
        $csv .= ",";

        if($pricebook_cate == trim($distributor)|| $isAdmin){

        $csv .= "\"".$access_table[$j]['0_ex']."\",";
        $csv .= "\"".$access_table[$j]['0_inc']."\",";

        }
        if($pricebook_cate == trim($key_partner) || $isAdmin){

        $csv .= "\"".$access_table[$j]['1_ex']."\",";
        $csv .= "\"".$access_table[$j]['1_inc']."\",";

        }
        if($pricebook_cate == trim($pro_av) || $isAdmin){

        $csv .= "\"".$access_table[$j]['2_ex']."\",";
        $csv .= "\"".$access_table[$j]['2_inc']."\",";

        }
        if($pricebook_cate == trim($govt) || $isAdmin){

        $csv .= "\"".$access_table[$j]['3_ex']."\",";
        $csv .= "\"".$access_table[$j]['3_inc']."\",";

        }
        if($pricebook_cate == trim($wholesale1) || $isAdmin){

        $csv .= "\"".$access_table[$j]['4_ex']."\",";
        $csv .= "\"".$access_table[$j]['4_inc']."\",";

        }
        if($pricebook_cate == trim($wholesale2) || $isAdmin){

        $csv .= "\"".$access_table[$j]['5_ex']."\",";
        $csv .= "\"".$access_table[$j]['5_inc']."\",";

        }
        if($pricebook_cate == trim($comm) || $isAdmin){

        $csv .= "\"".$access_table[$j]['6_ex']."\",";
        $csv .= "\"".$access_table[$j]['6_inc']."\",";

        }
        if($pricebook_cate == trim($int_vision) || $isAdmin){

        $csv .= "\"".$access_table[$j]['7_ex']."\",";
        $csv .= "\"".$access_table[$j]['7_inc']."\",";

        }

        $csv .= "\"".$access_table[$j]['8_inc']."\"\n";
   
    


}
echo $csv;
?>
