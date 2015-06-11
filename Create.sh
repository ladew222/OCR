#!/bin/bash
FILES=/var/www/html/OCR/Unprocessed/*
for f in $FILES
do
  
  # take action on each file. $f store current file name
  
  
  s=${f##*/}
  t=${s%%.*}
  u="_prev.png"
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
 convert $f \( +clone -canny 0x1+10%+40% -write /var/www/html/OCR/Preview/$x -background none -fill red -stroke red -strokewidth 2 -hough-lines 119x119+290 -write /var/www/html/OCR/Preview/$y \) -composite /var/www/html/OCR/Preview/$v

convert $f  -canny 0x1+10%+40% -hough-lines 119x119+290 /var/www/html/OCR/Origs/$w

convert $f  -rotate "-90>" -colorspace Gray -deskew 40 /var/www/html/OCR/Origs/$z
##prep for ocr
done

