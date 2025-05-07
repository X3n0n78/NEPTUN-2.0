<?php
require_once __DIR__.'/../models/gradeModel.php';
require_once __DIR__.'/../models/studentModel.php';
require_once __DIR__.'/../models/subjectModel.php';

$model = new GradeModel($db);
$studentModel = new StudentModel($db);
$subjectModel = new SubjectModel($db);

$students = $studentModel->getAllStudents();
$subjects = $subjectModel->getAllSubjects();

// Törlés
if (isset($_GET['delete'])) {
    $model->deleteGrade($_GET['delete']);
    header('Location: index.php?page=grades');
    exit;
}

// Szerkesztés
$editGrade = null;
if (isset($_GET['edit'])) {
    $editGrade = $model->getGradeById($_GET['edit']);
}

// Hozzáadás vagy frissítés
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Frissítés
    if (isset($_POST['update_id'])) {
        $model->updateGrade(
            $_POST['update_id'],
            $_POST['student_id'],
            $_POST['subject'],
            $_POST['grade'],
            $_POST['grade_date']
        );
    } else {
        // Hozzáadás
        $model->addGrade(
            $_POST['student_id'],
            $_POST['subject'],
            $_POST['grade'],
            $_POST['grade_date']
        );
    }
    header('Location: index.php?page=grades');
    exit;
}

$grades = $model->getAllGrades();
$title = "Jegyek";
$content = 'views/grades.php';
include 'views/layout.php';
