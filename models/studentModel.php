<?php
class StudentModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getAllStudents() {
        $stmt = $this->db->query("SELECT * FROM students ORDER BY lastname, firstname");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addStudent($om, $lastname, $firstname, $birthdate, $class) {
        $stmt = $this->db->prepare("
            INSERT INTO students 
                (om_azonosito, lastname, firstname, birthdate, class) 
            VALUES 
                (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$om, $lastname, $firstname, $birthdate, $class]);
    }

    public function deleteStudent($id) {
        $stmt = $this->db->prepare("DELETE FROM students WHERE id=?");
        return $stmt->execute([$id]);
    }

    public function getStudentById($id) {
        $stmt = $this->db->prepare("SELECT * FROM students WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStudent($id, $om, $lastname, $firstname, $birthdate, $class) {
        $stmt = $this->db->prepare("
            UPDATE students SET 
                om_azonosito=?, 
                lastname=?, 
                firstname=?, 
                birthdate=?, 
                class=? 
            WHERE id=?
        ");
        return $stmt->execute([$om, $lastname, $firstname, $birthdate, $class, $id]);
    }

    public function updateStudentPhoto($id, $photo) {
        $stmt = $this->db->prepare("UPDATE students SET photo=? WHERE id=?");
        return $stmt->execute([$photo, $id]);
    }

    public function deleteStudentPhoto($id) {
        $stmt = $this->db->prepare("UPDATE students SET photo=NULL WHERE id=?");
        return $stmt->execute([$id]);
    }
}
