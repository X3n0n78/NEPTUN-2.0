<?php
class GradeModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    // Összes jegy lekérdezése
    public function getAllGrades() {
        $stmt = $this->db->query("
            SELECT grades.*, 
                   students.lastname, 
                   students.firstname 
            FROM grades
            JOIN students ON grades.student_id = students.id
            ORDER BY grade_date DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Új jegy hozzáadása
    public function addGrade($student_id, $subject, $grade, $grade_date) {
        $stmt = $this->db->prepare("
            INSERT INTO grades 
                (student_id, subject, grade, grade_date) 
            VALUES 
                (?, ?, ?, ?)
        ");
        return $stmt->execute([$student_id, $subject, $grade, $grade_date]);
    }

    // Jegy törlése
    public function deleteGrade($id) {
        $stmt = $this->db->prepare("DELETE FROM grades WHERE id=?");
        return $stmt->execute([$id]);
    }

    // Jegy lekérdezése ID alapján
    public function getGradeById($id) {
        $stmt = $this->db->prepare("SELECT * FROM grades WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Jegy frissítése
    public function updateGrade($id, $student_id, $subject, $grade, $grade_date) {
        $stmt = $this->db->prepare("
            UPDATE grades SET 
                student_id=?, 
                subject=?, 
                grade=?, 
                grade_date=? 
            WHERE id=?
        ");
        return $stmt->execute([$student_id, $subject, $grade, $grade_date, $id]);
    }

    // Tanulók listája
    public function getStudents() {
        $stmt = $this->db->query("
            SELECT id, lastname, firstname 
            FROM students 
            ORDER BY lastname, firstname
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tanulók tantárgyankénti átlagai
    public function getAverageGrades() {
        $stmt = $this->db->query("
            SELECT 
                students.id, 
                CONCAT(students.lastname, ' ', students.firstname) AS name,
                subjects.name AS subject,
                AVG(grades.grade) AS average,
                COUNT(grades.id) AS grade_count
            FROM grades
            JOIN students ON grades.student_id = students.id
            JOIN subjects ON grades.subject = subjects.name
            GROUP BY students.id, subjects.name
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tantárgyankénti átlagok
    public function getSubjectAverages() {
        $stmt = $this->db->query("
            SELECT 
                subjects.name AS subject,
                AVG(grades.grade) AS average,
                COUNT(grades.id) AS grade_count
            FROM grades
            JOIN subjects ON grades.subject = subjects.name
            GROUP BY subjects.name
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
