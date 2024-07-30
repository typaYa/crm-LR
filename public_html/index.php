<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'app/models/database.php';
require_once 'app/models/User.php';
require_once 'app/models/Application.php';
require_once 'app/models/AuthUser.php';
require_once 'app/controllers/users/AuthController.php';
require_once 'app/controllers/users/UsersController.php';
require_once 'app/controllers/applications/ApplicationsController.php';
require_once 'app/controllers/HomeController.php';

require_once 'app/router.php';

print_r($_SESSION);
    $router = new Router();
    $router->run();

