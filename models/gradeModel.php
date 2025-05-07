<?php
class GradeModel {
    private $db;
    public function __construct($db) { $this->db = $db; }

    public function getAllGrades() {
        $stmt = $this->db->query("SELECT grades.*, students.lastname, students.firstname
                                  FROM grades
                                  JOIN students ON grades.student_id = students.id
                                  ORDER BY grade_date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addGrade($student_id, $subject, $grade, $grade_date) {
        $stmt = $this->db->prepare("INSERT INTO grades (student_id, subject, grade, grade_date) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$student_id, $subject, $grade, $grade_date]);
    }

    public function getStudents() {
        $stmt = $this->db->query("SELECT id, lastname, firstname FROM students ORDER BY lastname, firstname");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
