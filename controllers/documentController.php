<?php
require_once __DIR__.'/../models/documentModel.php';
$model = new DocumentModel($db);

$student_id = $_GET['student_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['document'])) {
    if ($_FILES['document']['error'] === UPLOAD_ERR_OK) {
        $orig = $_FILES['document']['name'];
        $ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
        $allowed = ['pdf', 'doc', 'docx', 'jpg', 'png'];
        if (in_array($ext, $allowed)) {
            $filename = uniqid('doc_').'.'.$ext;
            move_uploaded_file($_FILES['document']['tmp_name'], 'uploads/documents/'.$filename);
            $model->addDocument($student_id, $filename, $orig);
        }
    }
    header('Location: index.php?page=documents&student_id='.$student_id);
    exit;
}

if (isset($_GET['delete'])) {
    $model->deleteDocument($_GET['delete']);
    header('Location: index.php?page=documents&student_id='.$student_id);
    exit;
}

$documents = $model->getDocumentsByStudent($student_id);
$title = "Dokumentumok";
$content = 'views/documents.php';
include 'views/layout.php';
