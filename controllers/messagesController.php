<?php

require_once __DIR__.'/../models/messageModel.php';
require_once __DIR__.'/../includes/middleware.php';

if ($page === 'messages') {
    requireLogin(); // csak bejelentkezett felhasználónak
    $messageModel = new MessageModel($db);
    $messages = $messageModel->getAllMessages();
    $title = "Üzenetek";
    $content = 'views/messages.php';
    include 'views/layout.php';
}

