<?php
// controllers/DocumentController.php

require_once __DIR__.'/../includes/middleware.php';
require_once __DIR__.'/../models/documentModel.php';
require_once __DIR__.'/../models/studentModel.php';
require_once __DIR__.'/../models/userModel.php';

session_start();

// Adatbázis kapcsolat
global $db;

// Middleware-ek
requireLogin();
requirePermission('view_documents', $db);

// Modell példányosítás
$documentModel = new DocumentModel($db);
$studentModel = new StudentModel($db);
$userModel = new UserModel($db);

// Paraméterek ellenőrzése
$student_id = $_GET['student_id'] ?? null;
if (!$student_id || !$studentModel->getStudentById($student_id)) {
    $_SESSION['error'] = "Érvénytelen tanuló azonosító!";
    header('Location: index.php?page=students');
    exit;
}

// POST kérés kezelése: dokumentum feltöltése
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['document'])) {
    requirePermission('upload_documents', $db);
    
    $file = $_FILES['document'];
    $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
    
    if ($file['error'] === UPLOAD_ERR_OK && in_array($file['type'], $allowedTypes)) {
        $filename = uniqid('doc_', true).'_'.$file['name'];
        $targetPath = __DIR__.'/../uploads/documents/'.$filename;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $documentModel->addDocument(
                $student_id,
                $filename,
                $file['name'],
                $_SESSION['user']['id']
            );
            $_SESSION['success'] = "Dokumentum sikeresen feltöltve!";
        } else {
            $_SESSION['error'] = "A fájl feltöltése sikertelen!";
        }
    } else {
        $_SESSION['error'] = "Csak PDF, JPEG és PNG fájlok tölthetők fel!";
    }
    
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit;
}

// GET paraméter kezelése: dokumentum törlése
if (isset($_GET['delete'])) {
    requirePermission('delete_documents', $db);
    
    $docId = $_GET['delete'];
    $document = $documentModel->getDocumentById($docId);
    
    if ($document && $document['student_id'] == $student_id) {
        $filePath = __DIR__.'/../uploads/documents/'.$document['filename'];
        if (file_exists($filePath)) @unlink($filePath);
        
        $documentModel->deleteDocument($docId);
        $_SESSION['success'] = "Dokumentum sikeresen törölve!";
    } else {
        $_SESSION['error'] = "Dokumentum nem található!";
    }
    
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit;
}

// Adatok gyűjtése a nézethez
$documents = $documentModel->getDocumentsByStudent($student_id);
$student = $studentModel->getStudentById($student_id);

// Nézet betöltése
$title = "Dokumentumok - ".$student['lastname']." ".$student['firstname'];
$content = __DIR__.'/../views/documents.php';
include __DIR__.'/../views/layout.php';
