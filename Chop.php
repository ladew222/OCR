<?php

/*
convert /var/www/html/OCR/Origs/101_4562.JPG \( +clone -canny 0x1+10%+40% -write /var/www/html/OCR/Preview/fence_canny.png -background none -fill red -stroke red -strokewidth 2 -hough-lines 119x119+290 -write fence_lines.png \) -composite /var/www/html/OCR/Preview/101_4562.png

convert /var/www/html/OCR/Origs/101_4561.JPG  -deskew 40 -canny 0x1+10%+40% -hough-lines 119x119+310 /var/www/html/OCR/Origs/d.mvg



*/

$status=0;
$html= "";

class MyLine
{
  public $x_start=0;
  public $y_start=0;
  public $x_end=0;
  public $y_end=0;
  
  function __construct($x1,$y1,$x2,$y2) {
     // Statements here run every time
     // an instance of the class
     // is created.
        $this->x_start=$x1;
         $this->y_start=$y1;
         $this->x_end=$x2;
         $this->y_end=$y2;
       // print("set y to" . $y_start. "<BR>");
  }
  function is_horiz() {
     return($x_start==0);
  }
  function slope() {
   $sl= ($y_end - $y_start)/($x_end -$x_start);
     return($sl);
  }
  function sort_objects_by_x($a, $b) {
         if($a->x_start == $b->x_start){ return 0 ; }
         return ($a->x_start  < $b->x_start ) ? -1 : 1;
         
  }
  
  /* This is the static comparing function: */
      static function cmp_obj($a, $b)
      {
                  if($a->x_start == $b->x_start){ return 0 ; }
                  return ($a->x_start  < $b->x_start ) ? -1 : 1;
      }
 


}


function get_horiz_box($arr_val,$height){
        
    $pairs = array();
        //print_r($arr_val);
     
        $x=0;
        $GLOBALS["html"].= "<BR><h2 style='color:orange'>****Getting Horiz****</h2><BR>";
        foreach ($arr_val as $value) {
                //$html.=("looping:");
                //print_r($value);
                
                if ($x>0  && $value->y_start < ($height -12) ){//start on second line and look at prev skip verts
                        //$html.= "Comparing<BR>" ;
                        //print_r($value);
                        if (($value->y_start - $prev_val->y_start)>130){//create a pair
                                $GLOBALS["html"].= "<b style='color:blue'>Making Pair:</b>";
				$GLOBALS["html"].= print_r($prev_val, true);
                                $GLOBALS["html"].= ("::to::");
                                $GLOBALS["html"].= print_r($prev_val, true);
                                $GLOBALS["html"].=("<br>");
                            array_push($pairs, array($prev_val,$value));
                        }
			else{
			}
                        
                }
                $x++;
                $prev_val = $value;
                
        }
        
        
        //return
        return $pairs;
}

function get_vert_box($arr_val,$height){
        
    $pairs = array();
        //print_r($arr_val);
     	$GLOBALS["html"]="";
        $x=0;
	$tollerance=450;
         $GLOBALS["html"].= "<BR><h2 style='color:orange'>****Getting Vert**</h2><BR>";
        foreach ($arr_val as $value) {
                //$html.=("looping:");
                //print_r($value);
                
                if ($x>0){//start on second line and look at prev skip verts
                        //$html.= "Comparing<BR>" ;
                        //print_r($value);
                        if (($value->x_start - $prev_val->x_start)>$tollerance){//create a pair
                                $GLOBALS["html"].= "<b style='color:blue'>Making Pair:</b>";
                                $GLOBALS["html"].= print_r($value, true);
                                $GLOBALS["html"].= ("::to::");
                                $GLOBALS["html"].= print_r($value, true);
                                $GLOBALS["html"].= ("<br>");
                            array_push($pairs, array($prev_val,$value));
				$tollerance=200;
                        }
                        else{ //find line to eliminate or move left  **not setting
                                if ($prev_val->x_start < $value->x_start){
                                        
                                        $GLOBALS["html"].= ("Changing X of vert to ". $prev_val->x_start);
                                        $GLOBALS["html"].= ("<BR>was:");
					$GLOBALS["html"].= print_r($value, true);
                                        $value->x_start= $prev_val->x_start; //choose the most left line
                                        $GLOBALS["html"].= ("<BR>new obj:");
                                        $GLOBALS["html"].= print_r($value, true);
                                        $GLOBALS["html"].= ("<BR>");

                                }
                                if ($prev_val->x_end < $value->x_end){
                                        $value->x_end= $prev_val->x_end; //choose the most left line

                                }
                        }
                        
                }
                $prev_val = $value;
                $x++;
                
        }
        
        
        //return
        return $pairs;
}



