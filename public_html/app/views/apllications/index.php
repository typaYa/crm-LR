
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
<form action="index.php?" method="GET">
    <div style="display: flex;flex-direction: row">
        <input type="text" name="page" style="display: none" value="applications">
        <input type="text" name="action" style="display: none" value="search">
        <div>
            <label for="fromDate"></label>Дата от
            <input name="fromDate" type="date" value="<?php echo date('Y-m-d')?>" class="form-control" style="max-width: 200px">
        </div>
        <div>
            <label for="toDate"></label>Дата по
            <input name="toDate" value="<?php echo date('Y-m-d')?>" type="date" class="form-control" style="max-width: 200px">
        </div>

        <select name="searchForField" style="max-width: 120px" class="form-control" id="role" name="role">
            <option value="0" disabled selected>Поиск по </option>
            <option value="name" <?php if (!empty($_GET['searchForField']) and $_GET['searchForField'] =='name'){ echo 'selected';} ?>>ФИО</option>
            <option value="phone" <?php if (!empty($_GET['searchForField']) and $_GET['searchForField'] =='number'){ echo 'selected';} ?>>Номеру</option>
            <option value="city_by_ip" <?php if (!empty($_GET['searchForField']) and $_GET['searchForField'] =='city'){ echo 'selected';} ?>>Городу</option>
            <option value="source" <?php if (!empty($_GET['searchForField']) and $_GET['searchForField'] =='source'){ echo 'selected';} ?>>Источнику</option>
            <option value="message" <?php if (!empty($_GET['searchForField']) and $_GET['searchForField'] =='message'){ echo 'selected';} ?>>Сообщению</option>
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
        <th scope="col">КЦ</th>
        <th scope="col">Отпрвить</th>


    </tr>
    </thead>
    <tbody>
    <?php foreach ($allApplications as $application){
        ?><tr class="col"> <?php
        foreach ($application as $key=>$value){
            if ($key=='phone'){
               ?> <td><a href="index.php?page=applications&action=showNumber&number=<?php echo htmlspecialchars($application['phone']) ?>"><?php echo $value ?></a></td><?php
            }
            else{
            ?><td class="col"><?php echo htmlspecialchars($value) ?></td> <?php
            }
        }
       ?>
        <form action="index.php?">
            <input style="display: none" type="text" name="id" value="<?php echo $application['id'] ?>">
            <input type="text" name="page" style="display: none" value="applications">
            <input type="text" name="action" style="display: none" value="sendOnCallCenter">
            <td class="col">
                <select class="form-control" id="status" name="field_cc">
                    <option disabled selected>Выберете кц</option>
                    <option value="КЦ1">КЦ1</option>
                    <option value="КЦ2">КЦ2</option>
                    <option value="КЦ3">КЦ3</option>
                    <option value="КЦ4">КЦ4</option>
                    <option value="КЦ5">КЦ5</option>
                </select>
            </td>
            <td class="col"><input class="btn btn-primary" type="submit" name="submit" value="Отправить"></td>
        </form>
         </tr> <?php
    }
    ?>
    </tbody>
</table>
<div>
    <?php

    if (isset($_GET['pageNumber'])){
        if ($pagination<=10){
            for ($i=1;$pagination>=$i;$i++){
                if ($i==$_GET['pageNumber']){
                    echo $i;
                }else{
                    ?><a href="index.php?page=applications&pageNumber=<?php echo $i?>"><?php echo $i?></a>, <?php
                }
            }
        }else{
            if ($_GET['pageNumber']<3 or $_GET['pageNumber']>=$pagination-3){
                for ($i=1;$i<=3;$i++){
                    if ($i==$_GET['pageNumber']){
                        echo $i;
                    }else{
                        ?><a href="index.php?page=applications&pageNumber=<?php echo $i?>"><?php echo $i?></a>, <?php
                    }
                }
                echo '...';
                for ($i=$pagination-2;$i<=$pagination;$i++){
                    if ($i==$_GET['pageNumber']){
                        echo $i;
                    }else{
                        ?><a href="index.php?page=applications&pageNumber=<?php echo $i?>"><?php echo $i?></a>, <?php
                    }
                }
            }else if($_GET['pageNumber']==3 or $_GET['pageNumber']==4){
                for ($i=1;$i<=3;$i++){
                    ?><a href="index.php?page=applications&pageNumber=<?php echo $i?>"><?php echo $i?></a>, <?php
                }
                for ($i = $_GET['pageNumber'];$i<=$_GET['pageNumber']+2;$i++){
                    if ($i==$_GET['pageNumber']){
                        echo $i;
                    }else{
                        ?><a href="index.php?page=applications&pageNumber=<?php echo $i?>"><?php echo $i?></a>, <?php
                    }
                }
                echo '...';
                for ($i=$pagination-2;$i<=$pagination;$i++){
                    ?><a href="index.php?page=applications&pageNumber=<?php echo $i?>"><?php echo $i?></a>, <?php
                }
            }else if ($_GET['pageNumber']==$pagination-3){
                for ($i=1;$i<=3;$i++){
                    ?><a href="index.php?page=applications&pageNumber=<?php echo $i?>"><?php echo $i?></a>, <?php
                }
                echo '...';
                for ($i = $_GET['pageNumber'];$i>=$_GET['pageNumber']-2;$i--){
                    if ($i==$_GET['pageNumber']){
                        echo $i;
                    }else{
                        ?><a href="index.php?page=applications&pageNumber=<?php echo $i?>"><?php echo $i?></a>, <?php
                    }
                }
            }
            else{
                for ($i=1;$i<=3;$i++){
                    ?><a href="index.php?page=applications&pageNumber=<?php echo $i?>"><?php echo $i?></a>, <?php
                }
                echo '...';
                for ($i = $_GET['pageNumber'];$i<=$_GET['pageNumber']+2;$i++){
                    if ($i==$_GET['pageNumber']){
                        echo $i;
                    }else{
                        ?><a href="index.php?page=applications&pageNumber=<?php echo $i?>"><?php echo $i?></a>, <?php
                    }
                }
                echo '...';
                for ($i=$pagination-2;$i<=$pagination;$i++){
                    ?><a href="index.php?page=applications&pageNumber=<?php echo $i?>"><?php echo $i?></a>, <?php
                }
            }
        }
    }else{
        if ($pagination<=10){
            for ($i=1;$pagination>=$i;$i++){
                if ($i==$_GET['pageNumber']){
                    echo $i;
                }else{
                    ?><a href="index.php?page=applications&pageNumber=<?php echo $i?>"><?php echo $i?></a>, <?php
                }
            }
        }else{
            echo '1, ';
            for ($i=2;$i<=3;$i++){
                ?><a href="index.php?page=applications&pageNumber=<?php echo $i?>"><?php echo $i?></a>, <?php
            }
            echo '...';
            for ($i=$pagination-2;$i<=$pagination;$i++){
                ?><a href="index.php?page=applications&pageNumber=<?php echo $i?>"><?php echo $i?></a>, <?php
            }
        }
    }

    ?>

</div>

<?php $content = ob_get_clean();
include 'app/views/layout.php';
?>