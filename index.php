<?php
session_start();
require __DIR__.'/includes/database.php';
require __DIR__.'/config.php';

$page = $_GET['page'] ?? 'students';

switch($page) {
    case 'students':
        require 'controllers/StudentController.php';
        break;
    case 'grades':
        require 'controllers/GradeController.php';
        break;
    case 'login':
    case 'logout':
    case 'register':
        require 'controllers/AuthController.php';
        break;
    default:
        http_response_code(404);
        exit;
}
