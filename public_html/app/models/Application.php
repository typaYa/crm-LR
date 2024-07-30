<?php

class Application
{
    protected $pdo;

    /**
     *
     */
    public function __construct()
    {
        $this->pdo=\Database::getInstance()->getConnection();
    }
    public function selectAllApplication()
    {
        $query = "SELECT `id`,`name`,`phone`,`date`,`message`,`source`,`city_by_ip` FROM leads where call_center_name is null order by `id` desc ";

        if (isset($_GET['pageNumber'])){
            $query.=$this->searchForPagination($_GET['pageNumber']);
        }else{
            $query.=$this->searchForPagination();
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return [$data,$this->createPagination()];
    }
    public function sendOnCallCenter($data)
    {
        $query = "update leads set call_center_name = :field_cc where id =:id";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':field_cc', $data['field_cc']);
            $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
            $stmt->execute();
        }catch (Exception $e){
            print_r($e);
        }
    }
    public function createPagination($limit =50)
    {
        $query = "select count(*) as count from leads";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $pages =  $stmt->fetchAll(\PDO::FETCH_ASSOC)[0]['count'];
        return round($pages/$limit);

    }
    public function searchForPagination($page = 1,$limit =50)
    {
        $pageOffset = ($page-1)*$limit;
        return "limit $limit offset $pageOffset";
    }
    public function selectApplicationForID($id)
    {
        $query = "SELECT `id`,`name`,`phone`,`date`,`message`,`source`,`city_by_ip`,`status` FROM leads where id =$id ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function searchApplication($search)
    {
        $query = "SELECT `id`,`name`,`phone`,`date`,`message`,`source`,`city_by_ip`,`status` FROM leads where ";
        if (isset($search['fromDate']) and isset($search['toDate'])) {
            $query.= " DATE(date) between '{$search['fromDate']}' and '{$search['toDate']}' and";
        }
        if (isset($search['searchForField']) and !empty($search['searchForField']) and !empty($search['searchText'])) {
            $query.= " {$search['searchForField']} like '%{$search['searchText']}%' ";
        }
        if (substr($query, -3) === 'and') {
            $query = substr($query, 0, -3);
        }
        $query.='order by id desc';
        if (isset($_GET['pageNumber'])){
            $query.=$this->searchForPagination($_GET['pageNumber']);
        }else{
            $query.=$this->searchForPagination();
        }
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }
    public function updateApplicationForID($id,$data)
    {
        $old_data = $this->selectApplicationForID($id)[0];
        $query= "UPDATE leads SET ";
        foreach ($data as $key=>$field){
            $query.=" $key = :$key,";
        }
        if (substr($query, -1) === ',') {
            $query = substr($query, 0, -1);
        }


        $query.=" where id = :id";
        print_r($query);
        try {
            $stmt = $this->pdo->prepare($query);
            foreach ($data as $key=>$field){
                echo $key."|".$field.'<br>';
                $stmt->bindParam(":$key", $data[$key]);
            }
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            $query = "select max(id_update) as id_update from history_updates_applications";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            $id_update = $stmt->fetchAll(\PDO::FETCH_ASSOC)[0]['id_update'];
            if (empty($id_update)){
                $id_update =1;
            }else{
                $id_update++;
            }
            foreach ($data as $key1 => $new_value) {
                foreach ($old_data as $key2 => $old_value) {
                    if ($key1 == $key2 && $old_value !== $new_value) {
                        $date = date('Y-m-d H:i:s');
                        $query = "INSERT INTO history_updates_applications (id_attentions, id_users, date_updates, old_field, new_field,comment, field_name,id_update) VALUES (:id_attentions, :id_users, :date_updates, :old_field, :new_field,:comment, :field_name,:id_update)";
                        $stmt = $this->pdo->prepare($query);
                        $stmt->bindParam(':id_attentions', $id, PDO::PARAM_INT);
                        $stmt->bindParam(':id_users', $_SESSION['user_id'], PDO::PARAM_INT);
                        $stmt->bindParam(':date_updates', $date);
                        $stmt->bindParam(':old_field', $old_value);
                        $stmt->bindParam(':new_field', $new_value);
                        $stmt->bindParam(':comment', $data['comment']);
                        $stmt->bindParam(':field_name', $key1);
                        $stmt->bindParam(':id_update', $id_update);
                        $stmt->execute();
                        break;
                    }
                }
            }
        }catch(Exception $e){
            print_r($e);
            die();
        }
    }

    public function selectedInfoForNumber($number)
    {
        $query = "SELECT ns.number, ns.status, ns.is_spam, COUNT(*) as lead_count FROM number_status ns JOIN leads l ON l.phone = ns.number WHERE ns.number = $number GROUP BY ns.number, ns.status, ns.is_spam;";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }
    public function showLeadForNumber($number)
    {
        $query = "SELECT `id`,`name`,`phone`,`date`,`message`,`source`,`city_by_ip`,`status` FROM leads where phone = $number ORDER BY id DESC ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function selectHistoryUpdateApplications()
    {
        $query = "SELECT * FROM history_updates_applications order by id_update desc";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function selectHistoryUpdateForData($search)
    {
        $query = "SELECT * FROM history_updates_applications where ";
        if (isset($search['fromDate']) and isset($search['toDate'])) {
            $query.= " DATE(date_updates) between '{$search['fromDate']}' and '{$search['toDate']}' and";
        }
        if (isset($search['searchForField']) and !empty($search['searchForField']) and !empty($search['searchText'])) {
            if ($search['searchForField']=='id_update'){
                $query.= " {$search['searchForField']} = '{$search['searchText']}' ";
            }else{
                $query.= " {$search['searchForField']} like '%{$search['searchText']}%' ";
            }
        }
        if (substr($query, -3) === 'and') {
            $query = substr($query, 0, -3);
        }
        $query.='order by id_update desc';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function selectAllApplicationForCallCenter($call_center_name)
    {
        $query = "SELECT `id`,`name`,`phone`,`date`,`message`,`source`,`city_by_ip` FROM leads where call_center_name =:call_center_name and call_center_user is null ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':call_center_name',$call_center_name);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function sendOnCallCenterUser($data)
    {
        $query = "update leads set call_center_user = :field_cc_id where id =:id";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':field_cc_id', $data['field_cc_id']);
            $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
            $stmt->execute();
        }catch (Exception $e){
            print_r($e);
        }
    }
    public function selectAllUserForCallCenter($call_center_name)
    {
        $query = "select id,username from users where call_center =:call_center_name AND role=1";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':call_center_name',$call_center_name);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function selectAllApplicationForCallCenterUser($call_center_name,$user_id)
    {
        $query = "SELECT `id`,`name`,`phone`,`date`,`message`,`source`,`city_by_ip` FROM leads where call_center_name =:call_center_name and call_center_user =:call_center_user ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':call_center_name',$call_center_name);
        $stmt->bindParam(':call_center_user',$user_id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}