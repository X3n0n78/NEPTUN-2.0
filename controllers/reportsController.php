<?php

require_once __DIR__.'/../models/gradeModel.php';
require_once __DIR__.'/../models/studentModel.php';
require_once __DIR__.'/../models/subjectModel.php';

$gradeModel = new GradeModel($db);
$studentModel = new StudentModel($db);
$subjectModel = new SubjectModel($db);

$studentAverages = $gradeModel->getAverageGrades();
$subjectAverages = $gradeModel->getSubjectAverages();

$title = "Statisztikai jelentések";
$content = 'views/reports.php';
include 'views/layout.php';
