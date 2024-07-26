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
        $query = "SELECT `id`,`name`,`phone`,`date`,`message`,`source`,`city_by_ip`,`status` FROM leads order by `id` desc ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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
        if (isset($search['date']) and !empty($search['date'])) {
            $query.= " DATE(date) = '{$search['date']}' and";
        }
        if (isset($search['searchForField']) and !empty($search['searchForField']) and !empty($search['searchText'])) {
            $query.= " {$search['searchForField']} like '%{$search['searchText']}%' ";
        }
        if (substr($query, -3) === 'and') {
            $query = substr($query, 0, -3);
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }
    public function updateApplicationForID($id,$data)
    {
        $old_data = $this->selectApplicationForID($id)[0];

        $query = "UPDATE leads SET name = :name,phone = :phone, date = :date,message=:message, source = :source,city_by_ip=:city_by_ip,status=:status where id=:id";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->bindParam(':date', $data['date']);
            $stmt->bindParam(':message', $data['message']);
            $stmt->bindParam(':source', $data['source']);
            $stmt->bindParam(':status', $data['status']);
            $stmt->bindParam(':city_by_ip', $data['city_by_ip'], PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
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
            foreach ($data as $key1 => $new_data) {
                foreach ($old_data as $key2 => $old_value) {
                    if ($key1 == $key2 && $old_value !== $new_data) {
                        $date = date('Y-m-d H:i:s');
                        $query = "INSERT INTO history_updates_applications (id_attentions, id_users, date_updates, old_field, new_field,comment, field_name,id_update) VALUES (:id_attentions, :id_users, :date_updates, :old_field, :new_field,:comment, :field_name,:id_update)";
                        $stmt = $this->pdo->prepare($query);
                        $stmt->bindParam(':id_attentions', $id, PDO::PARAM_INT);
                        $stmt->bindParam(':id_users', $_SESSION['user_id'], PDO::PARAM_INT);
                        $stmt->bindParam(':date_updates', $date);
                        $stmt->bindParam(':old_field', $old_value);
                        $stmt->bindParam(':new_field', $new_data);
                        $stmt->bindParam(':comment', $data['comment']);
                        $stmt->bindParam(':field_name', $key1);
                        $stmt->bindParam(':id_update', $id_update);
                        $stmt->execute();
                        break;
                    }
                }
            }
        }catch (\PDOException $error) {
            print_r($error);
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
}