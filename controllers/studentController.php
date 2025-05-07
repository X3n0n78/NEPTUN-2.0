<?php
require_once __DIR__.'/../models/studentModel.php';

$model = new StudentModel($db);

if (isset($_GET['delete'])) {
    $student = $model->getStudentById($_GET['delete']);
    if ($student['photo']) {
        @unlink('uploads/'.$student['photo']);
    }
    $model->deleteStudent($_GET['delete']);
    header('Location: index.php?page=students');
    exit;
}

$editStudent = null;
if (isset($_GET['edit'])) {
    $editStudent = $model->getStudentById($_GET['edit']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_id'])) {
        // Képkezelés
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $allowed = ['jpg', 'jpeg', 'png'];
            $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
            
            if (in_array($ext, $allowed) && $_FILES['photo']['size'] < 2097152) {
                // Régi kép törlése
                if (!empty($_POST['old_photo'])) {
                    @unlink('uploads/'.$_POST['old_photo']);
                }

                // Új kép mentése
                $filename = 'student_'.$_POST['update_id'].'_'.time().'.'.$ext;
                move_uploaded_file(
                    $_FILES['photo']['tmp_name'], 
                    'uploads/'.$filename
                );
                $model->updateStudentPhoto($_POST['update_id'], $filename);
            }
        }

        // Képtörlés
        if (isset($_POST['delete_photo'])) {
            @unlink('uploads/'.$_POST['old_photo']);
            $model->deleteStudentPhoto($_POST['update_id']);
        }

        // Adatok frissítése
        $model->updateStudent(
            $_POST['update_id'],
            $_POST['om_azonosito'],
            $_POST['lastname'],
            $_POST['firstname'],
            $_POST['birthdate'],
            $_POST['class']
        );
    } else {
        // Új tanuló hozzáadása
        $model->addStudent(
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

$students = $model->getAllStudents();
$title = "Tanulók nyilvántartása";
$content = 'views/students.php';
include 'views/layout.php';
