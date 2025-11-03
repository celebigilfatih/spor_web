<?php
/**
 * AboutUs Model
 * Hakkımızda sayfası için model sınıfı
 */
class AboutUs extends Model
{
    protected $table = 'about_us';

    /**
     * Tüm kayıtları getir
     */
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY sort_order ASC, id ASC";
        return $this->db->query($sql);
    }

    /**
     * ID'ye göre kayıt getir
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $result = $this->db->query($sql, ['id' => $id]);
        return $result ? $result[0] : null;
    }

    /**
     * Yeni kayıt oluştur
     */
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (section_name, title, content, image, sort_order, status) 
                VALUES (:section_name, :title, :content, :image, :sort_order, :status)";
        
        return $this->db->execute($sql, [
            'section_name' => $data['section_name'],
            'title' => $data['title'],
            'content' => $data['content'],
            'image' => $data['image'],
            'sort_order' => $data['sort_order'],
            'status' => $data['status']
        ]);
    }

    /**
     * Kayıt güncelle
     */
    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
                section_name = :section_name,
                title = :title,
                content = :content,
                image = :image,
                sort_order = :sort_order,
                status = :status
                WHERE id = :id";
        
        return $this->db->execute($sql, [
            'id' => $id,
            'section_name' => $data['section_name'] ?? '',
            'title' => $data['title'] ?? '',
            'content' => $data['content'] ?? '',
            'image' => $data['image'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'status' => $data['status'] ?? 'active'
        ]);
    }

    /**
     * Kayıt sil
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

        if (empty($data['section_name'])) {
            $errors[] = 'Bölüm adı gereklidir!';
        }

        if (empty($data['title'])) {
            $errors[] = 'Başlık gereklidir!';
        }

        if (empty($data['content'])) {
            $errors[] = 'İçerik gereklidir!';
        }

        return $errors;
    }

    /**
     * Aktif bölümleri getir
     */
    public function getActiveSections()
    {
        $sql = "SELECT * FROM {$this->table} WHERE status = 'active' ORDER BY sort_order ASC";
        return $this->db->query($sql);
    }

    /**
     * Bölüm adına göre içerik getir
     */
    public function getBySection($section)
    {
        $sql = "SELECT * FROM {$this->table} WHERE section = :section AND status = 'active' LIMIT 1";
        $result = $this->db->query($sql, ['section' => $section]);
        return $result ? $result[0] : null;
    }

    /**
     * Ana bölümleri getir (tarih, vizyon, misyon)
     */
    public function getMainSections()
    {
        try {
            $sections = ['history', 'vision', 'mission'];
            $sql = "SELECT * FROM {$this->table} 
                    WHERE section IN ('" . implode("','", $sections) . "') AND status = 'active' 
                    ORDER BY FIELD(section, '" . implode("','", $sections) . "')";
            
            $result = $this->db->query($sql);
            
            // Eğer veritabanında veri yoksa varsayılan içerik döndür
            if (empty($result)) {
                return $this->getDefaultSections();
            }
            
            return $result;
        } catch (Exception $e) {
            // Veritabanı tablosu yoksa varsayılan içerik döndür
            return $this->getDefaultSections();
        }
    }
    
    /**
     * Varsayılan bölümleri döndür
     */
    private function getDefaultSections()
    {
        return [
            [
                'id' => 1,
                'section' => 'history',
                'title' => 'Tarihçemiz',
                'content' => 'Spor kulübümüz 1928 yılında kurulmuş, 95 yıllık köklü bir geçmişe sahiptir. Kuruluşundan bu yana toplumun spor kültürünün gelişmesine katkıda bulunmaktadır.',
                'status' => 'active'
            ],
            [
                'id' => 2,
                'section' => 'vision',
                'title' => 'Vizyonumuz',
                'content' => 'Modern futbol anlayışını benimseyen, gençleri yetiştiren ve topluma değer katan bir spor kulübü olmak.',
                'status' => 'active'
            ],
            [
                'id' => 3,
                'section' => 'mission',
                'title' => 'Misyonumuz',
                'content' => 'Profesyonel futbol eğitimi vererek, geleceğin yıldızlarını yetiştirmek ve spor kültürünü geliştirmek.',
                'status' => 'active'
            ]
        ];
    }
    
    /**
     * Kulüp tarihini getir
     */
    public function getHistory()
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE section = 'history' AND status = 'active' LIMIT 1";
            $result = $this->db->query($sql);
            return $result ? $result[0] : $this->getDefaultHistory();
        } catch (Exception $e) {
            return $this->getDefaultHistory();
        }
    }
    
    /**
     * Önemli kilometre taşlarını getir
     */
    public function getMilestones()
    {
        try {
            $sql = "SELECT * FROM milestones WHERE status = 'active' ORDER BY year ASC";
            return $this->db->query($sql);
        } catch (Exception $e) {
            return $this->getDefaultMilestones();
        }
    }
    
    /**
     * Başarıları getir
     */
    public function getAchievements()
    {
        try {
            $sql = "SELECT * FROM achievements WHERE status = 'active' ORDER BY year DESC";
            return $this->db->query($sql);
        } catch (Exception $e) {
            return $this->getDefaultAchievements();
        }
    }
    
    /**
     * Kupaları getir
     */
    public function getTrophies()
    {
        try {
            $sql = "SELECT * FROM trophies WHERE status = 'active' ORDER BY category, year DESC";
            return $this->db->query($sql);
        } catch (Exception $e) {
            return $this->getDefaultTrophies();
        }
    }
    
    /**
     * Varsayılan tarih bilgisini döndür
     */
    private function getDefaultHistory()
    {
        return [
            'id' => 1,
            'section' => 'history',
            'title' => 'Kulüp Tarihi',
            'content' => 'Spor kulübümüz 1928 yılında kurulmuş, 95 yıllık köklü bir geçmişe sahiptir. Kurulduğundan bu yana Türk futboluna önemli katkılarda bulunmaktadır.',
            'status' => 'active'
        ];
    }
    
    /**
     * Varsayılan kilometre taşlarını döndür
     */
    private function getDefaultMilestones()
    {
        return [
            ['year' => 1928, 'title' => 'Kuruluş', 'description' => 'Kulübün kuruluşu'],
            ['year' => 1952, 'title' => 'İlk Şampiyonluk', 'description' => 'İlk büyük başarı'],
            ['year' => 1995, 'title' => 'Avrupa Kupası', 'description' => 'Uluslararası arena']
        ];
    }
    
    /**
     * Varsayılan başarıları döndür
     */
    private function getDefaultAchievements()
    {
        return [
            ['year' => 2023, 'title' => '15. Şampiyonluk', 'category' => 'League'],
            ['year' => 2023, 'title' => '8. Kupa Zaferi', 'category' => 'Cup']
        ];
    }
    
    /**
     * Varsayılan kupaları döndür
     */
    private function getDefaultTrophies()
    {
        return [
            ['category' => 'League', 'count' => 15, 'years' => '1952, 1967, 1973, 1985, 1992, 1998, 2003, 2007, 2012, 2018, 2021, 2022, 2023, 2024, 2025'],
            ['category' => 'Cup', 'count' => 8, 'years' => '1965, 1978, 1987, 1995, 2005, 2015, 2020, 2023']
        ];
    }
}