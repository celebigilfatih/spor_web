<?php
/**
 * Achievements Model
 * Önemli başarılar için model sınıfı
 */
class Achievements extends Model
{
    protected $table = 'achievements';

    /**
     * Tüm aktif başarıları getir
     */
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} WHERE status = 'active' ORDER BY sort_order ASC, year DESC, id ASC";
        return $this->db->query($sql);
    }

    /**
     * ID'ye göre başarı getir
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $result = $this->db->query($sql, ['id' => $id]);
        return $result ? $result[0] : null;
    }

    /**
     * Yeni başarı oluştur
     */
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (title, description, category, year, image, sort_order, status) 
                VALUES (:title, :description, :category, :year, :image, :sort_order, :status)";
        
        return $this->db->execute($sql, [
            'title' => $data['title'],
            'description' => $data['description'],
            'category' => $data['category'],
            'year' => $data['year'],
            'image' => $data['image'],
            'sort_order' => $data['sort_order'],
            'status' => $data['status']
        ]);
    }

    /**
     * Başarı güncelle
     */
    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
                title = :title,
                description = :description,
                category = :category,
                year = :year,
                image = :image,
                sort_order = :sort_order,
                status = :status
                WHERE id = :id";
        
        return $this->db->execute($sql, [
            'id' => $id,
            'title' => $data['title'],
            'description' => $data['description'],
            'category' => $data['category'],
            'year' => $data['year'],
            'image' => $data['image'],
            'sort_order' => $data['sort_order'],
            'status' => $data['status']
        ]);
    }

    /**
     * Başarı sil
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

        return $errors;
    }

    /**
     * Kategoriye göre başarıları getir
     */
    public function getByCategory($category)
    {
        $sql = "SELECT * FROM {$this->table} WHERE category = :category AND status = 'active' ORDER BY sort_order ASC, year DESC";
        return $this->db->query($sql, ['category' => $category]);
    }

    /**
     * Yıla göre başarıları getir
     */
    public function getByYear($year)
    {
        $sql = "SELECT * FROM {$this->table} WHERE year = :year AND status = 'active' ORDER BY sort_order ASC";
        return $this->db->query($sql, ['year' => $year]);
    }
}