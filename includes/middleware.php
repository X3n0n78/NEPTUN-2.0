<?php

function requireLogin() {
    if (!isset($_SESSION['user'])) {
        header('Location: index.php?page=login');
        exit;
    }
}

function requirePermission($permKey, $db) {
    require_once __DIR__.'/../models/UserModel.php';
    $userModel = new UserModel($db);
    if (!isset($_SESSION['user']) || !$userModel->hasPermission($_SESSION['user']['id'], $permKey)) {
        $_SESSION['error'] = "Nincs jogosultságod ehhez a művelethez!";
        header('Location: index.php');
        exit;
    }
}
