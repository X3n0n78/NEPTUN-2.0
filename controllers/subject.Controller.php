<?php
require_once __DIR__.'/../models/subjectModel.php';
$model = new SubjectModel($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $model->addSubject($_POST['name']);
    header('Location: index.php?page=subjects');
    exit;
}

$subjects = $model->getAllSubjects();
$title = "Tantárgyak";
$content = 'views/subjects.php';
include 'views/layout.php';
