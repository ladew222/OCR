#!/bin/bash
DIRECTORY=/var/www/html/OCR/Out


x=1
for i in $DIRECTORY/*; do
    # Process $i
	#echo "converting $i to "
	#echo "$i" | tr  q p
	x=$((x+1))
	if [[ $i =~ [q] ]]; then
    echo "$i is a digit"
         convert $i -morphology close:1 "1x7:0,1,1,1,1,1,0" "$i" | tr  q p
    else
        echo "oops"
    fi

done
echo $x

