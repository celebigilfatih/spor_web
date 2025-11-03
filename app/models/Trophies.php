<?php
/**
 * Trophies Model
 * Kupa ve başarılar için model sınıfı
 */
class Trophies extends Model
{
    protected $table = 'trophies';

    /**
     * Tüm aktif kupaları getir
     */
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} WHERE status = 'active' ORDER BY sort_order ASC, id ASC";
        return $this->db->query($sql);
    }

    /**
     * ID'ye göre kupa getir
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $result = $this->db->query($sql, ['id' => $id]);
        return $result ? $result[0] : null;
    }

    /**
     * Yeni kupa oluştur
     */
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (category, title, count, years, description, image, sort_order, status) 
                VALUES (:category, :title, :count, :years, :description, :image, :sort_order, :status)";
        
        return $this->db->execute($sql, [
            'category' => $data['category'],
            'title' => $data['title'],
            'count' => $data['count'],
            'years' => $data['years'],
            'description' => $data['description'],
            'image' => $data['image'],
            'sort_order' => $data['sort_order'],
            'status' => $data['status']
        ]);
    }

    /**
     * Kupa güncelle
     */
    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
                category = :category,
                title = :title,
                count = :count,
                years = :years,
                description = :description,
                image = :image,
                sort_order = :sort_order,
                status = :status
                WHERE id = :id";
        
        return $this->db->execute($sql, [
            'id' => $id,
            'category' => $data['category'],
            'title' => $data['title'],
            'count' => $data['count'],
            'years' => $data['years'],
            'description' => $data['description'],
            'image' => $data['image'],
            'sort_order' => $data['sort_order'],
            'status' => $data['status']
        ]);
    }

    /**
     * Kupa sil
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

        if (empty($data['category'])) {
            $errors[] = 'Kategori gereklidir!';
        }

        if (empty($data['title'])) {
            $errors[] = 'Başlık gereklidir!';
        }

        return $errors;
    }

    /**
     * Kategorilere göre kupaları getir
     */
    public function getByCategory($category)
    {
        $sql = "SELECT * FROM {$this->table} WHERE category = :category AND status = 'active' ORDER BY sort_order ASC";
        return $this->db->query($sql, ['category' => $category]);
    }

    /**
     * Tüm aktif kupaları kategoriye göre grupla
     */
    public function getGroupedByCategory()
    {
        $sql = "SELECT * FROM {$this->table} WHERE status = 'active' ORDER BY category, sort_order ASC";
        $result = $this->db->query($sql);
        
        if (!$result) {
            return [];
        }

        $grouped = [];
        foreach ($result as $trophy) {
            $category = $trophy['category'];
            if (!isset($grouped[$category])) {
                $grouped[$category] = [];
            }
            $grouped[$category][] = $trophy;
        }

        return $grouped;
    }
}