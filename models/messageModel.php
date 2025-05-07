<?php
class MessageModel {
    private $db;
    
    public function __construct(PDO $db) {
        $this->db = $db;
    }
    
    public function saveMessage($name, $email, $subject, $message, $user_id = null) {
        $stmt = $this->db->prepare("
            INSERT INTO messages (name, email, subject, message, user_id, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        
        return $stmt->execute([$name, $email, $subject, $message, $user_id]);
    }
    
    public function getAllMessages() {
        $stmt = $this->db->query("
            SELECT m.*, u.username
            FROM messages m
            LEFT JOIN users u ON m.user_id = u.id
            ORDER BY m.created_at DESC
        ");
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
