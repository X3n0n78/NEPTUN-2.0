<?php
// controllers/authController.php

require_once __DIR__.'/../models/userModel.php';
require_once __DIR__.'/../includes/helpers.php';

$userModel = new UserModel($db);

// Bejelentkezés
if ($page === 'login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        if (empty($username) || empty($password)) {
            $_SESSION['error'] = "Felhasználónév és jelszó megadása kötelező!";
            header('Location: index.php?page=login');
            exit();
        }

        $user = $userModel->login($username, $password);
        
        if ($user) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'lastname' => $user['lastname'],
                'firstname' => $user['firstname']
            ];
            header('Location: index.php?page=home');
            exit();
        } else {
            $_SESSION['error'] = "Hibás felhasználónév vagy jelszó!";
            header('Location: index.php?page=login');
            exit();
        }
    } else {
        $title = "Bejelentkezés";
        $content = 'views/login.php';
        include 'views/layout.php';
    }
}


// Kijelentkezés
elseif ($page === 'logout') {
    session_unset();
    session_destroy();
    header('Location: index.php?page=login');
    exit();
}

// Regisztráció
elseif ($page === 'register') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $lastname = trim($_POST['lastname']);
        $firstname = trim($_POST['firstname']);
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);

        // Ellenőrzések
        if (empty($lastname) || empty($firstname)) {
            $_SESSION['error'] = "A családi név és keresztnév megadása kötelező!";
            header('Location: index.php?page=register');
            exit();
        }

        if ($password !== $confirm_password) {
            $_SESSION['error'] = "A jelszavak nem egyeznek!";
            header('Location: index.php?page=register');
            exit();
        }

        if ($userModel->getUserByUsername($username)) {
            $_SESSION['error'] = "A felhasználónév már foglalt!";
            header('Location: index.php?page=register');
            exit();
        }

        if ($userModel->getUserByEmail($email)) {
            $_SESSION['error'] = "Az email cím már foglalt!";
            header('Location: index.php?page=register');
            exit();
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $success = $userModel->register($username, $hashedPassword, $email, $lastname, $firstname);

        if ($success) {
            $_SESSION['success'] = "Sikeres regisztráció! Most már bejelentkezhet.";
            header('Location: index.php?page=login');
            exit();
        } else {
            $_SESSION['error'] = "Hiba a regisztráció során!";
            header('Location: index.php?page=register');
            exit();
        }
    } else {
        $title = "Regisztráció";
        $content = 'views/register.php'; // vagy 'views/register.php', ha így használod
        include 'views/layout.php';
    }
}

