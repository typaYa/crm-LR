<?php
$db_host=''; // ваш хост
$db_name=''; // ваша бд
$db_user=''; // пользователь бд
$db_pass=''; // пароль к бд
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
    $data[] = $row;
}

?>