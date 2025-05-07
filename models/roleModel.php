<?php
class RoleModel {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getAllRoles() {
        $stmt = $this->db->query("SELECT * FROM roles ORDER BY role_name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRolePermissions($roleId) {
        $stmt = $this->db->prepare("
            SELECT p.perm_key 
            FROM role_permission rp
            JOIN permissions p ON rp.perm_id = p.id
            WHERE rp.role_id = ?
        ");
        $stmt->execute([$roleId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }
}
