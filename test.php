<?php

/*
      Work backward. Start from the zip code, which will be near the end, and in one of two known formats: XXXXX or XXXXX-XXXX. If this doesn't appear, you can assume you're in the city, state portion, below.
      The next thing, before the zip, is going to be the state, and it'll be either in a two-letter format, or as words. You know what these will be, too -- there's only 50 of them. Also, you could soundex the words to help compensate for spelling errors.
      before that is the city, and it's probably on the same line as the state. You could use a zip-code database to check the city and state based on the zip, or at least use it as a BS detector.
      The street address will generally be one or two lines. The second line will generally be the suite number if there is one, but it could also be a PO box.
      It's going to be near-impossible to detect a name on the first or second line, though if it's not prefixed with a number (or if it's prefixed with an "attn:" or "attention to:" it could give you a hint as to whether it's a name or an address line.
*/



function str_to_address2($context) {
    $array = explode("\n", $context);
    $array_reversed = array_reverse($array);
   // print_r($array_reversed);
    $numKey = "";
    $zipKey = "";
    $foundziplinE ="";
    $newstr="";
    $x=0;
  //  echo('gfgf');
    foreach($array_reversed as $k=>$str) {
        $xx=0;
     //   echo('Looking at Line:');
    //      echo($x);
   //       echo('<BR>');
        $array2 = explode(" ",$str);
        $pos = strpos($str, "/");
        foreach($array2 as $k=>$str2) {
           //  echo('bb--<div style="color:blue">');
          //    echo($str2);
          //    echo("</div>");
            if ($zipKey) {
                continue;
            }
            if (strlen($str2) === 5 && is_numeric($str2) && $pos == 0) {
                echo("Found:");
                $zipKey = $k;
                //found zip
                $foundzipline = $x;
                echo('Looking at Line:');
                         echo($x);
                         echo(":::");
                         echo($str2);
                         echo("<BR>");
                $arr = array(
                     trim($array_reversed[$x+3]),
                     trim($array_reversed[$x+2]),
                     trim($array_reversed[$x+1]),
                    trim( $array_reversed[$x+0])
                );
                $y=0;
                $fline="";
                foreach ($arr as &$value) {
               // echo strlen("Hello world!");
                   if (strlen($value)>7){
                         echo(" <div style='color:pink' >found line at: "  . $y . "::" . strlen($value) . "::". $value . "</div>");
                        if(!($fline)){
                            $fline=$yy;

                        }
                        $y++;
                    }
                    $yy++;
                }
                if ($y<3){

                   echo ("Split at:" . $arr[$fline]);
                }


                $newstr= "<BR>1:".   $array_reversed[$x+3] . "2:". "<BR>". $array_reversed[$x+2] ."<BR>3:". $array_reversed[$x+1] . "<BR>" ."4:". $array_reversed[$x];
                echo("<BR><div style='color:green'>" .$newstr ."</div><BR>");
                print_r($array_reversed);
                $xx++;
            }
            $xx++;
        }
     $x++;
    }
    $array_reversed = array_slice($array_reversed, $zipKey);
    $array = array_reverse($array_reversed);
    foreach($array as $k=>$str) {
        if($numKey) { continue; }
        if(strlen($str)>1 && strlen($str)<6 && is_numeric($str)) {
            $numKey = $k;
        }

    }
    $array = array_slice($array, $numKey);
    $string = implode(' ', $array);
    return $string;
}


$con=mysqli_connect("localhost","root","gopre222","people");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

// Perform queries
$result=mysqli_query($con,"SELECT text FROM item where ID=6988");

$row = mysql_fetch_assoc($result); // fetch a result row
print_r($row);
//echo $row['text']; // output one of the result row's data fields.
//echo("---");






$link = mysqli_connect("localhost", "root", "gopre222", "people");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$query = "SELECT text FROM item where col_origin=0";

if ($result = mysqli_query($link, $query)) {

    /* fetch associative array */
    $x=0;
    while ($row = mysqli_fetch_assoc($result)) {
        //printf ("%s (%s)\n", $row["text"], $row["text"]);
        echo("<div style='color:brown'> processing row:" .$x . ":val:". $row["text"] ."::</div>");
        echo(str_to_address2($row["text"]));

    $x++;
    }

    /* free result set */
    mysqli_free_result($result);
}

/* close connection */
mysqli_close($link);


?>
