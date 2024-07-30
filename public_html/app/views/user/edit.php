<?php
//https://youtu.be/wPPpQEbFd3w?list=PL7Lf7uq4tiNBe332vuAYzniId5AI6fDSX&t=3626

$title = 'Создание пользователя';
ob_start();
?>
    <h1>Редактирование пользователя</h1>
    <form method="POST" action="index.php?page=users&action=update&id=<?php echo $user['id']; ?>">
        <div class="mb-3">
            <label for="username" class="form-label">Имя пользователя</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Логин</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Роль</label>
            <select class="form-control" id="role" name="role">
                <option value="1" <?php echo $user['role'] == 1 ? 'selected' : ''; ?>>Пользователь</option>
                <option value="2" <?php echo $user['role'] == 2 ? 'selected' : ''; ?>>Контентмейкер</option>
                <option value="3" <?php echo $user['role'] == 3 ? 'selected' : ''; ?>>Редактор</option>
                <option value="4" <?php echo $user['role'] == 4 ? 'selected' : ''; ?>>АДМИН</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Комментарий</label>
            <input type="text" class="form-control"  name="comment" value="">
        </div>
        <button type="submit" class="btn btn-primary">Сохранить изменения </button>
    </form>


<?php $content = ob_get_clean();
include 'app/views/layout.php';
?>