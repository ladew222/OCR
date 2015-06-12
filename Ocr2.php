<?php





$mysqli = new mysqli('localhost', 'root', 'gopre222', 'people');

$result = $mysqli->query("SELECT * FROM item");
$x=0;
while ((($row = $result->fetch_assoc()) !== null)  && x<45  ) {
    $output = array();
    foreach ($row as $columnName => $columnValue) {
      //  $output[] = $columnName . ' => ' . $columnValue;



        $x++;
        $file="/var/www/html/OCR/Final/" . $row["page_name"]  . "_". $row["rec_type"]  . "_" .  $row["page_num"] . "_" .  $row["row_origin"] ."_" . $row["col_origin"] .".tif";
        //echo($file);

       $witoutExt= basename($file, '.tif');

        if ($row["rec_type"]=="q") {
            $lastline = exec("tesseract " .$file  . " " . $withoutExt . "nobatch smdigits");

        }
        else{
            $lastline = exec("tesseract " .$file  . " " . $withoutExt);
        }
       // echo $lastline;
        echo ("<BR><BR> ::" . "tesseract " .$file  . " " . "/var/www/html/OCR/Final/". $row["page_name"]  );
        $filetxt = mysql_escape_string (nl2br(file_get_contents($file )));

        $sql = "UPDATE item SET text='$filetxt' WHERE id=" .$row["ID"];


    }
   // echo implode(', ', $output) . PHP_EOL;
}



?>

