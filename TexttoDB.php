<?php

$fn=$_GET['file'];
$c=$_GET['page'];
$servername = "localhost";
$username = "root";
$password = "gopre222";
$dbname = "people";
$html="";

$dir='/var/www/html/OCR/Final/*_p_' .$c . '*.txt';
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
		$filetxt = mysql_escape_string (nl2br(file_get_contents($filename )));
		$pieces = explode("_", $file);
		$row = intval($pieces[3]); // record
		$col = intval($pieces[4]); // field
		$orfn = $pieces[1]; // field
		print_r($pieces);
		echo ( "<BR> <BR><BR>");
		if (($row <9 ) && ($col <9 ) ){
			$records[$row][$col]=$filetxt;
			echo("setting $row :: col  $col  <Br>"); 
			
			

		}
		else{
		   $html.=  "Invalid RowCol:$row :: $col";		
		}
		

	}

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	$x=0;
	$pn="";
	foreach ($records as $value) {
		$sql = "INSERT INTO people (page, alpha, address, amt, secured,pname);
	VALUES ('$x', 'A', '$value[0]','$value[1]''$value[2]',$pn)";
		$x++;
		if ($conn->query($sql) === TRUE) {
	    	//
		} else {
		    $html.= "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	
	

	$conn->close();

	echo ("dfasdfsd");
	$obj = (object) array('count' => $x, 'html' =>  "$html");
	echo json_encode($obj);
?>
