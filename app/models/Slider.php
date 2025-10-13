<?php
/**
 * Slider Model
 * Ana sayfa slider için model sınıfı
 */
class Slider extends Model
{
    protected $table = 'sliders';

    /**
     * Aktif slider'ları getir
     */
    public function getActiveSliders()
    {
        $sql = "SELECT * FROM {$this->table} WHERE status = 'active' ORDER BY sort_order ASC";
        return $this->db->query($sql);
    }

    /**
     * Slider sırasını güncelle
     */
    public function updateOrder($id, $newOrder)
    {
        return $this->update($id, ['sort_order' => $newOrder]);
    }
}