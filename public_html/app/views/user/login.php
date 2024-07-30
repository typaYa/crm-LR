<?php
//https://youtu.be/WJoih6XeqTM?t=2083
$title = 'Authorization';
ob_start();
?>
    <div class="row justify-content-center mt-5">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <h1 class="text-center mb-4">Авторизация</h1>
            <form method="POST" action="index.php?page=auth&action=authenticate">
                <div class="mb-3">
                    <label for="email" class="form-label"> Логин</label>
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