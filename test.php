<?php

/*
      Work backward. Start from the zip code, which will be near the end, and in one of two known formats: XXXXX or XXXXX-XXXX. If this doesn't appear, you can assume you're in the city, state portion, below.
      The next thing, before the zip, is going to be the state, and it'll be either in a two-letter format, or as words. You know what these will be, too -- there's only 50 of them. Also, you could soundex the words to help compensate for spelling errors.
      before that is the city, and it's probably on the same line as the state. You could use a zip-code database to check the city and state based on the zip, or at least use it as a BS detector.
      The street address will generally be one or two lines. The second line will generally be the suite number if there is one, but it could also be a PO box.
      It's going to be near-impossible to detect a name on the first or second line, though if it's not prefixed with a number (or if it's prefixed with an "attn:" or "attention to:" it could give you a hint as to whether it's a name or an address line.
*/


function str_to_address($context) {
    $array = explode(" ", $context);
    $array_reversed = array_reverse($array);
    $numKey = "";
    $zipKey = "";
    foreach($array_reversed as $k=>$str) {
        if($zipKey) { continue; }
        if(strlen($str)===5 && is_numeric($str)) {
            $zipKey = $k;
        }
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


?>
