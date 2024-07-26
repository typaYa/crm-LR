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
            case 'applications':
                if (isset($_GET['action'])){
                    if ($_GET['action']=='edit' and isset($_GET['id']) and is_numeric($_GET['id'])){
                        $controller = new \ApplicationsController();
                        $controller->editApplication($_GET['id']);
                    }
                    else if($_GET['action']=='update' and isset($_GET['id']) and is_numeric($_GET['id'])){
                        $controller= new ApplicationsController();
                        $controller->updateApplication($_GET['id'],$_POST);
                        }
                    else if ($_GET['action']=='search' and isset($_GET['submit'])){
                        $controller = new \ApplicationsController();
                        $controller->search($_GET);

                    }

                }else{
                    $controller = new \ApplicationsController();
                    $controller->allApplications();
                    break;
                }


           /* case 'editApplication':
                if (isset($_GET['id']) and is_numeric($_GET['id'])){
                    $controller = new \ApplicationsController();
                    $controller->editApplication($_GET['id']);
                    echo $_GET['id'];
                }*/


                break;


                default:
                http_response_code (404);
                $error = "Страница не найдена";
                require 'views/error.php';
                break;
        }
    }
}
