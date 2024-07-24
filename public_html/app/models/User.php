<?php
//https://youtu.be/8kle1jzL954?t=1297
class User{
    private $db;
    public function __construct(){
        $this->db = Database::getInstance()->getConnection();
        try {
            $result = $this->db->query("SELECT 1 FROM `users` LIMIT 1");
        } catch (PDOException $e){
            $this->createTable();}
    }
    public function createTable() {//проверяем есть ли таблица юзерс если нет то создаем -вручную создавать зашквар
            $roleTableQuery = "CREATE TABLE IF NOT EXISTS `roles` (
            `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `role_name` VARCHAR(255) NOT NULL,
            `role_description` TEXT
              )";
            $userTableQuery = "CREATE TABLE IF NOT EXISTS `users` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `username` VARCHAR(255) NOT NULL,
            `email` VARCHAR(255) NOT NULL,
            `email_verification` TINYINT(1) NOT NULL DEFAULT 0,
            `password` VARCHAR(255) NOT NULL,
            `is_admin` TINYINT (1) NOT NULL DEFAULT 0,
            `role` INT(11) NOT NULL DEFAULT 0,
            `is_active` TINYINT (1) NOT NULL DEFAULT 1,
            `last_login` TIMESTAMP NULL DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`role`) REFERENCES `roles` (`id`)
            )";
            try{
                $this->db->exec($roleTableQuery);
                $this->db->exec($userTableQuery);
                return true;
            } catch (PDOException $e) {
                return false;
                }
        }
    public function readAll(){
        try {
            $stmt = $this->db->query("SELECT * FROM `users`");

            $users =[];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $users[] = $row;
            }
            return  $users;
        } catch (PDOException $e){
            return false;
        }

    }
    public function create($data)
    {
        $username = $data ['username'];
        $email = $data ['email'];
        $password = $data['password'];
        $role = $data ['role'];

        $created_at = date('Y-m-d H:i:s');

        $query = "INSERT INTO users (username, email, password, role, created_at) VALUE (?, ?, ?, ?, ?)";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT), $role, $created_at]);
            return true;
        } catch (PDOException $error){
            include '../views/error.php';
            }


    }
    public function delete($id)
    {
        $query = "DELETE FROM users WHERE id = ?";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return true;
        }catch (PDOException $error){
            include '../views/error.php';
            }
    }
    public function read($id){
        $query = "SELECT * FROM users WHERE id = ?";
        try { $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $error){
                include '../views/error.php';
            }

    }
    public function update($id, $data){
        $old_data = $this->read($id);

        $username = $data['username'];
        $admin = !empty($data['admin']) && $data['admin'] !== 0 ? 1 : 0;
        $email = $data['email'];
        $role = $data['role'];
        $comment = $data['comment'];
        $is_active = isset($data['is_active']) ? 1 : 0;
        $query = "UPDATE users SET username = ?, email = ?, is_admin = ?, role = ?, is_active = ? WHERE id = ?";
        $date = date('Y-m-d H:i:s');

        try{
            $stmt = $this->db->prepare($query);
            $stmt->execute([$username, $email, $admin, $role, $is_active, $id]);

            $query = "select max(id_update) as id_update from users_update_history";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $id_update = $stmt->fetchAll(\PDO::FETCH_ASSOC)[0]['id_update'];
            if (empty($id_update)){
                $id_update =1;
            }else{
                $id_update++;
            }
            echo $id_update;


            foreach ($data as $key1 => $new_data) {
                foreach ($old_data as $key2 => $old_value) {
                    if ($key1 == $key2 && $old_value !== $new_data) {
                        $date = date('Y-m-d H:i:s');
                        $query = "INSERT INTO users_update_history (id_admin, id_user, date_updates, old_field, new_field,comment, field_name,id_update) VALUES (:id_admin, :id_user, :date_updates, :old_field, :new_field,:comment, :field_name,:id_update)";
                        $stmt = $this->db->prepare($query);
                        $stmt->bindParam(':id_admin', $_SESSION['user_id'], PDO::PARAM_INT);
                        $stmt->bindParam(':id_user', $id, PDO::PARAM_INT);
                        $stmt->bindParam(':date_updates', $date);
                        $stmt->bindParam(':old_field', $old_value);
                        $stmt->bindParam(':new_field', $new_data);
                        $stmt->bindParam(':comment', $comment);
                        $stmt->bindParam(':field_name', $key1);
                        $stmt->bindParam(':id_update', $id_update);
                        $stmt->execute();
                        break;
                    }
                }
            }
        } catch (PDOException $error) {
            include '../views/error.php';
        }

    }
}