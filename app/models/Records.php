<?php
/**
 * Records Model
 * Kulüp rekorları için model sınıfı
 */
class Records extends Model
{
    protected $table = 'records';

    /**
     * Tüm aktif rekorları getir
     */
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} WHERE status = 'active' ORDER BY sort_order ASC, id ASC";
        return $this->db->query($sql);
    }

    /**
     * ID'ye göre rekor getir
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $result = $this->db->query($sql, ['id' => $id]);
        return $result ? $result[0] : null;
    }

    /**
     * Yeni rekor oluştur
     */
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (title, holder, value, description, category, image, sort_order, status) 
                VALUES (:title, :holder, :value, :description, :category, :image, :sort_order, :status)";
        
        return $this->db->execute($sql, [
            'title' => $data['title'],
            'holder' => $data['holder'],
            'value' => $data['value'],
            'description' => $data['description'],
            'category' => $data['category'],
            'image' => $data['image'],
            'sort_order' => $data['sort_order'],
            'status' => $data['status']
        ]);
    }

    /**
     * Rekor güncelle
     */
    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
                title = :title,
                holder = :holder,
                value = :value,
                description = :description,
                category = :category,
                image = :image,
                sort_order = :sort_order,
                status = :status
                WHERE id = :id";
        
        return $this->db->execute($sql, [
            'id' => $id,
            'title' => $data['title'],
            'holder' => $data['holder'],
            'value' => $data['value'],
            'description' => $data['description'],
            'category' => $data['category'],
            'image' => $data['image'],
            'sort_order' => $data['sort_order'],
            'status' => $data['status']
        ]);
    }

    /**
     * Rekor sil
     */
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        return $this->db->execute($sql, ['id' => $id]);
    }

    /**
     * Form validasyonu
     */
    public function validate($data)
    {
        $errors = [];

        if (empty($data['title'])) {
            $errors[] = 'Başlık gereklidir!';
        }

        if (empty($data['holder'])) {
            $errors[] = 'Sahip bilgisi gereklidir!';
        }

        return $errors;
    }

    /**
     * Kategoriye göre rekorları getir
     */
    public function getByCategory($category)
    {
        $sql = "SELECT * FROM {$this->table} WHERE category = :category AND status = 'active' ORDER BY sort_order ASC";
        return $this->db->query($sql, ['category' => $category]);
    }
}