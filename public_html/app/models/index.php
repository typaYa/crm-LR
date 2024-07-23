<?php
include_once "app/models/database.php";
$result = mysqli_query($a, "SELECT * FROM `table_name`"); // запрос на выборку
$a = mysqli_fetch_assoc($result);
print_r($a);
//https://youtu.be/wPPpQEbFd3w?list=PL7Lf7uq4tiNBe332vuAYzniId5AI6fDSX&t=1771
https://youtu.be/xW3PW62fyoM?list=PL7Lf7uq4tiNBe332vuAYzniId5AI6fDSX&t=664
if($_SERVER['REQUEST_URI'] == '/index.php') {
    header('Location: /');
    exit();
}
$title = 'LR-CRM';
ob_start();
?>
    <h1> CRM-LEDRAINE - CRM система для юридических компаний</h1>

<?php $content = ob_get_clean();
include 'app/views/layout.php';
?>