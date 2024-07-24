<?php
if (isset($_GET['zd_echo'])) exit($_GET['zd_echo']);
$name = 'no name';
$source = !empty($_POST['called_did']) ? $_POST['called_did'] : '';
$oldphone = !empty($_POST['caller_id']) ? $_POST['caller_id'] : '';
$phone = preg_replace('/[^0-9,.]+/', '', $oldphone);
if(empty($_POST['message'])){
    $message = 'входящий звонок';
}
else {
    $message = $_POST['message'];
}
if (empty($_POST['utm_source'])) {
    $utm_source = 'not defined';
}
else {
    $utm_source = $_POST['utm_source'];
}
if( empty($_POST['utm_campaign'])) {
    $utm_campaign = 'not defined';
}
else {
    $utm_campaign = $_POST['utm_campaign'];
}
if(empty($_POST['utm_term'])){
    $utm_term = 'not defined';
}
else {
    $utm_term = $_POST['utm_term'];
}
$date = date('m/d/Y h:i:s a', time());
$link = mysqli_connect("localhost", "cw92548_crmtest", "ndXBT6CS", "cw92548_crmtest");
$sql = mysqli_query($link, "INSERT INTO `leads` (`name`, `phone`, `message`, `source`, `utm_source`, `utm_campaign`, `utm_term`) VALUES ('{$name}', '{$phone}', '{$message}', '{$source}', '{$utm_source}', '{$utm_campaign}', '{$utm_term}')");
$sql = mysqli_query($link, "INSERT INTO `applications` (`name`, `phone`,  `date`,`message`, `sourse`) VALUES ('{$_POST['first_last_name']}', '{$phone}','$date', '{$message}', '{$source}')");
