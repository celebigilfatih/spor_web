<?php

/**
 * Announcement Model
 * Duyuru veritabanı işlemleri
 */
class Announcement extends Model
{
    protected $table = 'announcements';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Tüm duyuruları getir
     */
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY published_at DESC, created_at DESC";
        return $this->db->query($sql);
    }

    /**
     * Aktif duyuruları getir
     */
    public function getActive($limit = null)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE status = 'active' 
                AND (published_at IS NULL OR published_at <= NOW())
                ORDER BY published_at DESC, created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT " . (int)$limit;
        }
        
        return $this->db->query($sql);
    }

    /**
     * ID'ye göre duyuru getir
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        return $result[0] ?? null;
    }

    /**
     * Yeni duyuru ekle
     */
    public function create($data)
    {
        $fields = [];
        $placeholders = [];
        
        foreach ($data as $key => $value) {
            $fields[] = $key;
            $placeholders[] = ':' . $key;
        }
        
        $sql = "INSERT INTO {$this->table} (" . implode(', ', $fields) . ") 
                VALUES (" . implode(', ', $placeholders) . ")";
        
        return $this->db->execute($sql, $data);
    }

    /**
     * Duyuru güncelle
     */
    public function update($id, $data)
    {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = $key . ' = :' . $key;
        }
        
        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";
        $data['id'] = $id;
        
        return $this->db->execute($sql, $data);
    }

    /**
     * Duyuru sil
     */
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        return $this->db->execute($sql, ['id' => $id]);
    }

    /**
     * Tip badge sınıfını al
     */
    public function getTypeBadge($type)
    {
        $badges = [
            'important' => 'bg-danger',
            'info' => 'bg-info',
            'warning' => 'bg-warning',
            'success' => 'bg-success'
        ];
        
        return $badges[$type] ?? 'bg-secondary';
    }

    /**
     * Tip label'ını al
     */
    public function getTypeLabel($type)
    {
        $labels = [
            'important' => 'ÖNEMLİ',
            'info' => 'BİLGİ',
            'warning' => 'UYARI',
            'success' => 'BAŞARILI'
        ];
        
        return $labels[$type] ?? 'BİLGİ';
    }
}
