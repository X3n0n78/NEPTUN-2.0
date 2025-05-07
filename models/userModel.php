<?php
class UserModel {
    private $db;

    /**
     * Konstruktor - adatbázis kapcsolat injektálása
     * @param PDO $dbConnection PDO adatbázis kapcsolat
     */
    public function __construct(PDO $dbConnection) {
        $this->db = $dbConnection;
    }

    /**
     * Felhasználó regisztrációja
     */
    public function register($username, $password, $email, $lastname, $firstname) {
        $stmt = $this->db->prepare("
            INSERT INTO users (username, password, email, lastname, firstname)
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$username, $password, $email, $lastname, $firstname]);
    }
    
    

    /**
     * Bejelentkezés ellenőrzése
     */
    public function login($username, $password) {
        $stmt = $this->db->prepare("
            SELECT * FROM users 
            WHERE username = ?
        ");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    /**
     * Felhasználó szerepköreinek lekérdezése
     * @param int $userId Felhasználó azonosító
     * @return array Szerepkörök nevei
     */
    public function getRoles(int $userId): array {
        try {
            $stmt = $this->db->prepare("
                SELECT r.role_name 
                FROM user_role ur
                JOIN roles r ON ur.role_id = r.id
                WHERE ur.user_id = ?
            ");
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
            
        } catch (PDOException $e) {
            error_log("Hiba a szerepkörök lekérdezésekor: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Jogosultság ellenőrzése
     * @param int $userId Felhasználó azonosító
     * @param string $permKey Jogosultság kulcsa
     * @return bool Van-e jogosultság
     */
    public function hasPermission(int $userId, string $permKey): bool {
        try {
            $stmt = $this->db->prepare("
                SELECT COUNT(*) 
                FROM user_role ur
                JOIN role_permission rp ON ur.role_id = rp.role_id
                JOIN permissions p ON rp.perm_id = p.id
                WHERE ur.user_id = ? AND p.perm_key = ?
            ");
            $stmt->execute([$userId, $permKey]);
            return $stmt->fetchColumn() > 0;
            
        } catch (PDOException $e) {
            error_log("Hiba a jogosultság ellenőrzésekor: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Felhasználó keresése ID alapján
     */
    public function getUserById(int $userId) {
        $stmt = $this->db->prepare("
            SELECT * FROM users 
            WHERE id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getUserRoles($userId) {
        $stmt = $this->db->prepare("
            SELECT r.id 
            FROM user_role ur
            JOIN roles r ON ur.role_id = r.id
            WHERE ur.user_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function addRoleToUser($userId, $roleId) {
        $stmt = $this->db->prepare("
            INSERT IGNORE INTO user_role (user_id, role_id)
            VALUES (?, ?)
        ");
        return $stmt->execute([$userId, $roleId]);
    }

    public function removeRoleFromUser($userId, $roleId) {
        $stmt = $this->db->prepare("
            DELETE FROM user_role 
            WHERE user_id = ? AND role_id = ?
        ");
        return $stmt->execute([$userId, $roleId]);
    }

    public function getAllUsersWithRoles() {
        $stmt = $this->db->query("
            SELECT u.*, GROUP_CONCAT(r.role_name) AS roles
            FROM users u
            LEFT JOIN user_role ur ON u.id = ur.user_id
            LEFT JOIN roles r ON ur.role_id = r.id
            GROUP BY u.id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getUserByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

/**
     * Felhasználó törlése
     */
    public function deleteUser($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Felhasználó adatainak és szerepköreinek frissítése
     */
    public function updateUser($id, $data) {
        $this->db->beginTransaction();
        try {
            // Felhasználó adatainak frissítése
            if (!empty($data['password'])) {
                $stmt = $this->db->prepare("UPDATE users SET username=?, email=?, password=? WHERE id=?");
                $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
                $stmt->execute([$data['username'], $data['email'], $hashedPassword, $id]);
            } else {
                $stmt = $this->db->prepare("UPDATE users SET username=?, email=? WHERE id=?");
                $stmt->execute([$data['username'], $data['email'], $id]);
            }
            
            // Szerepkörök frissítése (a user_role táblában)
            $this->db->prepare("DELETE FROM user_role WHERE user_id = ?")->execute([$id]);
            foreach ($data['roles'] as $roleId) {
                $this->db->prepare("INSERT INTO user_role (user_id, role_id) VALUES (?, ?)")->execute([$id, $roleId]);
            }
            
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }
}

