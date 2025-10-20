<?php
/**
 * MatchModel
 * Maçlar için model sınıfı
 */
class MatchModel extends Model
{
    protected $table = 'matches';

    /**
     * Maç ekle
     */
    public function create($data)
    {
        // Temel sütunlar
        $columns = [
            'home_team',
            'away_team',
            'match_date',
            'venue',
            'status'
        ];
        
        // Opsiyonel sütunlar (varsa ekle)
        $optionalColumns = [
            'team_id',
            'competition',
            'league',
            'season',
            'match_week',
            'home_score',
            'away_score',
            'referee',
            'attendance',
            'weather_conditions',
            'match_report',
            'highlights_video'
        ];
        
        // Verilen verilerdeki geçerli sütunları kontrol et
        foreach ($optionalColumns as $column) {
            if (isset($data[$column])) {
                $columns[] = $column;
            }
        }
        
        // Sütunları ve yer tutucuları oluştur
        $columnList = implode(', ', $columns);
        $placeholders = ':' . implode(', :', $columns);
        
        $sql = "INSERT INTO {$this->table} ({$columnList}) VALUES ({$placeholders})";
        
        try {
            $result = $this->db->execute($sql, $data);
            return $result;
        } catch (Exception $e) {
            error_log("Match creation error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Tüm maçları getir (Admin panel için)
     */
    public function getAllMatches()
    {
        $sql = "SELECT m.*, t.name as team_name 
                FROM {$this->table} m 
                LEFT JOIN teams t ON m.team_id = t.id 
                ORDER BY m.match_date DESC";
        
        return $this->db->query($sql);
    }

    /**
     * Gelecek maçları getir
     */
    public function getUpcomingMatches($limit = 5)
    {
        $sql = "SELECT m.*, t.name as team_name 
                FROM {$this->table} m 
                LEFT JOIN teams t ON m.team_id = t.id 
                WHERE m.status = 'scheduled' AND m.match_date > NOW() 
                ORDER BY m.match_date ASC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql);
    }

    /**
     * Son maçları getir
     */
    public function getRecentMatches($limit = 5)
    {
        $sql = "SELECT m.*, t.name as team_name 
                FROM {$this->table} m 
                LEFT JOIN teams t ON m.team_id = t.id 
                WHERE m.status = 'finished' 
                ORDER BY m.match_date DESC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql);
    }

    /**
     * Takıma göre maçları getir
     */
    public function getByTeam($teamId, $status = null)
    {
        $sql = "SELECT * FROM {$this->table} WHERE team_id = :team_id";
        $params = ['team_id' => $teamId];
        
        if ($status) {
            $sql .= " AND status = :status";
            $params['status'] = $status;
        }
        
        $sql .= " ORDER BY match_date DESC";
        
        return $this->db->query($sql, $params);
    }

    /**
     * Sezona göre maçları getir
     */
    public function getBySeason($season)
    {
        $sql = "SELECT m.*, t.name as team_name 
                FROM {$this->table} m 
                LEFT JOIN teams t ON m.team_id = t.id 
                WHERE m.season = :season 
                ORDER BY m.match_date DESC";
        
        return $this->db->query($sql, ['season' => $season]);
    }

    /**
     * Maç sonuçlarını getir
     */
    public function getResults($limit = 10)
    {
        $sql = "SELECT m.*, t.name as team_name 
                FROM {$this->table} m 
                LEFT JOIN teams t ON m.team_id = t.id 
                WHERE m.status = 'finished' AND m.home_score IS NOT NULL 
                ORDER BY m.match_date DESC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql);
    }

    /**
     * Ev sahipliği maçları getir
     */
    public function getHomeMatches($teamName, $limit = null)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE home_team = :team_name 
                ORDER BY match_date DESC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql, ['team_name' => $teamName]);
    }

    /**
     * Deplasman maçları getir
     */
    public function getAwayMatches($teamName, $limit = null)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE away_team = :team_name 
                ORDER BY match_date DESC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql, ['team_name' => $teamName]);
    }

    /**
     * Maç istatistikleri
     */
    public function getMatchStats($season = null)
    {
        $sql = "SELECT 
                    COUNT(*) as total_matches,
                    COUNT(CASE WHEN status = 'finished' THEN 1 END) as played_matches,
                    COUNT(CASE WHEN status = 'scheduled' THEN 1 END) as upcoming_matches,
                    SUM(home_score) as total_goals_scored,
                    SUM(away_score) as total_goals_conceded
                FROM {$this->table}";
        
        $params = [];
        if ($season) {
            $sql .= " WHERE season = :season";
            $params['season'] = $season;
        }
        
        $result = $this->db->query($sql, $params);
        return $result ? $result[0] : null;
    }

    /**
     * Son form durumunu getir (son X maç)
     */
    public function getRecentForm($limit = 5)
    {
        $sql = "SELECT 
                    home_team,
                    away_team,
                    home_score,
                    away_score,
                    match_date,
                    venue
                FROM {$this->table} 
                WHERE status = 'finished' 
                ORDER BY match_date DESC 
                LIMIT {$limit}";
        
        return $this->db->query($sql);
    }
}
?>