function split_file($file,$page) {
        $arr_lines = array();
        $arr_lines_vert = array();
        $fn_arr = explode(".", $file, 2);
        $fname = $fn_arr[0];
        $html.= "<br>filename:". $fn_arr[0]. "<BR>";
        $data_f= $fname . ".mvg";
        $file_w=0;
        $file_h=0;
	$fname2= basename("$file", ".JPG");
        
        $html.= "about to read".$data_f ."<br>";
        $all_lines = array();
        //read values in
        $handle = fopen($data_f, "r");
        
        if ($handle) {
                $line_num=0;
                $arr_cnt=0;
            while (($line = fgets($handle)) !== false) {
                // process the line read.
                        if($line_num==1){ //set global file vars
                                $line = substr($line, 8);  //remove begining
                                $file_vals = explode(' ', $line);
                                $file_w=$file_vals[2];
                                $file_h=$file_vals[3];
                                $html.= ("file:". $file_h );
                        }
                        
                        if($line_num>1){//put into array
                                //grab firs value
                                //$html.= "Read line $line<BR>";
                                $line = substr($line, 5);  //remove begining
                                $string_arr = explode('#', $line);
                                $string_main = $string_arr[0]; //get before #
                                //$html.=("Coords:".$string_main );
                                $lines_str = explode(' ', $string_main);
                                $starts=  explode(',', $lines_str[0]);
                                //$html.=("---L1:".$lines_str[0] ."---" );
                                //$html.=("---L2:".$lines_str[1] ."---<BR>" );
                                $ends=  explode(',', $lines_str[1]);
                                $x1=$starts[0];
                                $y1=$starts[1];
                                $x2=$ends[0];
                                $y2=$ends[1];
                                //$html.= ("Ind Vals:" .$x1 . "::" . $y1. "<BR>");
                                if($x1>100 || $y1>100){
                                        
                                        $html.= ("adding val");
                                        if($x1>0){// verticals
                                                array_push($arr_lines_vert, new MyLine($x1,$y1,$x2,$y1));
                                        }
                                        else{
                                                array_push($arr_lines, new MyLine($x1,$y1,$x2,$y1));
                                                ///add value
                                        }
                                        
                                        
                                }
                                $arr_cnt++;
                                
                        }
                        $line_num++;
                        
                        
                        
            }
                
                fclose($handle);
        } else {
            // error opening the file.
                $html.=("error opening the file.");
        } 
        $html.= "Done Reading<BR>";
        //print_r($arr);
        //usort($arr_lines, 'sort_objects_by_x');
        //usort($arr_lines, array("MyLine", "cmp_obj"));
        $html.= "Sorted<BR>";
	$html.= print_r($arr_lines, true);
        $html.=("<br>");
        $h_boxes=get_horiz_box($arr_lines,$file_h);
	$html.= $GLOBALS["html"];
        usort($arr_lines_vert, array("MyLine", "cmp_obj")); //not sorted ahead of time
	$html.= print_r($arr_lines_vert, true);
	$html.=print_r($value, true);
        $v_boxes=get_vert_box($arr_lines_vert);
        $html.= $GLOBALS["html"];
        
        $html.= "<h2>Got Vertical</h2>";

	$html.= print_r($v_boxes, true);
        $x=0;
        $xx=0;
        $outdir=" /var/www/html/OCR/Out/";
        $html.= ("<b style='color:green'><BR>Start Creating</b><BR>");
        foreach ($h_boxes as $value) {
                $x=0;
                $html.= "<BR><b style='color:yellow'> Outputing Row" .$x . "</b><BR>";
                foreach ($v_boxes as $value_f) {
                        $html.=("<BR>looking at vert pair");
			$html.= print_r($value_f, true);
                        $html.=("<BR>");
                        
                        
                        
                        $start_x=$value_f[0]->x_start;
                        $start_y=$value[0]->y_start;
                        $width= $value_f[1]->x_start - $value_f[0]->x_start;
                        $height=$value[1]->y_start - $value[0]->y_start;
                        //do adjusting for buffers
                        if($x==1){//amount move left a bit for safety
                                $start_x=$start_x -30;
                                $width=$width+30;
                        }
			//adjust for all
			$height+=50;
			$start_y+=50;


			if($x==0){//add a little height
                                
                              // $height+=12;
                        }
                        

                        $type="p";
                        if($x==1){ //for line removal
							$type="q";
						}
                        $str_crop =  $width . "x" . $height . "+" . $start_x . "+" . $start_y;
                        $new_file = $fname2 ."_". $type . "_" . $page . "_" . $xx . "_" . $x . ".tif"; 
                        $lastline = exec("convert -crop " .$str_crop  . " " .$file . $outdir . $new_file);
                        $html.= "<b style='color:brown'> Outputting Field" .$x . "</b><Br>";
                        $html.= ("Set Crop:". $str_crop);
                        $html.= ("<BR>");
                        $html.= ("creating file:");
                        $html.= ( $new_file);
                        $html.= ("<BR>");
                        $html.= ("convert -crop " .$str_crop  . " " .$file . $outdir . $new_file);
                        $x++; //field count
                        
                }
                $xx++; //rec count
        }
	$retva=0;
     	$obj = (object) array('fields' => $x, 'records' =>  $xx, html => $html);
	return json_encode($obj);
}

$html.= "start";

$sourcedir="/var/www/html/OCR/Origs/";
$outdir=" /var/www/html/OCR/Out/";
if (isset($_GET['file'])) {
  $res= split_file($sourcedir . $_GET['file'] ,$_GET['page']);
  echo($res);
}else{
    // Fallback behaviour goes here
}


