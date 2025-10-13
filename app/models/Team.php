<?php
/**
 * Team Model
 * Takımlar için model sınıfı
 */
class Team extends Model
{
    protected $table = 'teams';

    /**
     * Tüm takımları getir (Admin panel için)
     */
    public function getAllTeams()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY sort_order ASC, name ASC";
        return $this->db->query($sql);
    }

    /**
     * Aktif takımları getir
     */
    public function getActiveTeams()
    {
        $sql = "SELECT * FROM {$this->table} WHERE status = 'active' ORDER BY sort_order ASC, name ASC";
        return $this->db->query($sql);
    }

    /**
     * Takım detaylarını oyuncularla birlikte getir
     */
    public function getTeamWithPlayers($id)
    {
        // Takım bilgisi
        $team = $this->findById($id);
        if (!$team) return null;

        // Takım oyuncuları
        $sql = "SELECT * FROM players WHERE team_id = :team_id AND status = 'active' ORDER BY jersey_number ASC";
        $players = $this->db->query($sql, ['team_id' => $id]);
        
        $team['players'] = $players ?: [];
        return $team;
    }

    /**
     * Takım istatistiklerini getir
     */
    public function getTeamStats($id)
    {
        $sql = "SELECT 
                    COUNT(p.id) as total_players,
                    AVG(p.height) as avg_height,
                    AVG(p.weight) as avg_weight,
                    COUNT(CASE WHEN p.nationality = 'Türkiye' THEN 1 END) as turkish_players,
                    COUNT(CASE WHEN p.nationality != 'Türkiye' THEN 1 END) as foreign_players
                FROM players p 
                WHERE p.team_id = :team_id AND p.status = 'active'";
        
        $result = $this->db->query($sql, ['team_id' => $id]);
        return $result ? $result[0] : null;
    }

    /**
     * Yaş grubuna göre takım getir
     */
    public function getByAgeGroup($ageGroup)
    {
        $sql = "SELECT * FROM {$this->table} WHERE age_group = :age_group AND status = 'active'";
        $result = $this->db->query($sql, ['age_group' => $ageGroup]);
        return $result ? $result[0] : null;
    }

    /**
     * Ana takımı getir (A Takım)
     */
    public function getMainTeam()
    {
        $sql = "SELECT * FROM {$this->table} WHERE age_group = 'Senior' AND status = 'active' LIMIT 1";
        $result = $this->db->query($sql);
        return $result ? $result[0] : null;
    }

    /**
     * Takımın son maçlarını getir
     */
    public function getRecentMatches($teamId, $limit = 5)
    {
        $sql = "SELECT * FROM matches 
                WHERE team_id = :team_id AND status = 'finished' 
                ORDER BY match_date DESC 
                LIMIT {$limit}";
        
        return $this->db->query($sql, ['team_id' => $teamId]);
    }

    /**
     * Takımın gelecek maçlarını getir
     */
    public function getUpcomingMatches($teamId, $limit = 5)
    {
        $sql = "SELECT * FROM matches 
                WHERE team_id = :team_id AND status = 'scheduled' 
                ORDER BY match_date ASC 
                LIMIT {$limit}";
        
        return $this->db->query($sql, ['team_id' => $teamId]);
    }

    /**
     * Teknik kadroyu getir
     */
    public function getTechnicalStaff($teamId)
    {
        $sql = "SELECT * FROM technical_staff 
                WHERE (team_id = :team_id OR team_id IS NULL) AND status = 'active' 
                ORDER BY sort_order ASC";
        
        return $this->db->query($sql, ['team_id' => $teamId]);
    }
}