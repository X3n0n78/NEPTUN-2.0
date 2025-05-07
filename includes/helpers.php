<?php


function hasPermission($permKey) {
    if (!isset($_SESSION['user'])) return false;
    require_once __DIR__ . '/../models/userModel.php';
    global $db;
    $userModel = new UserModel($db);
    return $userModel->hasPermission($_SESSION['user']['id'], $permKey);
}

function hasRole($userId, $roleId) {
    $stmt = $this->db->prepare("
        SELECT COUNT(*) 
        FROM user_role 
        WHERE user_id = ? AND role_id = ?
    ");
    $stmt->execute([$userId, $roleId]);
    return $stmt->fetchColumn() > 0;
}

