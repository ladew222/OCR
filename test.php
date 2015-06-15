<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);

class MyLine
{
  public $x_start=0;
  public $y_start=0;
  public $x_end=0;
  public $y_end=0;

  function __construct($x1,$y1,$x2,$y2) {
     // Statements here run every time
     // an instance of the class
     // is created.
        $this->x_start=$x1;
         $this->y_start=$y1;
         $this->x_end=$x2;
         $this->y_end=$y2;
       // print("set y to" . $y_start. "<BR>");
  }
  function is_horiz() {
     return($x_start==0);
  }
  function slope() {
   $sl= ($y_end - $y_start)/($x_end -$x_start);
     return($sl);
  }
  function sort_objects_by_x($a, $b) {
         if($a->x_start == $b->x_start){ return 0 ; }
         return ($a->x_start  < $b->x_start ) ? -1 : 1;

  }

  /* This is the static comparing function: */
      static function cmp_obj($a, $b)
      {
                  if($a->x_start == $b->x_start){ return 0 ; }
                  return ($a->x_start  < $b->x_start ) ? -1 : 1;
      }



}


function find_intercept($l1,$l2){

        $A1 = $l1->y_end - $l1->y_start; //y2-y1
        $B1 = $l1->x_start - $l1->x_end;  //x1-x2
        $C1 =  $A1 * $l1->x_start +  $B1 * $l1->y_start; //A*x1+B*y1

        echo "A1:" . $A1 . "<BR>";
        echo "B1:" . $B1 . "<BR>";
        echo "C1:" . $C1 . "<BR>";

        $A2 = $l2->y_end - $l2->y_start; //y2-y1
        $B2 = $l2->x_start - $l2->x_end;  //x1-x2
        $C2 =  $A2 * $l2->x_start +  $B2 * $l2->y_start; //A*x1+B*y1

         echo "A2:" . $A2 . "<BR>";
         echo "B2:" . $B2 . "<BR>";
         echo "C2:" . $C2 . "<BR>";

        $det = $A1*$B2 - $A2*$B1;

        echo "<BR>DEt:" . $det . "<BR>";
            if($det == 0){
                //Lines are parallel
                        $x=0;
                        $y=0;
            }else{
                $x = ($B2*$C1 - $B1*$C2)/$det;
                $y = ($A1*$C2 - $A2*$C1)/$det;
            }
                $res = array(
                    "x" => $x,
                    "y" => $y,
                );

                return $res;
}
echo ("start");
//line 0,577.354 1944,543.422  # 641
//line 1163.91,0 1209.15,2592  # 299

//$l1= new MyLine(0,577,1944,543);
//$l2= new MyLine(1163,0,1209,2592);



$l1= new MyLine(0,326,1944,326);
$l2= new MyLine(247,0,290,2983);



$aa= find_intercept($l1,$l2);
print_r($aa);
echo "AAAA" . $aa["x"];
?>
