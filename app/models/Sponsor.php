<?php
/**
 * Sponsor Model
 * Sadece görsel barındıran sponsor kayıtları
 */
class Sponsor extends Model
{
    protected $table = 'sponsors';

    /**
     * Aktif sponsorları getir
     */
    public function getActiveSponsors()
    {
        $sql = "SELECT * FROM {$this->table} WHERE status = 'active' ORDER BY sort_order ASC, id DESC";
        return $this->db->query($sql);
    }
}
