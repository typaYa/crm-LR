<?php
// что ищем
$phone = '79057648883';

$str1 = substr($phone, 1, 3);
$str2 = substr($phone, 4, 10);
$fh = fopen ( 'app/controllers/find-city-by-phone/DEF-9xx.csv', 'r' );
while ( ( $info = fgetcsv ($fh, 1000, ";") ) !== false )
{
    if (!strcasecmp($info[0], $str1) && ($info[1] <= $str2) && ($str2 <= $info[2])) {
        $city_by_csv = $info[6];
    }
}
if(!count($city_by_csv))
    $city_by_tel = 'not defined';
else
{
    $city_by_tel = $city_by_csv;
}
// закрываем файл
fclose ( $fh );
