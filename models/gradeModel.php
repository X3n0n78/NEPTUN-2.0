<?php
class GradeModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Összes jegy lekérdezése tanuló nevével együtt
    public function getAllGrades() {
        $stmt = $this->db->query("SELECT grades.*, students.lastname, students.firstname
                                  FROM grades
                                  JOIN students ON grades.student_id = students.id
                                  ORDER BY grade_date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Új jegy hozzáadása
    public function addGrade($student_id, $subject, $grade, $grade_date) {
        $stmt = $this->db->prepare("INSERT INTO grades (student_id, subject, grade, grade_date) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$student_id, $subject, $grade, $grade_date]);
    }

    // Jegy törlése ID alapján
    public function deleteGrade($id) {
        $stmt = $this->db->prepare("DELETE FROM grades WHERE id=?");
        return $stmt->execute([$id]);
    }

    // Egy jegy lekérdezése ID alapján
    public function getGradeById($id) {
        $stmt = $this->db->prepare("SELECT * FROM grades WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Jegy adatainak frissítése
    public function updateGrade($id, $student_id, $subject, $grade, $grade_date) {
        $stmt = $this->db->prepare("UPDATE grades SET student_id=?, subject=?, grade=?, grade_date=? WHERE id=?");
        return $stmt->execute([$student_id, $subject, $grade, $grade_date, $id]);
    }

    // Tanulók listája (jegy rögzítéshez)
    public function getStudents() {
        $stmt = $this->db->query("SELECT id, lastname, firstname FROM students ORDER BY lastname, firstname");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
