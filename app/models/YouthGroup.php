<?php
/**
 * Youth Group Model
 * Alt yapı grupları için model sınıfı
 */
class YouthGroup extends Model
{
    protected $table = 'youth_groups';

    /**
     * Tüm grupları getir
     */
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} 
                ORDER BY min_age ASC";
        
        return $this->db->query($sql);
    }

    /**
     * Tüm aktif alt yapı gruplarını getir
     */
    public function getActive()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE status = 'active' 
                ORDER BY min_age ASC";
        
        return $this->db->query($sql);
    }

    /**
     * Sezona göre grupları getir
     */
    public function getBySeason($season = '2024-25')
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE season = :season 
                ORDER BY min_age ASC";
        
        return $this->db->query($sql, ['season' => $season]);
    }

    /**
     * Yaş grubuna göre grup getir
     */
    public function getByAgeGroup($ageGroup)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE age_group = :age_group 
                AND status = 'active' 
                LIMIT 1";
        
        $result = $this->db->query($sql, ['age_group' => $ageGroup]);
        return $result ? $result[0] : null;
    }

    /**
     * Grup kapasitesini kontrol et
     */
    public function hasCapacity($groupId)
    {
        $group = $this->findById($groupId);
        if (!$group) {
            return false;
        }
        
        return $group['current_count'] < $group['max_capacity'];
    }

    /**
     * Grup mevcudunu artır
     */
    public function incrementCount($groupId)
    {
        $sql = "UPDATE {$this->table} 
                SET current_count = current_count + 1 
                WHERE id = :id";
        
        return $this->db->execute($sql, ['id' => $groupId]);
    }

    /**
     * Grup mevcudunu azalt
     */
    public function decrementCount($groupId)
    {
        $sql = "UPDATE {$this->table} 
                SET current_count = current_count - 1 
                WHERE id = :id 
                AND current_count > 0";
        
        return $this->db->execute($sql, ['id' => $groupId]);
    }

    /**
     * İstatistikleri getir
     */
    public function getStatistics()
    {
        $sql = "SELECT 
                    COUNT(*) as total_groups,
                    SUM(current_count) as total_players,
                    SUM(max_capacity) as total_capacity,
                    COUNT(CASE WHEN status = 'active' THEN 1 END) as active_groups
                FROM {$this->table}";
        
        $result = $this->db->query($sql);
        return $result ? $result[0] : null;
    }

    /**
     * Yaş grubuna göre uygun grubu bul
     */
    public function findByAge($age)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE :age >= min_age 
                AND :age <= max_age 
                AND status = 'active' 
                ORDER BY min_age ASC 
                LIMIT 1";
        
        $result = $this->db->query($sql, ['age' => $age]);
        return $result ? $result[0] : null;
    }

    /**
     * Grup validasyonu
     */
    public function validate($data)
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors[] = 'Grup adı gereklidir.';
        }

        if (empty($data['age_group'])) {
            $errors[] = 'Yaş grubu gereklidir.';
        }

        if (empty($data['min_age']) || empty($data['max_age'])) {
            $errors[] = 'Minimum ve maksimum yaş gereklidir.';
        }

        if (!empty($data['min_age']) && !empty($data['max_age']) && $data['min_age'] >= $data['max_age']) {
            $errors[] = 'Minimum yaş, maksimum yaştan küçük olmalıdır.';
        }

        return $errors;
    }
}
