<?php
/**
 * SiteSettings Model
 * Site ayarları için model sınıfı
 */
class SiteSettings extends Model
{
    protected $table = 'site_settings';

    /**
     * Ayar anahtarına göre değer getir
     */
    public function getSetting($key, $default = null)
    {
        $sql = "SELECT setting_value FROM {$this->table} WHERE setting_key = :key";
        $result = $this->db->query($sql, ['key' => $key]);
        
        if ($result) {
            return $result[0]['setting_value'];
        }
        
        return $default;
    }

    /**
     * Ayar güncelle veya oluştur
     */
    public function setSetting($key, $value, $type = 'text', $description = '')
    {
        $existing = $this->getSetting($key);
        
        if ($existing !== null) {
            // Mevcut ayarı güncelle
            $sql = "UPDATE {$this->table} SET setting_value = :value, updated_at = NOW() WHERE setting_key = :key";
            return $this->db->execute($sql, ['value' => $value, 'key' => $key]);
        } else {
            // Yeni ayar oluştur
            $sql = "INSERT INTO {$this->table} (setting_key, setting_value, setting_group, created_at) 
                    VALUES (:key, :value, 'general', NOW())";
            return $this->db->execute($sql, ['key' => $key, 'value' => $value]);
        }
    }

    /**
     * Ayar güncelle (alias for setSetting)
     */
    public function updateSetting($key, $value, $type = 'text', $description = '')
    {
        return $this->setSetting($key, $value, $type, $description);
    }

    /**
     * Tüm ayarları getir
     */
    public function getAllSettings()
    {
        $sql = "SELECT setting_key, setting_value FROM {$this->table}";
        $results = $this->db->query($sql);
        
        $settings = [];
        if ($results) {
            foreach ($results as $row) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        }
        
        return $settings;
    }

    /**
     * İletişim bilgilerini getir
     */
    public function getContactSettings()
    {
        $keys = ['contact_phone', 'contact_email', 'contact_address'];
        $sql = "SELECT setting_key, setting_value FROM {$this->table} 
                WHERE setting_key IN ('" . implode("','", $keys) . "')";
        
        $results = $this->db->query($sql);
        $contact = [];
        
        if ($results) {
            foreach ($results as $row) {
                $contact[$row['setting_key']] = $row['setting_value'];
            }
        }
        
        return $contact;
    }

    /**
     * Sosyal medya linklerini getir
     */
    public function getSocialMediaSettings()
    {
        $keys = ['social_facebook', 'social_twitter', 'social_instagram', 'social_youtube'];
        $sql = "SELECT setting_key, setting_value FROM {$this->table} 
                WHERE setting_key IN ('" . implode("','", $keys) . "')";
        
        $results = $this->db->query($sql);
        $social = [];
        
        if ($results) {
            foreach ($results as $row) {
                $social[$row['setting_key']] = $row['setting_value'];
            }
        }
        
        return $social;
    }
}