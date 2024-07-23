<?php
//https://youtu.be/wPPpQEbFd3w?list=PL7Lf7uq4tiNBe332vuAYzniId5AI6fDSX&t=1275
require_once 'app/models/User.php';
class UsersController
{
    public function index()
    {
        $UserModel = new User();
        $users = $UserModel->readAll();

        include 'app/views/user/index.php';
    }

//https://youtu.be/wPPpQEbFd3w?list=PL7Lf7uq4tiNBe332vuAYzniId5AI6fDSX&t=4352
// редакция 1-https://youtu.be/C_FfBVffB80?list=PLMB6wLyKp7lXH2UwgDNTbeGlLNFvX1QcV&t=540
    public function create()
    {
        include 'app/views/user/create.php';
    }

    public function store()
    {
        if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if ($password !== $confirm_password) {
                echo "Пароль не совпадает";
                return;
            }
            $userModel = new User();
            $data = [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'password' => $password,
                'role' => 1, // по умолчанию id самого простого пользователя, если что то пошло не так нужно сверить id в таблице roles
            ];
            $userModel->create($data);
        }
        header("Location: index.php?page=users");
    }
    public function edit()
    {
        $userModel = new User();
        $user = $userModel->read($_GET['id']);

        include 'app/views/user/edit.php';
    }
    public function update()
    {
        $userModel = new User();
        $userModel->update($_GET['id'], $_POST);

        header("Location: index.php?page=users");

    }
    public function delete()
    {
        $userModel = new User();
        $userModel->delete($_GET['id']);
        header("Location: index.php?page=users");
    }
}