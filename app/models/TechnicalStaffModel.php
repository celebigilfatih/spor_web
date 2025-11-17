<?php
/**
 * TechnicalStaff Model
 * Teknik kadro için model sınıfı
 */
class TechnicalStaffModel extends Model
{
    protected $table = 'technical_staff';

    /**
     * Get staff member by ID
     */
    public function findById($id)
    {
        $sql = "SELECT ts.*, t.name as team_name 
                FROM {$this->table} ts 
                LEFT JOIN teams t ON ts.team_id = t.id 
                WHERE ts.id = :id";
        
        $result = $this->db->query($sql, ['id' => $id]);
        
        if (is_array($result) && !empty($result)) {
            return $result[0];
        }
        
        return null;
    }

    /**
     * Create new staff member
     */
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} 
                (name, position, experience_years, license_type, bio, photo, team_id, status, created_at) 
                VALUES 
                (:name, :position, :experience_years, :license_type, :bio, :photo, :team_id, :status, NOW())";
        
        return $this->db->execute($sql, [
            'name' => $data['name'] ?? '',
            'position' => $data['role'] ?? $data['position'] ?? '',
            'experience_years' => $data['experience'] ?? $data['experience_years'] ?? 0,
            'license_type' => $data['license'] ?? $data['license_type'] ?? '',
            'bio' => $data['bio'] ?? '',
            'photo' => $data['photo'] ?? null,
            'team_id' => $data['team_id'] ?? null,
            'status' => $data['status'] ?? 'active'
        ]);
    }

    /**
     * Update staff member
     */
    public function update($id, $data)
    {
        $fields = [];
        $params = ['id' => $id];

        if (isset($data['name'])) {
            $fields[] = 'name = :name';
            $params['name'] = $data['name'];
        }

        if (isset($data['role']) || isset($data['position'])) {
            $fields[] = 'position = :position';
            $params['position'] = $data['role'] ?? $data['position'];
        }

        if (isset($data['experience']) || isset($data['experience_years'])) {
            $fields[] = 'experience_years = :experience_years';
            $params['experience_years'] = $data['experience'] ?? $data['experience_years'];
        }

        if (isset($data['license']) || isset($data['license_type'])) {
            $fields[] = 'license_type = :license_type';
            $params['license_type'] = $data['license'] ?? $data['license_type'];
        }

        if (isset($data['bio'])) {
            $fields[] = 'bio = :bio';
            $params['bio'] = $data['bio'];
        }

        if (isset($data['photo'])) {
            $fields[] = 'photo = :photo';
            $params['photo'] = $data['photo'];
        }

        if (isset($data['team_id'])) {
            $fields[] = 'team_id = :team_id';
            $params['team_id'] = $data['team_id'];
        }

        if (isset($data['status'])) {
            $fields[] = 'status = :status';
            $params['status'] = $data['status'];
        }

        if (empty($fields)) {
            return false;
        }

        $fields[] = 'updated_at = NOW()';

        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";
        
        return $this->db->execute($sql, $params);
    }

    /**
     * Delete staff member
     */
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        return $this->db->execute($sql, ['id' => $id]);
    }

    /**
     * Get last database error
     */
    public function getLastError()
    {
        return $this->db->getLastError();
    }

    /**
     * Tüm teknik kadroyu getir (admin paneli için)
     */
    public function getAllStaff()
    {
        $sql = "SELECT ts.*, t.name as team_name 
                FROM {$this->table} ts 
                LEFT JOIN teams t ON ts.team_id = t.id 
                ORDER BY ts.position ASC, ts.name ASC";
        
        return $this->db->query($sql);
    }

    /**
     * Aktif teknik kadroyu getir
     */
    public function getActiveStaff()
    {
        $sql = "SELECT ts.*, t.name as team_name 
                FROM {$this->table} ts 
                LEFT JOIN teams t ON ts.team_id = t.id 
                WHERE ts.status = 'active' 
                ORDER BY ts.id ASC, ts.position ASC";
        
        return $this->db->query($sql);
    }

    /**
     * Takıma göre teknik kadroyu getir
     */
    public function getByTeam($teamId)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE (team_id = :team_id OR team_id IS NULL) AND status = 'active' 
                ORDER BY id ASC";
        
        return $this->db->query($sql, ['team_id' => $teamId]);
    }

    /**
     * Role göre personeli getir
     */
    public function getByRole($role)
    {
        $sql = "SELECT ts.*, t.name as team_name 
                FROM {$this->table} ts 
                LEFT JOIN teams t ON ts.team_id = t.id 
                WHERE ts.position = :position AND ts.status = 'active' 
                ORDER BY ts.id ASC";
        
        return $this->db->query($sql, ['position' => $role]);
    }

    /**
     * Baş antrenörleri getir
     */
    public function getHeadCoaches()
    {
        return $this->getByRole('Baş Antrenör');
    }

    /**
     * Antrenörleri getir
     */
    public function getCoaches()
    {
        $sql = "SELECT ts.*, t.name as team_name 
                FROM {$this->table} ts 
                LEFT JOIN teams t ON ts.team_id = t.id 
                WHERE position LIKE '%Antren%' 
                AND ts.status = 'active' 
                ORDER BY ts.id ASC";
        
        return $this->db->query($sql);
    }

    /**
     * Destek personelini getir (doktor, fizyoterapist vb.)
     */
    public function getSupportStaff()
    {
        $sql = "SELECT ts.*, t.name as team_name 
                FROM {$this->table} ts 
                LEFT JOIN teams t ON ts.team_id = t.id 
                WHERE position NOT LIKE '%Antren%' 
                AND ts.status = 'active' 
                ORDER BY ts.id ASC";
        
        return $this->db->query($sql);
    }

    /**
     * Genel personeli getir (takıma bağlı olmayan)
     */
    public function getGeneralStaff()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE team_id IS NULL AND status = 'active' 
                ORDER BY id ASC";
        
        return $this->db->query($sql);
    }

    /**
     * Teknik kadro kategorilere göre grupla
     */
    public function getGroupedStaff()
    {
        $staff = $this->getActiveStaff();
        $grouped = [
            'coaches' => [],
            'medical' => [],
            'support' => []
        ];

        foreach ($staff as $member) {
            $position = $member['position'] ?? '';
            if (stripos($position, 'Antrenör') !== false) {
                $grouped['coaches'][] = $member;
            } elseif (stripos($position, 'Doktor') !== false || stripos($position, 'Fizyoterapist') !== false || stripos($position, 'Masör') !== false) {
                $grouped['medical'][] = $member;
            } else {
                $grouped['support'][] = $member;
            }
        }

        return $grouped;
    }

    /**
     * Personel istatistikleri
     */
    public function getStaffStats()
    {
        $sql = "SELECT 
                    COUNT(*) as total_staff,
                    COUNT(CASE WHEN position LIKE '%Antrenör%' THEN 1 END) as coaches,
                    COUNT(CASE WHEN position LIKE '%Doktor%' OR position LIKE '%Fizyoterapist%' THEN 1 END) as medical_staff,
                    AVG(experience_years) as avg_experience
                FROM {$this->table} 
                WHERE status = 'active'";
        
        $result = $this->db->query($sql);
        return $result ? $result[0] : null;
    }

    /**
     * Baş antrenörü getir
     */
    public function getHeadCoach()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE position LIKE '%Baş Antren%' AND status = 'active' 
                ORDER BY id ASC 
                LIMIT 1";
        
        $result = $this->db->query($sql);
        return $result ? $result[0] : null;
    }

    /**
     * Antrenör yardımcılarını getir
     */
    public function getAssistantCoaches()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE position LIKE '%Antren%' 
                AND position NOT LIKE '%Baş Antren%' 
                AND position NOT LIKE '%Kaleci%' 
                AND position NOT LIKE '%Kondisyon%' 
                AND status = 'active' 
                ORDER BY id ASC";
        
        return $this->db->query($sql);
    }

    /**
     * Kaleci antrenörlerini getir
     */
    public function getGoalkeepingCoaches()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE position LIKE '%Kaleci%' AND status = 'active' 
                ORDER BY id ASC";
        
        return $this->db->query($sql);
    }

    /**
     * Kondisyon antrenörlerini getir
     */
    public function getFitnessCoaches()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE position LIKE '%Kondisyon%' AND status = 'active' 
                ORDER BY id ASC";
        
        return $this->db->query($sql);
    }

    /**
     * Sağlık personelini getir
     */
    public function getMedicalStaff()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE (position LIKE '%Doktor%' OR position LIKE '%Fizyoterapist%' OR position LIKE '%Masör%') 
                AND status = 'active' 
                ORDER BY id ASC";
        
        return $this->db->query($sql);
    }

    /**
     * Diğer personeli getir
     */
    public function getOtherStaff()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE position NOT LIKE '%Antren%' 
                AND position NOT LIKE '%Kaleci%' 
                AND position NOT LIKE '%Kondisyon%' 
                AND position NOT LIKE '%Doktor%' 
                AND position NOT LIKE '%Fizyoterapist%' 
                AND position NOT LIKE '%Masör%' 
                AND position NOT LIKE '%Başkan%' 
                AND position NOT LIKE '%Yönetici%' 
                AND status = 'active' 
                ORDER BY id ASC";
        
        return $this->db->query($sql);
    }

    /**
     * Başkanı getir
     */
    public function getPresident()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE position LIKE '%Başkan%' 
                AND position NOT LIKE '%Yardımcı%' 
                AND position NOT LIKE '%Başkan Yardımcı%' 
                AND status = 'active' 
                ORDER BY id ASC 
                LIMIT 1";
        
        $result = $this->db->query($sql);
        return $result ? $result[0] : null;
    }

    /**
     * Başkan yardımcılarını getir
     */
    public function getVicePresidents()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE (position LIKE '%Başkan Yardımcı%' OR position LIKE '%Yardımcı%') 
                AND status = 'active' 
                ORDER BY id ASC";
        
        return $this->db->query($sql);
    }

    /**
     * Yönetim kurulu üyelerini getir
     */
    public function getBoardMembers()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE position LIKE '%Yönetici%' 
                AND status = 'active' 
                ORDER BY id ASC";
        
        return $this->db->query($sql);
    }

    /**
     * Kariyer geçmişini getir
     */
    public function getCareerHistory($staffId)
    {
        // Mock data - can be replaced with real career history table
        return [
            ['year' => '2020-2024', 'position' => 'Baş Antrenör', 'club' => 'Kulübümüz'],
            ['year' => '2018-2020', 'position' => 'Antrenör Yardımcısı', 'club' => 'Önceki Kulüp']
        ];
    }

    /**
     * Personel başarılarını getir
     */
    public function getStaffAchievements($staffId)
    {
        // Mock data - can be replaced with real achievements table
        return [
            ['year' => '2023', 'achievement' => 'Lig Şampiyonluğu'],
            ['year' => '2022', 'achievement' => 'Kupa Finali']
        ];
    }

    /**
     * Antrenman felsefesini getir
     */
    public function getCoachingPhilosophy()
    {
        return [
            'title' => 'Antrenman Felsefemiz',
            'description' => 'Takımımızın gelişimi için modern ve bilimsel yöntemler kullanıyoruz.',
            'principles' => [
                'Oyuncu gelişimine odaklanma',
                'Takım ruhu ve disiplin',
                'Modern futbol anlayışı',
                'Bireysel yetenek geliştirme'
            ]
        ];
    }

    /**
     * Antrenman yöntemlerini getir
     */
    public function getTrainingMethods()
    {
        return [
            ['name' => 'Teknik Çalışmalar', 'description' => 'Bireysel teknik beceri geliştirme'],
            ['name' => 'Taktik Eğitim', 'description' => 'Takım taktikleri ve oyun sistemleri'],
            ['name' => 'Fiziksel Kondisyon', 'description' => 'Dayanaklılık ve kuvvet çalışmaları'],
            ['name' => 'Mental Koçluk', 'description' => 'Zihinsel dayanaklılık ve motivasyon']
        ];
    }

    /**
     * Gelişim programlarını getir
     */
    public function getDevelopmentPrograms()
    {
        return [
            ['name' => 'Genç Yetenek Programı', 'description' => 'Alt yapıdan A takıma geçiş programı'],
            ['name' => 'Profesyonel Gelişim', 'description' => 'A takım oyuncuları için özel program'],
            ['name' => 'Bireysel Antrenman', 'description' => 'Kişiye özel gelişim planları']
        ];
    }
}