#!/bin/bash


echo -e "Please select SubDir: \c "
read  subdir

FILES=/var/www/html/OCR/Unprocessed/$subdir/*
for f in $FILES
do
  
  # take action on each file. $f store current file name
  
  
  s=${f##*/}
  t=${s%%.*}
  u=".png"
  uu=".mvg"
  uuu="_canny.png"
  uuuu="_lines.png"
  uuuuu=".JPG"
  v=$t$u
  w=$t$uu
  x=$t$uuu
  y=$t$uuuu
  z=$t$uuuuu


  echo "Processing $f To $t .."
  echo "Creating $x"
  echo "And $y"
  #c = $nf$ext
 convert $f -rotate "90>" \( +clone -canny 0x1+10%+40%  -rotate "90>" -write /var/www/html/OCR/Preview/$subdir/$x -background none -fill red -stroke red -strokewidth 2 -hough-lines 119x119+290 -write /var/www/html/OCR/Preview/$subdir/$y \) -composite /var/www/html/OCR/Preview/$subdir/$v

convert $f  -rotate "90>" -canny 0x1+10%+40% -hough-lines 119x119+290 /var/www/html/OCR/Origs/$subdir/$w

convert $f  -rotate "90>" -colorspace Gray /var/www/html/OCR/Origs/$subdir/$z
##prep for ocr
done

