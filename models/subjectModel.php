<?php
class SubjectModel {
    private $db;
    public function __construct($db) { $this->db = $db; }

    public function getAllSubjects() {
        $stmt = $this->db->query("SELECT * FROM subjects ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addSubject($name) {
        $stmt = $this->db->prepare("INSERT INTO subjects (name) VALUES (?)");
        return $stmt->execute([$name]);
    }
}
