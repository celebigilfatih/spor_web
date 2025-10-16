<?php
/**
 * TechnicalStaff Model
 * Teknik kadro için model sınıfı
 */
class TechnicalStaffModel extends Model
{
    protected $table = 'technical_staff';

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