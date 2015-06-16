#!/bin/bash
DIRECTORY=/var/www/html/OCR/Out




FILES=/var/www/html/OCR/Tif/*.tif
x=1;
for f in $FILES
do
echo "aaa"
if [[ $FILES == *"q"* ]]
 then
   x=$((x+1))
   s=${f##*/}
   t=${s%%.*}
   u=".tif"
   v=$t$u
   convert $f  -deskew 40  /var/www/html/OCR/NoLines/$v
   echo "convert  $f  /var/www/html/OCR/NoLines/$v"
   sleep 1
 fi



done
echo $x

