<?php
require_once __DIR__.'/../models/userModel.php';
$userModel = new UserModel($db);

if ($page === 'register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $success = $userModel->register($_POST['lastname'], $_POST['firstname'], $_POST['username'], $_POST['password']);
    header('Location: index.php?page=login&registered=' . ($success ? '1' : '0'));
    exit;
}

if ($page === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $userModel->login($_POST['username'], $_POST['password']);
    if ($user) {
        $_SESSION['user'] = $user;
        header('Location: index.php?page=students');
        exit;
    } else {
        $error = "Hibás felhasználónév vagy jelszó!";
    }
}

if ($page === 'logout') {
    session_destroy();
    header('Location: index.php?page=login');
    exit;
}

$title = ($page === 'register') ? "Regisztráció" : "Belépés";
$content = 'views/' . $page . '.php';
include 'views/layout.php';
