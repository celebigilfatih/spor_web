<?php
/**
 * Legends Model
 * Kulüp efsaneleri için model sınıfı
 */
class Legends extends Model
{
    protected $table = 'legends';

    /**
     * Tüm aktif efsaneleri getir
     */
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} WHERE status = 'active' ORDER BY sort_order ASC, id ASC";
        return $this->db->query($sql);
    }

    /**
     * ID'ye göre efsane getir
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $result = $this->db->query($sql, ['id' => $id]);
        return $result ? $result[0] : null;
    }

    /**
     * Yeni efsane oluştur
     */
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (name, position, years, stats, bio, image, sort_order, status) 
                VALUES (:name, :position, :years, :stats, :bio, :image, :sort_order, :status)";
        
        return $this->db->execute($sql, [
            'name' => $data['name'],
            'position' => $data['position'],
            'years' => $data['years'],
            'stats' => $data['stats'],
            'bio' => $data['bio'],
            'image' => $data['image'],
            'sort_order' => $data['sort_order'],
            'status' => $data['status']
        ]);
    }

    /**
     * Efsane güncelle
     */
    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
                name = :name,
                position = :position,
                years = :years,
                stats = :stats,
                bio = :bio,
                image = :image,
                sort_order = :sort_order,
                status = :status
                WHERE id = :id";
        
        return $this->db->execute($sql, [
            'id' => $id,
            'name' => $data['name'],
            'position' => $data['position'],
            'years' => $data['years'],
            'stats' => $data['stats'],
            'bio' => $data['bio'],
            'image' => $data['image'],
            'sort_order' => $data['sort_order'],
            'status' => $data['status']
        ]);
    }

    /**
     * Efsane sil
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

        if (empty($data['name'])) {
            $errors[] = 'İsim gereklidir!';
        }

        return $errors;
    }
}