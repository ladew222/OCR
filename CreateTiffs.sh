#!/bin/bash
DIRECTORY=/var/www/html/OCR/Out


FILES=/var/www/html/OCR/Out/b/*.jpg
x=1;
for f in $FILES
do
  x=$((x+1))
 s=${f##*/}
  t=${s%%.*}
  u=".tif"
  v=$t$u
 convert $f  -deskew 40  /var/www/html/OCR/Tif/$v
echo "convert  $f  /var/www/html/OCR/Tif/$v"
done
echo $x

