<?php
//https://youtu.be/WJoih6XeqTM?t=1071
class AuthUser{
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
    public function register($username, $email, $password,$call_center,$role) {
        $created_at = date('Y-m-d H:i:s');
        $query = "INSERT INTO users (username, email, password, role, created_at,call_center) VALUES (?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT), $role, $created_at,$call_center]);
            $query = "select MAX(id) as id  from users";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $id = $stmt->fetchAll(\PDO::FETCH_ASSOC)[0]['id'];

            $query = "insert into users_create_history(id_admin,id_users,date_create) values(:id_admin,:id_user,:date_create)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_admin',$_SESSION['user_id']);
            $stmt->bindParam(':id_user',$id);
            $stmt->bindParam(':date_create',$created_at);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function findByEmail($email){
        try{
            $query = "SELECT * FROM users WHERE email = ? LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$email]);
            return  $stmt->fetch (PDO:: FETCH_ASSOC);

        } catch (PDOException $error) {
            include '../views/error.php';
        }
    }

}