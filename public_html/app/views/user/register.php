<?php
//https://youtu.be/wPPpQEbFd3w?list=PL7Lf7uq4tiNBe332vuAYzniId5AI6fDSX&t=3626

$title = 'Регистрация';
ob_start();
?>
    <div class="row justify-content-center mt-S">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <h1 class="text-center mb-4">Регистрация</h1>
            <form method="POST" action="index.php?page=auth&action=store">
                 <div class="mb—3">
                    <label for="username" class="form-label">Имя пользователя</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb—3">
                    <label for="email" class="form-label">Логин</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb—3">
                    <label for="password" class="form-1abe1">Пароль</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Подтверждение пароля</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <?php
                if (isset($_GET['error'])) {
                    echo '<p style="color: red;">' . htmlspecialchars($_GET['error']) . '</p>';
                }
                ?>
                <button type="submit" class="btn btn-primary">Регистрация</button>
            </form>

        </div>
    </div>

<?php $content = ob_get_clean();
include 'app/views/layout.php';
?>