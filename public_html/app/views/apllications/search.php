
<?php
$title = 'Все заявки';
ob_start();
?>

<style>
    .table td, .table th {

        overflow: hidden; /* Скрывает переполненный текст */
        text-overflow: ellipsis; /* Показывает многоточие при переполнении */
    }
    .col{
        max-width: 100px;
    }


</style>
<form action="index.php?page=applications&action=search" method="get">
    <div style="display: flex;flex-direction: row">
        <input type="text" name="page" style="display: none" value="applications">
        <input type="text" name="action" style="display: none" value="search">
        <input name="date" type="date"class="form-control" style="max-width: 200px" <?php if (!empty($_GET['date'])){echo "value ='{$_GET['date']}'";} ?>>
        <select name="searchForField" style="max-width: 120px" class="form-control" id="role" name="role">
            <option value="0" disabled selected>Поиск по </option>
            <option value="name" <?php if (!empty($_GET['searchForField']) and $_GET['searchForField'] =='name'){ echo 'selected';} ?>>ФИО</option>
            <option value="number" <?php if (!empty($_GET['searchForField']) and $_GET['searchForField'] =='number'){ echo 'selected';} ?>>Номеру</option>
            <option value="city" <?php if (!empty($_GET['searchForField']) and $_GET['searchForField'] =='city'){ echo 'selected';} ?>>Городу</option>
            <option value="source" <?php if (!empty($_GET['searchForField']) and $_GET['searchForField'] =='source'){ echo 'selected';} ?>>Источнику</option>
            <option value="message" <?php if (!empty($_GET['searchForField']) and $_GET['searchForField'] =='message'){ echo 'selected';} ?>>Сообщению</option>
        </select>
        <input class="form-control" name="searchText" type="text" placeholder="Поиск" <?php if (!empty($_GET['searchText'])){echo "value='{$_GET['searchText']}' ";} ?>>
        <input class="btn btn-primary" type="submit" name="submit" value="Поиск">
    </div>

</form>
<table class="table table-striped table-bordered table-hover" style="width: 100%;">
    <thead>
    <tr>
        <th class="col" scope="col">id</th>
        <th scope="col">ФИО</th>
        <th scope="col">Телефон</th>
        <th scope="col">Дата</th>
        <th scope="col">Сообщение</th>
        <th scope="col">Источник</th>
        <th scope="col">Город</th>
        <th scope="col">Изменить</th>
        <th scope="col">Удалить</th>

    </tr>
    </thead>
    <tbody>
    <?php foreach ($selectedApplicationsForSearch as $application){
        ?><tr class="col"> <?php
        foreach ($application as $value){
            ?><td class="col"><?php echo $value ?></td> <?php
        }
        ?>
        <td class="col"><a href="index.php?page=applications&action=edit&id=<?php echo $application['id'] ?>">Редактировать</a></td>
        <td class="col"><a style="color:red" href="index.php?page=deleteApplication&id=<?php echo $application['id'] ?>">Удалить</a></td>
        </tr> <?php
    }
    ?>
    </tbody>
</table>

<?php $content = ob_get_clean();
include 'app/views/layout.php';
?>
