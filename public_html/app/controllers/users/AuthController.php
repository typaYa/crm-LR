<?php
//https://youtu.be/WJoih6XeqTM
//require_once 'app/models/AuthUser.php';
class AuthController
{
    /**
     * @var AuthUser
     */
    protected $authModel;

    /**
     *
     */
    public function __construct()
    {
        $this->authModel=new AuthUser();
    }

    /**
     * @return void
     */
    public function register(): void
    {

        include 'app/views/user/register.php';
    }


//https://youtu.be/WJoih6XeqTM?t=3045

    /**
     * @return void
     */
    public function store(): void
    {
        if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);

            $password = trim($_POST['password']);
            $confirm_password = trim($_POST['confirm_password']);
            $userModel = $this->authModel;

            if ($userModel->findByEmail($email)){
                $this->redirectWithError('register','Данный логин уже существует');
                die();
            }
            if ($password !== $confirm_password) {
                $this->redirectWithError('register','Пароли не совпадают');
                die();
            }

            $userModel->register($username, $email, $password);

        }
        header("Location: index.php?page=users");
    }

    /**
     * @param $page
     * @param $message
     * @return void
     */
    public function redirectWithError($page, $message): void {
        $encodedMessage = urlencode($message);
        header("Location: index.php?page=$page&error=$encodedMessage");

    }

    /**
     * @param $id
     * @param $role
     * @return void
     */
    private function startSession($id, $role):void{
        $_SESSION['user_id'] = $id;
        $_SESSION['user_role'] = $role;
    }

//https://youtu.be/WJoih6XeqTM?t=753

    /**
     * @return void
     */
    public function login(): void
    {
        include 'app/views/user/login.php';
    }

    /**
     * @return void
     */
    public function authenticate():void{
        $authModel = $this->authModel;

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

                    $userCon = new User();

                    $userCon->updateLastLogin($user['id']);
                    header("Location: index.php?page=applications");
                    exit();
                } else {
                    $this->redirectWithError('login','Неправильный логин или пароль');
                    die();
                }
            } else {
                $this->redirectWithError('login','Неправильный логин или пароль');
                die();
            }
        }
    }

    /**
     * @return void
     */
    public function logout():void
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