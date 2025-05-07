<?php
class DocumentModel {
    private $db;
    public function __construct($db) { $this->db = $db; }

    public function addDocument($student_id, $filename, $original_name) {
        $stmt = $this->db->prepare("INSERT INTO documents (student_id, filename, original_name) VALUES (?, ?, ?)");
        return $stmt->execute([$student_id, $filename, $original_name]);
    }

    public function getDocumentsByStudent($student_id) {
        $stmt = $this->db->prepare("SELECT * FROM documents WHERE student_id=? ORDER BY uploaded_at DESC");
        $stmt->execute([$student_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteDocument($id) {
        $stmt = $this->db->prepare("SELECT filename FROM documents WHERE id=?");
        $stmt->execute([$id]);
        $file = $stmt->fetchColumn();
        if ($file) @unlink('uploads/documents/'.$file);
        $stmt = $this->db->prepare("DELETE FROM documents WHERE id=?");
        return $stmt->execute([$id]);
    }
}
