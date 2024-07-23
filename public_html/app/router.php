<?php
//https://youtu.be/wPPpQEbFd3w?list=PL7Lf7uq4tiNBe332vuAYzniId5AI6fDSX&t=4752
class Router{
    public function run(){
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';
        switch($page){
            case '':
            case 'home':
                $controller = new HomeController();
                $controller->index();
                break;
            case 'users':
                $controller = new UsersController();
                if(isset($_GET['action'])){
                    switch ($_GET['action']) {
                        case 'create':
                            $controller->create();
                            break;
                        case 'store':
                            $controller->store();
                            break;
                        case 'delete':
                            $controller->delete();
                            break;
                        case 'edit':
                            $controller->edit();
                            break;
                        case 'update':
                            $controller->update();
                            break;
                    }
                } else{
                    $controller->index();
                }
                break;

            case 'register':
                $controller = new AuthController();
                $controller->register();
                break;

            case 'login':
                $controller = new AuthController();
                $controller->login();
                break;

            case 'authenticate':
                $controller = new AuthController();
                $controller->authenticate();
                break;

            case 'logout':
                $controller = new AuthController();
                $controller->logout();
                break;
            case 'auth':
                $controller = new AuthController();
                if(isset($_GET['action'])){
                    switch ($_GET['action']) {
                        case 'store':
                            $controller->store();
                            break;
                        case 'authenticate':
                        $controller->authenticate();
                        break;
                    }
                } else{
                    $controller->login();
                }
                break;

                default:
                http_response_code (404);
                echo "Page not found!";
                break;

        }
    }
}
