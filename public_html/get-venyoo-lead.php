<?php
//header('Access-Control-Allow-Origin: *');
//$headers = "From: webhook@crm.leadrain.ru";
//$message = print_r($_POST,true);
//@mail('info@leadrain.ru', 'Новый вебхук!', $message, $headers);
//echo"ok";

$source = 'venyoo';
$oldphone = !empty($_POST['phone']) ? $_POST['phone'] : '';
$phone = preg_replace('/[^0-9,.]+/', '', $oldphone);
if (empty($_POST['question'])) {
    $message = 'no message';
} else {
    $message = $_POST['question'];
}
if (empty($_POST['utm_source'])) {
    $utm_source = 'not defined';
} else {
    $utm_source = $_POST['utm_source'];
}
if (empty($_POST['utm_campaign'])) {
    $utm_campaign = 'not defined';
} else {
    $utm_campaign = $_POST['utm_campaign'];
}
if (empty($_POST['utm_term'])) {
    $utm_term = 'not defined';
} else {
    $utm_term = $_POST['utm_term'];
}
if (empty($_POST['client_ip'])) {
    $client_ip = 'not defined';
} else {
    $client_ip = $_POST['client_ip'];
}
$ch = curl_init('http://ip-api.com/json/' . $client_ip . '?lang=ru');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$res = curl_exec($ch);
curl_close($ch);
$date = date('m/d/Y h:i:s a', time());
$res = json_decode($res, true);
$city_by_ip = $res['city'];
$link = mysqli_connect("localhost", "cw92548_crmtest", "ndXBT6CS", "cw92548_crmtest");
$sql = mysqli_query($link, "INSERT INTO `leads` (`name`, `phone`, `message`, `source`, `utm_source`, `utm_campaign`, `utm_term`, `client_ip`, `city_by_ip`) VALUES ('{$_POST['first_last_name']}', '{$phone}', '{$message}', '{$source}', '{$utm_source}', '{$utm_campaign}', '{$utm_term}', '{$client_ip}', '{$city_by_ip}')");
$sql = mysqli_query($link, "INSERT INTO `applications` (`name`, `phone`,  `date`,`message`, `sourse`) VALUES ('{$_POST['first_last_name']}', '{$phone}','$date', '{$message}', '{$source}')");

