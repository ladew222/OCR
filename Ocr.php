<?php


// teseract /var/www/html/OCR/Out/p_0_0_0.tif p_0_0_0
$fn=$_GET['file'];
$c=$_GET['page'];
$dir='/var/www/html/OCR/Final/*_[pq]_' .$c . '*.tif';
	// Open a known directory, and proceed to read its contents
	$x=0;
	echo $dir; 
	foreach(glob($dir) as $file) 
	{
		$withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file);
		//echo "filename: $file : filetype: " . $withoutExt  . "<br />";
		
		if (strpos($a,'_1.tif') !== false) {
   			$lastline = exec("tesseract " .$file  . " " . $withoutExt . "nobatch smdigits");
		}
		else{
		       $lastline = exec("tesseract " .$file  . " " . $withoutExt);
		}
		
		$x++;
	}
	
	$obj = (object) array('count' => $x, 'html' =>  "Created $x files");
	echo json_encode($obj);
?>
