<?php
/**
 * Admin Model
 * Admin kullanıcıları için model sınıfı
 */
class Admin extends Model
{
    protected $table = 'admins';

    /**
     * Email ile admin kullanıcı getir
     */
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email AND status = 'active'";
        $params = ['email' => $email];
        $result = $this->db->query($sql, $params);
        return $result ? $result[0] : null;
    }

    /**
     * Kullanıcı adı ile admin kullanıcı getir
     */
    public function findByUsername($username)
    {
        $sql = "SELECT * FROM {$this->table} WHERE username = :username AND status = 'active'";
        $params = ['username' => $username];
        $result = $this->db->query($sql, $params);
        return $result ? $result[0] : null;
    }

    /**
     * Şifre doğrula
     */
    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    /**
     * Şifre hash'le
     */
    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Admin kullanıcı oluştur
     */
    public function createAdmin($data)
    {
        $data['password'] = $this->hashPassword($data['password']);
        return $this->create($data);
    }

    /**
     * Şifre güncelle
     */
    public function updatePassword($id, $newPassword)
    {
        $hashedPassword = $this->hashPassword($newPassword);
        return $this->update($id, ['password' => $hashedPassword]);
    }

    /**
     * Son giriş zamanını güncelle
     */
    public function updateLastLogin($id)
    {
        $sql = "UPDATE {$this->table} SET last_login = CURRENT_TIMESTAMP WHERE id = :id";
        return $this->db->execute($sql, ['id' => $id]);
    }
}