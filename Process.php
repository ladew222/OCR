<?php
$dir=$_GET['subject'];
$dir='/var/www/html/OCR/Origs/';
$files = scandir($dir);
$x=0;
$arr = array();
foreach($files as $file) {
  //do your work here
 $parts = explode(".", $file);
 if (strtoupper(end($parts)) == "JPG") {
  $sub_arr = array();
  $obj = (object) array('rank' => $file, 'content' =>  basename($file,".JPG"),'UID' => $x);
  array_push($arr,$obj);
  $x++;

 }
	
}
echo json_encode($arr);

?>
