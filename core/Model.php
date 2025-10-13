<?php
/**
 * Temel Model Sınıfı
 * Veritabanı işlemleri için ana sınıf
 */
class Model
{
    protected $db;
    protected $table;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Tüm kayıtları getir
     */
    public function findAll($orderBy = 'id DESC')
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY {$orderBy}";
        return $this->db->query($sql);
    }

    /**
     * ID'ye göre kayıt getir
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $params = ['id' => $id];
        $result = $this->db->query($sql, $params);
        return $result ? $result[0] : null;
    }

    /**
     * Belirli alanla kayıt getir
     */
    public function findBy($column, $value)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = :value";
        $params = ['value' => $value];
        return $this->db->query($sql, $params);
    }

    /**
     * Kayıt ekle
     */
    public function create($data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        
        return $this->db->execute($sql, $data);
    }

    /**
     * Kayıt güncelle
     */
    public function update($id, $data)
    {
        $set = [];
        foreach (array_keys($data) as $key) {
            $set[] = "{$key} = :{$key}";
        }
        $setClause = implode(', ', $set);
        
        $sql = "UPDATE {$this->table} SET {$setClause} WHERE id = :id";
        $data['id'] = $id;
        
        return $this->db->execute($sql, $data);
    }

    /**
     * Kayıt sil
     */
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $params = ['id' => $id];
        
        return $this->db->execute($sql, $params);
    }

    /**
     * Kayıt sayısını getir
     */
    public function count($where = '')
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        if ($where) {
            $sql .= " WHERE {$where}";
        }
        
        $result = $this->db->query($sql);
        return $result ? $result[0]['count'] : 0;
    }

    /**
     * Sayfalama için kayıtları getir
     */
    public function paginate($page = 1, $perPage = 10, $orderBy = 'id DESC')
    {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT * FROM {$this->table} ORDER BY {$orderBy} LIMIT {$perPage} OFFSET {$offset}";
        return $this->db->query($sql);
    }

    /**
     * Aktif kayıtları getir
     */
    public function findActive($limit = null)
    {
        $sql = "SELECT * FROM {$this->table} WHERE status = 'active' ORDER BY created_at DESC";
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        return $this->db->query($sql);
    }
}