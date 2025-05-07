<?php
require_once __DIR__.'/../models/studentModel.php';
$model = new StudentModel($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $model->addStudent(
        $_POST['om_azonosito'],
        $_POST['lastname'],
        $_POST['firstname'],
        $_POST['birthdate'],
        $_POST['class']
    );
    header('Location: index.php?page=students');
    exit;
}

$students = $model->getAllStudents();
$title = "Tanulók nyilvántartása";
$content = 'views/students.php';
include 'views/layout.php';
