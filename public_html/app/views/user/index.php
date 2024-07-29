<?php
//https://youtu.be/wPPpQEbFd3w?list=PL7Lf7uq4tiNBe332vuAYzniId5AI6fDSX&t=1771

$title = 'Пользователи';
ob_start();
?>
<h1>Список пользователей</h1>
<a href="index.php?page=register" class="btn btn-info">Создать пользователя</a>
<table class="table">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Имя</th>
        <th scope="col">Логин</th>
        <th scope="col">Роль</th>
        <th scope="col">Последний вход</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo htmlspecialchars($user['id']); ?></td>
            <td><?php echo htmlspecialchars($user['username']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td><?php echo htmlspecialchars($user['role']); ?></td>
            <td><?php echo htmlspecialchars($user['last_login']); ?></td>
            <?php if (isset($_SESSION['user_id']) and isset($_SESSION['user_role']) and $_SESSION['user_role'] ==3){
                ?>
                <td>
                    <a href="index.php?page=users&action=edit&id=<?php echo $user['id'];?>" class="btn btn-primary">Edit</a>
                    <a href="index.php?page=users&action=delete&id=<?php echo $user['id'];?>" class="btn btn-danger">Delete</a>
                </td>
                <?php
            } ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php $content = ob_get_clean();
include 'app/views/layout.php';
?>