<?php
// controllers/AdminController.php

require_once __DIR__.'/../includes/middleware.php';
require_once __DIR__.'/../models/userModel.php';
require_once __DIR__.'/../models/roleModel.php';

// Kötelező bejelentkezés és admin jogosultság
requireLogin();
requirePermission('admin_panel', $GLOBALS['db']);

// Modellek példányosítása
$userModel = new UserModel($GLOBALS['db']);
$roleModel = new RoleModel($GLOBALS['db']);

// POST kérés kezelése - szerepkörök frissítése
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    try {
        // Adatok validálása
        $userId = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
        $selectedRoles = $_POST['roles'] ?? [];
        
        if (!$userId || $userId < 1) {
            throw new Exception("Érvénytelen felhasználó azonosító!");
        }

        // Jelenlegi és új szerepkörök összehasonlítása
        $currentRoles = $userModel->getUserRoles($userId);
        $allRoles = $roleModel->getAllRoles();

        foreach ($allRoles as $role) {
            $roleId = $role['id'];
            
            // Szerepkör hozzáadása
            if (in_array($roleId, $selectedRoles) && !in_array($roleId, $currentRoles)) {
                $userModel->addRoleToUser($userId, $roleId);
            }
            
            // Szerepkör eltávolítása
            if (!in_array($roleId, $selectedRoles) && in_array($roleId, $currentRoles)) {
                $userModel->removeRoleFromUser($userId, $roleId);
            }
        }

        $_SESSION['success'] = "A szerepkörök sikeresen frissítve!";
        
    } catch (Exception $e) {
        $_SESSION['error'] = "Hiba: " . $e->getMessage();
    }
    
    // Oldal újratöltése
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}

// Adatok lekérése a nézethez
$users = $userModel->getAllUsersWithRoles();
$roles = $roleModel->getAllRoles();

// Nézet betöltése
$title = "Adminisztrációs felület";
$content = __DIR__.'/../views/admin.php';
include __DIR__.'/../views/layout.php';
