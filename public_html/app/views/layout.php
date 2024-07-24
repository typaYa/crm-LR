<!doctype html>
<html>
<head>
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">CRM LEADRAIN</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=users">Пользователи</a>
                </li>
                <?php if(!isset($_SESSION['user_role'])){?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=register">Регистрация</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=login">Вход</a>
                </li>

                <?php }
                else{?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=applications">Обращения</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=logout">Выход</a>
                    </li>
                <?php }?>


            </ul>
        </div>
    </nav>
    <div class="container mt-4">
        <?php echo $content; ?>
    </div>
</div>

</body>
</html>