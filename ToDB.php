<?php

$c=$_GET['page'];
$sub=$_GET['subdir'];
$html="";
$mysqli = new mysqli('localhost', 'root', 'gopre222', 'people');
//echo ("aa");
$result = $mysqli->query("SELECT * FROM item where page_num=" . $c);
$x=0;
//echo(" start:" . "SELECT * FROM item where page_num=" . $c );
while ((($row = $result->fetch_assoc()) !== null)  ) {

    $file="/var/www/html/OCR/Text/" . $sub .  "/" . $row["page_name"]  . "_". $row["rec_type"]  . "_" .  $row["page_num"] . "_" .  $row["col_origin"] ."_" . $row["row_origin"] .".txt";
     //echo($file);
    $file_text = mysql_escape_string(file_get_contents("$file", true ));
    $sql = "INSERT INTO people (text) VALUES ('$c', 'A', '$value[0]','$value[1]', '$value[2]','$x')";
    $id = $row["ID"];
    $sql= "UPDATE item SET text ='$file_text' WHERE ID=$id";
    //echo("Q: $sql");

    $mysqli2 = new mysqli('localhost', 'root', 'gopre222', 'people');
   // echo ("aa");
    $result2 = $mysqli2->query($sql);
    $x++;
   // echo ("<BR>------NEXT-----<BR>" );
}

$obj = (object) array('count' => $x, 'html' =>  $html);
echo json_encode($obj);

?>
