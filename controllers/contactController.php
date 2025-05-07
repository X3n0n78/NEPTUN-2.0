<?php

require_once __DIR__.'/../models/messageModel.php';

// Kapcsolat oldal megjelenítése
if ($page === 'contact') {
    $title = "Kapcsolat";
    $content = 'views/contact.php';
    include 'views/layout.php';
}

// Űrlap feldolgozása
if ($page === 'contact_process') {
    // Szerveroldali validáció
    $errors = [];
    
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $subject = trim(filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING));
    $message = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING));
    
    if (empty($name)) {
        $errors[] = "A név megadása kötelező";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Érvényes email cím megadása kötelező";
    }
    
    if (empty($subject)) {
        $errors[] = "A tárgy megadása kötelező";
    }
    
    if (empty($message) || strlen($message) < 10) {
        $errors[] = "Az üzenet túl rövid (min. 10 karakter)";
    }
    
    // Ha nincs hiba, mentjük az adatbázisba
    if (empty($errors)) {
        $messageModel = new MessageModel($db);
        $user_id = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
        
        if ($messageModel->saveMessage($name, $email, $subject, $message, $user_id)) {
            $_SESSION['contact_success'] = "Üzenetét sikeresen elküldtük!";
        } else {
            $_SESSION['contact_error'] = "Hiba történt az üzenet mentése során.";
        }
    } else {
        $_SESSION['contact_error'] = implode("<br>", $errors);
    }
    
    // Visszairányítás a kapcsolat oldalra
    header("Location: index.php?page=contact");
    exit;
}
