<?php
class DocumentModel {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function addDocument($student_id, $filename, $original_name, $uploader_id) {
        $stmt = $this->db->prepare("
            INSERT INTO documents 
                (student_id, filename, original_name, uploader_id) 
            VALUES 
                (?, ?, ?, ?)
        ");
        return $stmt->execute([$student_id, $filename, $original_name, $uploader_id]);
    }

    public function getDocumentsByStudent($student_id) {
        $stmt = $this->db->prepare("
            SELECT d.*, u.username 
            FROM documents d
            LEFT JOIN users u ON d.uploader_id = u.id
            WHERE d.student_id = ?
            ORDER BY d.uploaded_at DESC
        ");
        $stmt->execute([$student_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDocumentById($id) {
        $stmt = $this->db->prepare("SELECT * FROM documents WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteDocument($id) {
        $stmt = $this->db->prepare("DELETE FROM documents WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
