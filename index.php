<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require __DIR__.'/includes/database.php';
$config = require __DIR__.'/config.php';
require_once __DIR__.'/includes/helpers.php';

$page = $_GET['page'] ?? 'home';

switch($page) {
    case 'home':
        require 'controllers/homeController.php';
        break;
    case 'admin':
        require 'controllers/adminController.php';
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
    case 'documents':
        require 'controllers/documentController.php';
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
