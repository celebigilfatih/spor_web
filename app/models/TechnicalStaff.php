<?php
/**
 * TechnicalStaff Model
 * Teknik kadro için model sınıfı
 */
class TechnicalStaff extends Model
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
}