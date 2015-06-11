#!/bin/bash
DIRECTORY=/var/www/html/OCR/Out


x=1
for i in $DIRECTORY/*_q_*.tif; do
    # Process $i
	#echo "converting $i to "
	#echo "$i" | tr  q p
	x=$((x+1))
    convert $i -morphology close:1 "1x9:0,1,1,1,1,1,1,1,0" "$i" | tr  q p
done
echo $x

