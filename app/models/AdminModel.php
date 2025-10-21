<?php
/**
 * Admin Model
 * Admin user management
 */
class AdminModel extends Model
{
    protected $table = 'admins';

    /**
     * Get all admins
     */
    public function getAll()
    {
        $sql = "SELECT id, username, email, full_name, role, status, last_login, created_at, updated_at 
                FROM {$this->table} 
                ORDER BY created_at DESC";
        
        $result = $this->db->query($sql);
        return is_array($result) ? $result : [];
    }

    /**
     * Get admin by ID
     */
    public function getById($id)
    {
        $sql = "SELECT id, username, email, full_name, role, status, last_login, created_at, updated_at 
                FROM {$this->table} 
                WHERE id = :id";
        
        $result = $this->db->query($sql, ['id' => $id]);
        
        if (is_array($result) && !empty($result)) {
            return $result[0];
        }
        
        return null;
    }

    /**
     * Get admin by username
     */
    public function getByUsername($username)
    {
        $sql = "SELECT * FROM {$this->table} WHERE username = :username";
        
        $result = $this->db->query($sql, ['username' => $username]);
        
        if (is_array($result) && !empty($result)) {
            return $result[0];
        }
        
        return null;
    }

    /**
     * Get admin by email
     */
    public function getByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        
        $result = $this->db->query($sql, ['email' => $email]);
        
        if (is_array($result) && !empty($result)) {
            return $result[0];
        }
        
        return null;
    }

    /**
     * Create new admin
     */
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (username, email, password, full_name, role, status, created_at) 
                VALUES (:username, :email, :password, :full_name, :role, :status, NOW())";
        
        return $this->db->execute($sql, [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'full_name' => $data['full_name'] ?? '',
            'role' => $data['role'] ?? 'admin',
            'status' => $data['status'] ?? 'active'
        ]);
    }

    /**
     * Update admin
     */
    public function update($id, $data)
    {
        $fields = [];
        $params = ['id' => $id];

        if (isset($data['username'])) {
            $fields[] = 'username = :username';
            $params['username'] = $data['username'];
        }

        if (isset($data['email'])) {
            $fields[] = 'email = :email';
            $params['email'] = $data['email'];
        }

        if (isset($data['full_name'])) {
            $fields[] = 'full_name = :full_name';
            $params['full_name'] = $data['full_name'];
        }

        if (isset($data['role'])) {
            $fields[] = 'role = :role';
            $params['role'] = $data['role'];
        }

        if (isset($data['status'])) {
            $fields[] = 'status = :status';
            $params['status'] = $data['status'];
        }

        if (isset($data['password'])) {
            $fields[] = 'password = :password';
            $params['password'] = $data['password'];
        }

        if (empty($fields)) {
            return false;
        }

        $fields[] = 'updated_at = NOW()';

        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";
        
        return $this->db->execute($sql, $params);
    }

    /**
     * Delete admin
     */
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        return $this->db->execute($sql, ['id' => $id]);
    }

    /**
     * Check if username exists
     */
    public function usernameExists($username, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE username = :username";
        $params = ['username' => $username];

        if ($excludeId) {
            $sql .= " AND id != :id";
            $params['id'] = $excludeId;
        }

        $result = $this->db->query($sql, $params);
        
        if (is_array($result) && !empty($result)) {
            return $result[0]['count'] > 0;
        }
        
        return false;
    }

    /**
     * Check if email exists
     */
    public function emailExists($email, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE email = :email";
        $params = ['email' => $email];

        if ($excludeId) {
            $sql .= " AND id != :id";
            $params['id'] = $excludeId;
        }

        $result = $this->db->query($sql, $params);
        
        if (is_array($result) && !empty($result)) {
            return $result[0]['count'] > 0;
        }
        
        return false;
    }

    /**
     * Update last login time
     */
    public function updateLastLogin($id)
    {
        $sql = "UPDATE {$this->table} SET last_login = NOW() WHERE id = :id";
        return $this->db->execute($sql, ['id' => $id]);
    }

    /**
     * Get statistics
     */
    public function getStatistics()
    {
        $sql = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active,
                SUM(CASE WHEN status = 'inactive' THEN 1 ELSE 0 END) as inactive,
                SUM(CASE WHEN role = 'super_admin' THEN 1 ELSE 0 END) as super_admins,
                SUM(CASE WHEN role = 'admin' THEN 1 ELSE 0 END) as regular_admins
                FROM {$this->table}";
        
        $result = $this->db->query($sql);
        
        if (is_array($result) && !empty($result)) {
            return $result[0];
        }
        
        return [
            'total' => 0,
            'active' => 0,
            'inactive' => 0,
            'super_admins' => 0,
            'regular_admins' => 0
        ];
    }
}
