<?php
session_start();
require __DIR__.'/includes/database.php';
$config = require __DIR__.'/config.php';

$page = $_GET['page'] ?? 'home';

switch($page) {
    case 'home':
        require 'controllers/homeController.php';
        break;
    case 'students':
        require 'controllers/studentController.php';
        break;
    case 'grades':
        require 'controllers/gradeController.php';
        break;
    case 'reports':
        require 'controllers/reportsController.php';
        break;
    case 'login':
    case 'logout':
    case 'register':
        require 'controllers/authController.php';
        break;
    default:
        http_response_code(404);
        exit;
}
