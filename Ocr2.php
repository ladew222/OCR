<?php

$c=$_GET['page'];
$sub=$_GET['subdir'];
$html="";
$mysqli = new mysqli('localhost', 'root', 'gopre222', 'people');
//echo ("aa");
$result = $mysqli->query("SELECT * FROM item where page_num=" . $c);
$x=0;
//echo(" start:" . "SELECT * FROM item where page_num=" . $c );
while ((($row = $result->fetch_assoc()) !== null)  && $x<45  ) {
    $output = array();


    $x++;
    $file="/var/www/html/OCR/Tif/" . $sub . "/".  $row["page_name"]  . "_". $row["rec_type"]  . "_" .  $row["page_num"] . "_" .  $row["col_origin"] ."_" . $row["row_origin"] .".tif";
   // echo($file);

    $path_parts = pathinfo($file);
    $shf= $path_parts['filename'];

   // echo ("new file:". $shf);

    $without= "/var/www/html/OCR/Text/" . $row["page_letter"] . "/" . $shf;

    if ($row["rec_type"]=="q") {
        $lastline = exec("tesseract " .$file  . " " . $without . " nobatch smdigits");

    }
    else{
        $lastline = exec("tesseract " .$file  . " " . $without);
    }


    //echo "<BR><B>:::::</B><BR>" . "tesseract " .$file  . " " . $without;
    $html.= ("<BR>" . $row['ID']. " <BR> ::" . "tesseract " .$file  . " " . $without );
    $filetxt = mysql_escape_string (nl2br(file_get_contents($file )));

   // echo implode(', ', $output) . PHP_EOL;
}

$obj = (object) array('count' => $x, 'html' =>  $html);
echo json_encode($obj);

?>

