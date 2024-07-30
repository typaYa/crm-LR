<?php
error_reporting(E_ALL);

date_default_timezone_set("Europe/Volgograd");

$key = "E95E4A5F737059DC60DF5991D45029409E60FC09";
$iss = "http://crm-LR";
$aud = "http://crm-LR";
$nbf = time();
$iat = $nbf;
$jti = uniqid();
$exp = $nbf+60*70*24*7;
$token =[
  'iss'=>$iss,
  'aud'=>$aud,
  'nbf'=>$nbf,
  'iat'=>$iat,
  'data'=>[
    ""
  ],
];