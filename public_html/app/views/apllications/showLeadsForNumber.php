
<?php
$title = 'Все заявки по номеру';
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
<form action="index.php?" method="GET">
    <div style="display: flex;flex-direction: row">
        <input type="text" name="page" style="display: none" value="applications">
        <input type="text" name="action" style="display: none" value="search">
        <input name="date" type="date"class="form-control" style="max-width: 200px">
        <select name="searchForField" style="max-width: 120px" class="form-control" id="role" name="role">
            <option value="0" disabled selected>Поиск по </option>
            <option value="name">ФИО</option>
            <option value="number">Номеру</option>
            <option value="city">Городу</option>
            <option value="source">Источнику</option>
            <option value="message">Сообщению</option>
        </select>
        <input class="form-control" name="searchText" type="text" placeholder="Поиск">
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
        <th scope="col">Cтатус</th>
        <th scope="col">Изменить</th>
        <th scope="col">Удалить</th>

    </tr>
    </thead>
    <tbody>
    <?php foreach ($allApplications as $application){
        ?><tr class="col"> <?php
        foreach ($application as $key=>$value){
            if ($key=='phone'){
                ?> <td><a href="index.php?page=applications&action=showNumber&number=<?php echo $application['phone'] ?>"><?php echo $value ?></a></td><?php
            }else{
                ?><td class="col"><?php echo $value ?></td> <?php
            }
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