<?php
require_once __DIR__.'/../models/studentModel.php';

$model = new StudentModel($db);
$students = $model->getAllStudents();

$title = "Tanulók nyilvántartása";
$content = 'views/students.php';
include 'views/layout.php';
