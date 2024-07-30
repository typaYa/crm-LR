<?php
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
    <div class="row justify-content-center mt-5">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <h1 class="text-center mb-4">Вход</h1>
            <form method="POST" action="index.php?page=auth&action=authenticate">
                <div class="mb-3">
                    <label for="email" class="form-label"> Логин </label>
                    <input type="text" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <?php
                if (isset($_GET['error'])) {
                    echo '<p style="color: red;">' . htmlspecialchars($_GET['error']) . '</p>';
                }
                ?>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Запомнить меня</label>
                </div>
                <button type="submit" class="btn btn-primary">Войти</button>
            </form>


        </div>
    </div>
<?php $content = ob_get_clean();
include 'app/views/layout.php';
?>