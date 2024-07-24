
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
    <?php foreach ($allApplications as $application){
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