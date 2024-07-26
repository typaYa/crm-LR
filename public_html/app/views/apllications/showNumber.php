<?php
$title = 'Все заявки';
ob_start();
print_r($selectedInfoForNumber);
?>

<table class="table table-striped table-bordered table-hover" style="width: 100%;">
    <thead>
    <tr>

        <th scope="col">Телефон</th>
        <th scope="col">Статус</th>
        <th scope="col">Спам</th>
        <th scope="col">Кол-во заявок</th>

    </tr>
    </thead>
    <tbody>
    <?php foreach ($selectedInfoForNumber as $Number){
        ?><tr class="col"> <?php
        foreach ($Number as $key=>$value){
            if ($key=='lead_count'){
                ?><td class="col"><a href="index.php?page=applications&action=showApplicationsForNumber&number=<?php echo $Number['number']?>"><?php echo $value ?></a></td> <?php
            }else{
                ?><td class="col"><?php echo $value ?></td> <?php
            }

        }
        ?>
         <?php
    }
    ?>
    </tbody>
</table>
<?php $content = ob_get_clean();
include 'app/views/layout.php';
?>
