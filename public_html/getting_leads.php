<?php
$db_host='localhost'; // ваш хост
$db_name='cw92548_crmtest'; // ваша бд
$db_user='cw92548_crmtest'; // пользователь бд
$db_pass='ndXBT6CS'; // пароль к бд
// включаем сообщения об ошибках
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// коннект с сервером бд
$db = new mysqli($db_host, $db_user, $db_pass, $db_name); 
// задаем кодировку
$db->set_charset("utf8mb4"); 



$result = $db->query('SELECT * FROM `table_name`'); // запрос на выборку
$data = [];
// получаем все строки в цикле по одной и записываем в массив
while($row = $result->fetch_assoc())
{
  	print_r($row);
    $data[] = $row;
}


?>