<?php

$fn=$_GET['file'];
$c=$_GET['page'];
$servername = "localhost";
$username = "ladew222";
$password = "gopre222";
$dbname = "PTL";
$html="";

$dir='/var/www/html/OCR/Out/p_' .$c . '*.txt';
	// Open a known directory, and proceed to read its contents
	$x=0;
	//echo $dir;
	$records = array
	  (
	  array("null","null","null"),
	  array("null","null","null"),
	  array("null","null","null"),
	  array("null","null","null"),
	  array("null","null","null"),
	  array("null","null","null"),
	  array("null","null","null"),
	  array("null","null","null")
	  );
	foreach(glob($dir) as $file) 
	{
		$filen = basename($file);         // $file is set to "index.php"
		$filename = basename($path, ".txt"); // $file is set to "index"	
		$x++;
		$file = nl2br(file_get_contents($filename ));
		$pieces = explode(" ", $file);
		$row = $pieces[2]; // record
		$col = $pieces[3]; // field
		if (is_int($row) && is_int($col) && ($row <4 ) && ($col <4 ) ){
			$records[$row][$col]
		}
		else{
		   $html.=  "Invalid RowCol:$row :: $col"		
		}
		

	}

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	$x=0;
	foreach ($records as $value) {
		$sql = "INSERT INTO people (page, alpha, address, amt, secured);
	VALUES ('$x', 'A', '$value[0]','$value[1]''$value[2]')";
		$x++;
		if ($conn->query($sql) === TRUE) {
	    	//
		} else {
		    $html.= "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	
	

	$conn->close();

	
	$obj = (object) array('count' => $x, 'html' =>  "$html");
	echo json_encode($obj);
?>
