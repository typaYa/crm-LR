<?php
//https://youtu.be/WJoih6XeqTM
//require_once 'app/models/AuthUser.php';
class AuthController
{
    protected $authModel;
    public function register()
    {

        include 'app/views/user/register.php';
    }
    private function setAuthModel()
    {
        return $this->authModel= new AuthUser();
    }

//https://youtu.be/WJoih6XeqTM?t=3045
    public function store()
    {
        if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $confirm_password = trim($_POST['confirm_password']);
            $userModel = $this->setAuthModel();
            if ($userModel->findByEmail($email)){
                $this->redirectWithError('register','Данный емаил уже существует');
            }
            if ($password !== $confirm_password) {
                $this->redirectWithError('register','Пароли не совпадают');
            }
            $userModel->register($username, $email, $password);
        }
        header("Location: index.php?page=login");
    }
    private function redirectWithError($page,$message) {
        $encodedMessage = urlencode($message);
        header("Location: index.php?page=$page&error=$encodedMessage");
        exit();
    }
    private function startSession($id,$role){
        $_SESSION['user_id'] = $id;
        $_SESSION['user_role'] = $role;

    }

//https://youtu.be/WJoih6XeqTM?t=753
    public function login()
    {
        include 'app/views/user/login.php';
    }
    public function authenticate(){
        $authModel = $this->setAuthModel();

        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $remember = isset($_POST['remember']) ? $_POST['remember'] : '';

            $user = $authModel->findByEmail($email);


            if ($user) {
                if (password_verify($password, $user['password'])) {

                    $this->startSession($user['id'],$user['role']);

                    if ($remember === 'on') {
                        setcookie('user_email', $email, time() + (7 * 24 * 60 * 60), '/');
                    }

                    header("Location: index.php");
                    exit();
                } else {
                    $this->redirectWithError('login','Неправильный логин или пароль');
                }
            } else {
                $this->redirectWithError('login','Неправильный логин или пароль');
            }
        }
    }
    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach ($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time() - 3600, '/');
                setcookie($name, '', time() - 3600, '/', $_SERVER['HTTP_HOST']);
            }
        }

        header("Location: index.php");
    }
}