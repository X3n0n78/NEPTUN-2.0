<?php
require_once __DIR__.'/../models/messageModel.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__.'/../includes/helpers.php';
require_once __DIR__.'/../includes/middleware.php';




if ($page === 'contact') {
    $title = "Kapcsolat";
    $content = 'views/contact.php';
    include 'views/layout.php';
}

if ($page === 'contact_process') {
    $errors = [];
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $subject = trim(filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING));
    $message = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING));

    if (empty($name)) $errors[] = "A név megadása kötelező";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Érvényes email cím megadása kötelező";
    if (empty($subject)) $errors[] = "A tárgy megadása kötelező";
    if (empty($message) || strlen($message) < 10) $errors[] = "Az üzenet túl rövid (min. 10 karakter)";

    if (empty($errors)) {
        $messageModel = new MessageModel($db);
        $user_id = $_SESSION['user']['id'] ?? null;
        if ($messageModel->saveMessage($name, $email, $subject, $message, $user_id)) {
            $_SESSION['contact_success'] = "Üzenetét sikeresen elküldtük!";
        } else {
            $_SESSION['contact_error'] = "Hiba történt az üzenet mentése során.";
        }
    } else {
        $_SESSION['contact_error'] = implode("<br>", $errors);
    }

    header("Location: index.php?page=contact");
    exit;
}
