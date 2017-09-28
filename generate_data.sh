#!/bin/bash

if [ $# -eq 0 ];
then
    echo "arg1 = number of products";
    exit;
fi

echo -ne "" > data.txt

desc="some random words";
img="https://www.shareicon.net/data/128x128/2015/10/04/111737_odnoklassniki_512x512.png"

for ((i=0; i<$1; ++i));
do
    name=$(curl "http://setgetgo.com/randomword/get.php");
    point=$RANDOM
    let "point %= 100"
    price="${RANDOM}.$point";
    echo -ne "0\t"$name"\t"$desc"\t"$price"\t"$img"\n" >> data.txt;
done
