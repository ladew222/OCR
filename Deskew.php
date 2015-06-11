<?php
//first remove lines


// teseract /var/www/html/OCR/Out/p_0_0_0.tif p_0_0_0
$fn=$_GET['file'];
$c=$_GET['page'];
$x= exec("sh /var/www/html/OCR/DeskewAll.sh");
$obj = (object) array('count' => $x, 'html' =>  "NA");
echo json_encode($obj);
