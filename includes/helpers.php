<?php


function hasPermission($permKey) {
    if (!isset($_SESSION['user'])) return false;
    require_once __DIR__ . '/../models/userModel.php';
    global $db;
    $userModel = new UserModel($db);
    return $userModel->hasPermission($_SESSION['user']['id'], $permKey);
}
