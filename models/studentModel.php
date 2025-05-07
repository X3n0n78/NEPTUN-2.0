<?php
class StudentModel {
    private $db;
    public function __construct($db) { $this->db = $db; }

    public function getAllStudents() {
        $stmt = $this->db->query("SELECT * FROM students ORDER BY lastname, firstname");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addStudent($om, $lastname, $firstname, $birthdate, $class) {
        $stmt = $this->db->prepare("INSERT INTO students (om_azonosito, lastname, firstname, birthdate, class) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$om, $lastname, $firstname, $birthdate, $class]);
    }
}
