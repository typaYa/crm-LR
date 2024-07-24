
<?php
$title = 'Все заявки';
ob_start();

$application = $application[0];
if (isset($confirm)){
    echo $confirm;
}
?>

<h1>Редактирование записи</h1>
<form method="POST" action="index.php?page=applications&action=update&id=<?php echo $application['id']; ?>">
    <div class="mb-3">
        <label for="username" class="form-label">Имя</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $application['name']; ?>" required>
    </div>
    <div class="mb-3">
        <label  class="form-label">Номер</label>
        <input type="text" class="form-control" id="email" name="phone" value="<?php echo $application['phone']; ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Дата</label>
        <input type="text" class="form-control" id="date" name="date" value="<?php echo $application['date']; ?>" required readonly>
    </div>
    <div class="mb-3">
        <label class="form-label">Сообщение</label>
        <input type="text" class="form-control" id="date" name="message" value="<?php echo $application['message']; ?>" required>
    </div>
    <div class="mb-3">
        <label  class="form-label">Источник</label>
        <input type="text" class="form-control" id="source" name="source" value="<?php echo $application['source']; ?>" required>
    </div>
    <div class="mb-3">
        <label  class="form-label">Город по IP</label>
        <input type="text" class="form-control" id="city_by_ip" name="city_by_ip" value="<?php echo $application['city_by_ip']; ?>" required>
    </div>

    <div class="mb-3">
        <label  class="form-label">Комментарий</label>
        <input type="text" class="form-control"  name="comment" value="" required>
    </div>
    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
</form>




<?php $content = ob_get_clean();
include 'app/views/layout.php';
?>
