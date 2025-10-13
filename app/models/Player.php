<?php
/**
 * Player Model
 * Oyuncular için model sınıfı
 */
class Player extends Model
{
    protected $table = 'players';

    /**
     * Tüm oyuncuları getir (admin paneli için)
     */
    public function getAllPlayers()
    {
        $sql = "SELECT p.*, t.name as team_name 
                FROM {$this->table} p 
                LEFT JOIN teams t ON p.team_id = t.id 
                ORDER BY p.last_name ASC, p.first_name ASC";
        
        return $this->db->query($sql);
    }

    /**
     * Aktif oyuncuları getir
     */
    public function getActivePlayers()
    {
        $sql = "SELECT p.*, t.name as team_name 
                FROM {$this->table} p 
                LEFT JOIN teams t ON p.team_id = t.id 
                WHERE p.status = 'active' 
                ORDER BY p.jersey_number ASC";
        
        return $this->db->query($sql);
    }

    /**
     * Takıma göre oyuncuları getir
     */
    public function getByTeam($teamId)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE team_id = :team_id AND status = 'active' 
                ORDER BY jersey_number ASC";
        
        return $this->db->query($sql, ['team_id' => $teamId]);
    }

    /**
     * Pozisyona göre oyuncuları getir
     */
    public function getByPosition($position, $teamId = null)
    {
        $sql = "SELECT p.*, t.name as team_name 
                FROM {$this->table} p 
                LEFT JOIN teams t ON p.team_id = t.id 
                WHERE p.position = :position AND p.status = 'active'";
        
        $params = ['position' => $position];
        
        if ($teamId) {
            $sql .= " AND p.team_id = :team_id";
            $params['team_id'] = $teamId;
        }
        
        $sql .= " ORDER BY p.jersey_number ASC";
        
        return $this->db->query($sql, $params);
    }

    /**
     * Oyuncu detaylarını istatistiklerle getir
     */
    public function getPlayerWithStats($id)
    {
        // Oyuncu bilgisi
        $sql = "SELECT p.*, t.name as team_name 
                FROM {$this->table} p 
                LEFT JOIN teams t ON p.team_id = t.id 
                WHERE p.id = :id";
        
        $player = $this->db->query($sql, ['id' => $id]);
        if (!$player) return null;
        
        $player = $player[0];
        
        // Oyuncu istatistikleri
        $statsSql = "SELECT 
                        SUM(goals) as total_goals,
                        SUM(assists) as total_assists,
                        SUM(yellow_cards) as total_yellow_cards,
                        SUM(red_cards) as total_red_cards,
                        SUM(minutes_played) as total_minutes,
                        SUM(appearances) as total_appearances
                     FROM statistics 
                     WHERE player_id = :player_id";
        
        $stats = $this->db->query($statsSql, ['player_id' => $id]);
        $player['stats'] = $stats ? $stats[0] : [];
        
        return $player;
    }

    /**
     * En iyi oyuncuları getir (gol krallığı vs.)
     */
    public function getTopScorers($season = null, $limit = 10)
    {
        $sql = "SELECT p.first_name, p.last_name, p.jersey_number, p.photo, t.name as team_name,
                       SUM(s.goals) as total_goals
                FROM {$this->table} p
                LEFT JOIN teams t ON p.team_id = t.id
                LEFT JOIN statistics s ON p.id = s.player_id
                WHERE p.status = 'active'";
        
        $params = [];
        if ($season) {
            $sql .= " AND s.season = :season";
            $params['season'] = $season;
        }
        
        $sql .= " GROUP BY p.id
                  HAVING total_goals > 0
                  ORDER BY total_goals DESC
                  LIMIT {$limit}";
        
        return $this->db->query($sql, $params);
    }

    /**
     * Forma numarası kontrolü
     */
    public function isJerseyNumberTaken($number, $teamId, $excludePlayerId = null)
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} 
                WHERE jersey_number = :number AND team_id = :team_id AND status = 'active'";
        
        $params = [
            'number' => $number,
            'team_id' => $teamId
        ];
        
        if ($excludePlayerId) {
            $sql .= " AND id != :exclude_id";
            $params['exclude_id'] = $excludePlayerId;
        }
        
        $result = $this->db->query($sql, $params);
        return $result[0]['count'] > 0;
    }

    /**
     * Kaptanları getir
     */
    public function getCaptains()
    {
        $sql = "SELECT p.*, t.name as team_name 
                FROM {$this->table} p 
                LEFT JOIN teams t ON p.team_id = t.id 
                WHERE p.is_captain = 1 AND p.status = 'active' 
                ORDER BY t.name ASC";
        
        return $this->db->query($sql);
    }

    /**
     * Yaralanmış oyuncuları getir
     */
    public function getInjuredPlayers()
    {
        $sql = "SELECT p.*, t.name as team_name 
                FROM {$this->table} p 
                LEFT JOIN teams t ON p.team_id = t.id 
                WHERE p.status = 'injured' 
                ORDER BY p.last_name ASC";
        
        return $this->db->query($sql);
    }

    /**
     * Yaş hesapla
     */
    public function calculateAge($birthDate)
    {
        $today = new DateTime();
        $birth = new DateTime($birthDate);
        return $today->diff($birth)->y;
    }

    /**
     * Oyuncu arama
     */
    public function searchPlayers($keyword)
    {
        $sql = "SELECT p.*, t.name as team_name 
                FROM {$this->table} p 
                LEFT JOIN teams t ON p.team_id = t.id 
                WHERE (p.first_name LIKE :keyword OR p.last_name LIKE :keyword) 
                AND p.status = 'active' 
                ORDER BY p.last_name ASC";
        
        return $this->db->query($sql, ['keyword' => "%{$keyword}%"]);
    }
}