
<?php
$title = 'История изменения записей ';
ob_start();
?>

<style>
    .col{
        max-width: 100px;
    }


</style>
<form action="index.php?" method="GET">
    <div style="display: flex;flex-direction: row">
        <input type="text" name="page" style="display: none" value="applications">
        <input type="text" name="action" style="display: none" value="searchForHistory">
        <div>
            <label for="fromDate"></label>Дата от
            <input name="fromDate" type="date" value="<?php if (isset($_GET['fromDate'])){echo$_GET['fromDate']; }else{ echo date('Y-m-d');}?>" class="form-control" style="max-width: 200px">
        </div>
        <div>
            <label for="toDate"></label>Дата по
            <input name="toDate" value="<?php if (isset($_GET['toDate'])){echo$_GET['toDate']; }else{ echo date('Y-m-d');}?>" type="date" class="form-control" style="max-width: 200px">
        </div>

        <select name="searchForField" style="max-width: 120px" class="form-control" id="role" >
            <option value="0" disabled selected>Поиск по </option>
            <option value="old_field" <?php if (!empty($_GET['searchForField']) and $_GET['searchForField'] =='old_field'){ echo 'selected';} ?>>Старому значению</option>
            <option value="new_field" <?php if (!empty($_GET['searchForField']) and $_GET['searchForField'] =='new_field'){ echo 'selected';} ?>>Новому значению</option>
            <option value="comment" <?php if (!empty($_GET['searchForField']) and $_GET['searchForField'] =='comment'){ echo 'selected';} ?>>Комментарию</option>
            <option value="field_name" <?php if (!empty($_GET['searchForField']) and $_GET['searchForField'] =='field_name'){ echo 'selected';} ?>>Полю</option>
            <option value="id_update" <?php if (!empty($_GET['searchForField']) and $_GET['searchForField'] =='id_update'){ echo 'selected';} ?>>ID изменения</option>
        </select>
        <input class="form-control" name="searchText" type="text" placeholder="Поиск" <?php if (!empty($_GET['searchText'])) { echo 'value="' . htmlspecialchars($_GET['searchText'], ENT_QUOTES, 'UTF-8') . '"'; } ?>>
        <input class="btn btn-primary" type="submit" name="submit" value="Поиск">

    </div>

</form>
<table class="table table-striped table-bordered table-hover" >
    <thead>
    <tr>
        <th class="col" >ID записи </th>
        <th class="col"  >ID пользователя </th>
        <th class="col" >Дата изменения</th>
        <th  class="col" >Старое значение</th>
        <th class="col" >Новое значение</th>
        <th class="col" >Комментарий</th>
        <th class="col" >Имя поля</th>
        <th class="col">ID изменения</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($selectHistoryUpdateApplications as $application){
        ?><tr class="col"> <?php
        foreach ($application as $key=>$value){
            if ($key =='id_attentions'){
                ?><td class="col"><a href="index.php?page=applications&action=edit&id=<?php echo htmlspecialchars($application["$key"]); ?>"><?php echo $value ?></a></td> <?php
            }else if ($key=='id_users'){
                ?><td class="col"><a href="index.php?page=users&action=edit&id=<?php echo htmlspecialchars($application["$key"]);?>"><?php echo $value ?></a></td> <?php
            }
            else{
                ?> <td class="col"><?php echo htmlspecialchars($value);?></td> <?php
            }

        }
        ?></tr> <?php
    }
    ?>
    </tbody>
</table>

<?php $content = ob_get_clean();
include 'app/views/layout.php';
?>
