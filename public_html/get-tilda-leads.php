<?php
$site = 'tilda';//помечаем источник вручную
$source = 'tilda';//помечаем источник вручную
$oldphone = !empty($_POST['phone']) ? $_POST['phone'] : '';//записываем поле телефон из пост запроса во временную переменную
$phone = preg_replace('/[^0-9,.]+/', '', $oldphone);// чистим телефон от лишних символов, записываем в переменную для отправки в БД

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

if(empty($_POST['message'])){$message = 'no message';}//если в пост запросе пусто записываем ноу мессэдж в переменную
else {$message = $_POST['message'];}//записываем поле сообщение из пост запроса во временную переменную
$utm_source = !empty($_POST['utm_source']) ? $_POST['utm_source'] : 'not defined';
$utm_campaign = !empty($_POST['utm_campaign']) ? $_POST['utm_campaign'] : 'not defined';
$utm_term = !empty($_POST['utm_term']) ? $_POST['utm_term'] : 'not defined';
$client_ip = !empty($_POST['client_ip']) ? $_POST['client_ip'] : 'not defined';



$ch = curl_init('http://ip-api.com/json/' . $client_ip . '?lang=ru');// по ip клиента определяем город
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$res = curl_exec($ch);
curl_close($ch);
$res = json_decode($res, true);
$date = date('m/d/Y h:i:s a', time());
if(filter_var($client_ip, FILTER_VALIDATE_IP) !== false) {// проверяем значение client_ip соответствует ли оно формату ip адреса
    $city_by_ip = $res['city'];// если да да, берем город и записываем в БД
} else {
    $city_by_ip = 'not defined';// если нет пишем не определено
}
$link = mysqli_connect("localhost", "cw92548_crmtest", "ndXBT6CS", "cw92548_crmtest");
$sql = mysqli_query($link, "INSERT INTO `leads` (`name`, `phone`, `message`, `source`, `utm_source`, `utm_campaign`, `utm_term`, `client_ip`, `city_by_ip`, `city_by_tel`,`status`) VALUES ('{$_POST['name']}', '{$phone}', '{$message}', '{$source}', '{$utm_source}', '{$utm_campaign}', '{$utm_term}', '{$client_ip}', '$city_by_ip', '{$city_by_tel}','Не обработано')");
