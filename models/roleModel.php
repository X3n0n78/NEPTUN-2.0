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
    public function getAllRolesWithPermissions() {
        $stmt = $this->db->query("
            SELECT r.id, r.role_name, GROUP_CONCAT(p.perm_key) AS permissions
            FROM roles r
            LEFT JOIN role_permission rp ON r.id = rp.role_id
            LEFT JOIN permissions p ON rp.perm_id = p.id
            GROUP BY r.id
        ");
        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // NINCS &-es foreach!
        foreach ($roles as $key => $role) {
            if (empty($role['permissions'])) {
                $roles[$key]['permissions'] = [];
            } else {
                $roles[$key]['permissions'] = explode(',', $role['permissions']);
            }
        }
        return $roles;
    }
    
    
    
    
    
    public function getRoleById($id) {
        $stmt = $this->db->prepare("SELECT * FROM roles WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function createRole($name, $permissions = []) {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare("INSERT INTO roles (role_name) VALUES (?)");
            $stmt->execute([$name]);
            $roleId = $this->db->lastInsertId();
            
            $this->updateRolePermissions($roleId, $permissions);
            
            $this->db->commit();
            return $roleId;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }
    
    public function updateRole($id, $name, $permissions = []) {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare("UPDATE roles SET role_name = ? WHERE id = ?");
            $stmt->execute([$name, $id]);
            
            $this->updateRolePermissions($id, $permissions);
            
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }
    
    public function deleteRole($id) {
        $this->db->beginTransaction();
        try {
            // Először töröljük a kapcsolódó jogosultságokat
            $stmt = $this->db->prepare("DELETE FROM role_permission WHERE role_id = ?");
            $stmt->execute([$id]);
            
            // Aztán töröljük a szerepkört
            $stmt = $this->db->prepare("DELETE FROM roles WHERE id = ?");
            $stmt->execute([$id]);
            
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }
    
    private function updateRolePermissions($roleId, $permissions) {
        // Töröljük a jelenlegi jogosultságokat
        $stmt = $this->db->prepare("DELETE FROM role_permission WHERE role_id = ?");
        $stmt->execute([$roleId]);
        
        // Adjuk hozzá az új jogosultságokat
        if (!empty($permissions)) {
            $stmt = $this->db->prepare("INSERT INTO role_permission (role_id, perm_id) VALUES (?, ?)");
            foreach ($permissions as $permId) {
                $stmt->execute([$roleId, $permId]);
            }
        }
    }
}
