<?php

$c=$_GET['page'];

$html="";
$mysqli = new mysqli('localhost', 'root', 'gopre222', 'people');

$result = $mysqli->query("SELECT * FROM item where row_origin=" . $c);
$x=0;
//echo(" start" . "SELECT * FROM item where id=" . $c );
while ((($row = $result->fetch_assoc()) !== null)  && $x<45  ) {
    $output = array();
    foreach ($row as $columnName => $columnValue) {
      //  $output[] = $columnName . ' => ' . $columnValue;



        $x++;
        $file="/var/www/html/OCR/Final/" . $row["page_name"]  . "_". $row["rec_type"]  . "_" .  $row["page_num"] . "_" .  $row["col_origin"] ."_" . $row["row_origin"] .".tif";
       // echo($file);

        $path_parts = pathinfo($file);
        $shf= $path_parts['filename'];

       $without= "/var/www/html/OCR/Final/" . $shf;

        if ($row["rec_type"]=="q") {
            $lastline = exec("tesseract " .$file  . " " . $without . "nobatch smdigits");

        }
        else{
            $lastline = exec("tesseract " .$file  . " " . $without);
        }
       // echo $lastline;
      $html.= ("<BR>" . $row['ID']. " <BR> ::" . "tesseract " .$file  . " " . $without );
        $filetxt = mysql_escape_string (nl2br(file_get_contents($file )));

       // $sql = "UPDATE item SET text='$filetxt' WHERE id=" .$row["ID"];
      //  $result2 = $mysqli->query($sql);
       // $html.="<BR>$sql<Br>";


    }
   // echo implode(', ', $output) . PHP_EOL;
}

$obj = (object) array('count' => $x, 'html' =>  $html);
echo json_encode($obj);

?>

