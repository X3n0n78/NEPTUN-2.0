<?php
class UserModel {
    private $db;
    public function __construct($db) { $this->db = $db; }

    public function register($lastname, $firstname, $username, $password) {
        $stmt = $this->db->prepare("INSERT INTO users (lastname, firstname, username, password) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$lastname, $firstname, $username, password_hash($password, PASSWORD_DEFAULT)]);
    }

    public function login($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
