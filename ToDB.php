<?php

$fn=$_GET['file'];
$c=$_GET['page'];
$servername = "localhost";
$username = "root";
$password = "gopre222";
$dbname = "people";
$html="";

$dir='/var/www/html/OCR/Out/[pq]_' .$c . '*.txt';
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
	//echo $dir;
	foreach(glob($dir) as $file) 
	{
		$filen = basename($file);         // $file is set to "index.php"
		$filename = basename($path, ".txt"); // $file is set to "index"	
		
		$ff="./Out". "/". $filen;
		$file_text = mysql_escape_string(file_get_contents("$ff", true ));
		$pieces = explode("_", $file);
		$row = intval($pieces[2]); // record
		$col = intval($pieces[3]); // field
		  
		//$echo "row: $row";
		if (($row < 15 ) && ($col < 18 ) ){
			$records[$row][$col] =$file_text;
			//echo "<BR>Adding Rows: " . $row . "::" . $col;
			//echo "data" . ": " . $file_text . "<br>";
		}
		else{
		   $html.=  "Invalid RowCol: $row::$col";
		   $html.=  "File Was: $filename ";		
		}
		$x++;
		//echo "$file $x ";

	}

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	$x=0;

	foreach ($records as $value) {
		$sql = "INSERT INTO people (page, alpha, address, amt, secured,row) VALUES ('$c', 'A', '$value[0]','$value[1]', '$value[2]','$x')";
		$x++;
		//echo $sql; 
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
