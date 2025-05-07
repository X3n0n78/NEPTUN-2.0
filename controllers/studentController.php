<?php
require_once __DIR__.'/../models/studentModel.php';

$model = new StudentModel($db);

// --- TÖRLÉS (DELETE) ---
if (isset($_GET['delete'])) {
    $model->deleteStudent($_GET['delete']);
    header('Location: index.php?page=students');
    exit;
}

// --- SZERKESZTÉS (UPDATE) ---
$editStudent = null;
if (isset($_GET['edit'])) {
    $editStudent = $model->getStudentById($_GET['edit']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- ÚJ TANULÓ (CREATE) ---
    if (isset($_POST['om_azonosito'])) {
        $model->addStudent(
            $_POST['om_azonosito'],
            $_POST['lastname'],
            $_POST['firstname'],
            $_POST['birthdate'],
            $_POST['class']
        );
    }
    
    // --- FRISSÍTÉS (UPDATE) ---
    if (isset($_POST['update_id'])) {
        $model->updateStudent(
            $_POST['update_id'],
            $_POST['om_azonosito'],
            $_POST['lastname'],
            $_POST['firstname'],
            $_POST['birthdate'],
            $_POST['class']
        );
    }
    
    header('Location: index.php?page=students');
    exit;
}

// --- ADATOK LEKÉRÉSE (READ) ---
$students = $model->getAllStudents();

// --- NÉZET MEGJELENÍTÉSE ---
$title = "Tanulók nyilvántartása";
$content = 'views/students.php';
include 'views/layout.php';
