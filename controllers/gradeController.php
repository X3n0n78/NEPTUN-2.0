<?php
require_once __DIR__.'/../models/gradeModel.php';
$model = new GradeModel($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $model->addGrade(
        $_POST['student_id'],
        $_POST['subject'],
        $_POST['grade'],
        $_POST['grade_date']
    );
    header('Location: index.php?page=grades');
    exit;
}

$grades = $model->getAllGrades();
$students = $model->getStudents();
$title = "Jegyek";
$content = 'views/grades.php';
include 'views/layout.php';
