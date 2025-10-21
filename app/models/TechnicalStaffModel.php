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
                (name, role, experience_years, license, bio, photo, team_id, status, sort_order, created_at) 
                VALUES 
                (:name, :role, :experience_years, :license, :bio, :photo, :team_id, :status, :sort_order, NOW())";
        
        return $this->db->execute($sql, [
            'name' => $data['name'] ?? '',
            'role' => $data['role'] ?? '',
            'experience_years' => $data['experience'] ?? 0,
            'license' => $data['license'] ?? '',
            'bio' => $data['bio'] ?? '',
            'photo' => $data['photo'] ?? null,
            'team_id' => $data['team_id'] ?? null,
            'status' => $data['status'] ?? 'active',
            'sort_order' => $data['sort_order'] ?? 0
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

        if (isset($data['role'])) {
            $fields[] = 'role = :role';
            $params['role'] = $data['role'];
        }

        if (isset($data['experience'])) {
            $fields[] = 'experience_years = :experience_years';
            $params['experience_years'] = $data['experience'];
        }

        if (isset($data['license'])) {
            $fields[] = 'license = :license';
            $params['license'] = $data['license'];
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

        if (isset($data['sort_order'])) {
            $fields[] = 'sort_order = :sort_order';
            $params['sort_order'] = $data['sort_order'];
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
                ORDER BY ts.role ASC, ts.name ASC";
        
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
                ORDER BY ts.sort_order ASC, ts.role ASC";
        
        return $this->db->query($sql);
    }

    /**
     * Takıma göre teknik kadroyu getir
     */
    public function getByTeam($teamId)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE (team_id = :team_id OR team_id IS NULL) AND status = 'active' 
                ORDER BY sort_order ASC";
        
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
                WHERE ts.role = :role AND ts.status = 'active' 
                ORDER BY ts.sort_order ASC";
        
        return $this->db->query($sql, ['role' => $role]);
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
                WHERE ts.role IN ('Baş Antrenör', 'Antrenör', 'Antrenör Yardımcısı') 
                AND ts.status = 'active' 
                ORDER BY ts.sort_order ASC";
        
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
                WHERE ts.role NOT IN ('Baş Antrenör', 'Antrenör', 'Antrenör Yardımcısı') 
                AND ts.status = 'active' 
                ORDER BY ts.sort_order ASC";
        
        return $this->db->query($sql);
    }

    /**
     * Genel personeli getir (takıma bağlı olmayan)
     */
    public function getGeneralStaff()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE team_id IS NULL AND status = 'active' 
                ORDER BY sort_order ASC";
        
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
            if (in_array($member['role'], ['Baş Antrenör', 'Antrenör', 'Antrenör Yardımcısı'])) {
                $grouped['coaches'][] = $member;
            } elseif (in_array($member['role'], ['Takım Doktoru', 'Fizyoterapist', 'Masör'])) {
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
                    COUNT(CASE WHEN role IN ('Baş Antrenör', 'Antrenör', 'Antrenör Yardımcısı') THEN 1 END) as coaches,
                    COUNT(CASE WHEN role IN ('Takım Doktoru', 'Fizyoterapist') THEN 1 END) as medical_staff,
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
                WHERE role = 'Baş Antrenör' AND status = 'active' 
                ORDER BY sort_order ASC 
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
                WHERE role LIKE '%Antrenör Yardımcısı%' AND status = 'active' 
                ORDER BY sort_order ASC";
        
        return $this->db->query($sql);
    }

    /**
     * Kaleci antrenörlerini getir
     */
    public function getGoalkeepingCoaches()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE role LIKE '%Kaleci%' AND status = 'active' 
                ORDER BY sort_order ASC";
        
        return $this->db->query($sql);
    }

    /**
     * Kondisyon antrenörlerini getir
     */
    public function getFitnessCoaches()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE role LIKE '%Kondisyon%' AND status = 'active' 
                ORDER BY sort_order ASC";
        
        return $this->db->query($sql);
    }

    /**
     * Sağlık personelini getir
     */
    public function getMedicalStaff()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE role IN ('Takım Doktoru', 'Fizyoterapist', 'Masör') AND status = 'active' 
                ORDER BY sort_order ASC";
        
        return $this->db->query($sql);
    }

    /**
     * Diğer personeli getir
     */
    public function getOtherStaff()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE role NOT IN ('Baş Antrenör', 'Antrenör Yardımcısı', 'Takım Doktoru', 'Fizyoterapist', 'Masör') 
                AND role NOT LIKE '%Kaleci%' 
                AND role NOT LIKE '%Kondisyon%' 
                AND status = 'active' 
                ORDER BY sort_order ASC";
        
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