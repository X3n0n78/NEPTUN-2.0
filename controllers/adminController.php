<?php

require_once __DIR__.'/../includes/middleware.php';
require_once __DIR__.'/../models/userModel.php';
require_once __DIR__.'/../models/roleModel.php';

// Kötelező bejelentkezés és admin jogosultság
requireLogin();
requirePermission('admin_panel', $GLOBALS['db']);

// Modellek példányosítása
$userModel = new UserModel($GLOBALS['db']);
$roleModel = new RoleModel($GLOBALS['db']);

// Alapértelmezett adatok
$editUser = null;
$allRoles = [];
$users = [];
$roles = [];

// ACTION KEZELÉSE
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'delete_user':
            if (isset($_GET['id'])) {
                if ($userModel->deleteUser($_GET['id'])) {
                    $_SESSION['success'] = "Felhasználó törölve!";
                } else {
                    $_SESSION['error'] = "Hiba a törlés során!";
                }
                header('Location: index.php?page=admin');
                exit;
            }
            break;

        case 'edit_user':
            if (isset($_GET['id'])) {
                $editUser = $userModel->getUserById($_GET['id']);
                $editUser['role_ids'] = $userModel->getUserRoles($_GET['id']);
                $allRoles = $roleModel->getAllRoles();
            }
            break;

        case 'add_user':
            $editUser = ['id' => 0, 'username' => '', 'email' => '', 'role_ids' => []];
            $allRoles = $roleModel->getAllRoles();
            break;

        case 'save_user':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = (int)($_POST['id'] ?? 0);
                $data = [
                    'username' => trim($_POST['username']),
                    'email'    => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'roles'    => $_POST['roles'] ?? []
                ];

                try {
                    if ($id) {
                        $success = $userModel->updateUser($id, $data);
                    } else {
                        $success = $userModel->createUser($data);
                    }

                    if ($success) {
                        $_SESSION['success'] = "Sikeres mentés!";
                    } else {
                        $_SESSION['error'] = "Hiba a mentés során!";
                    }
                } catch (Exception $e) {
                    $_SESSION['error'] = $e->getMessage();
                }
                
                header('Location: index.php?page=admin');
                exit;
            }
            break;

        case 'delete_role':
            if (isset($_GET['id'])) {
                if ($roleModel->deleteRole($_GET['id'])) {
                    $_SESSION['success'] = "Szerepkör törölve!";
                } else {
                    $_SESSION['error'] = "Hiba a törlés során!";
                }
                header('Location: index.php?page=admin');
                exit;
            }
            break;
    }
}

// ADATOK LEKÉRÉSE
$users = $userModel->getAllUsersWithRoles();
$roles = $roleModel->getAllRolesWithPermissions();

// NÉZET BETÖLTÉSE
$title = "Adminisztrációs felület";
$content = __DIR__.'/../views/admin.php';
include __DIR__.'/../views/layout.php';
