<?php
/**
 * News Model
 * Haberler ve duyurular için model sınıfı
 */
class NewsModel extends Model
{
    protected $table = 'news';

    /**
     * Yayınlanmış haberleri getir
     */
    public function getPublished($limit = null)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE status = 'published' 
                ORDER BY priority DESC, published_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        $result = $this->db->query($sql);
        return is_array($result) ? $result : [];
    }

    /**
     * Öne çıkan haberleri getir
     */
    public function getFeatured($limit = 3)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE status = 'published' AND is_featured = 1 
                ORDER BY published_at DESC 
                LIMIT {$limit}";
        
        $result = $this->db->query($sql);
        return is_array($result) ? $result : [];
    }

    /**
     * Kategoriye göre haberleri getir
     */
    public function getByCategory($category, $limit = null)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE status = 'published' AND category = :category 
                ORDER BY published_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        $result = $this->db->query($sql, ['category' => $category]);
        return is_array($result) ? $result : [];
    }

    /**
     * Slug ile haber getir
     */
    public function getBySlug($slug)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE slug = :slug AND status = 'published'";
        
        $result = $this->db->query($sql, ['slug' => $slug]);
        
        // Return first result if exists and query succeeded
        if (is_array($result) && !empty($result)) {
            return $result[0];
        }
        
        return null;
    }

    /**
     * Haber görüntülenme sayısını artır
     */
    public function incrementViews($id)
    {
        $sql = "UPDATE {$this->table} SET views = views + 1 WHERE id = :id";
        return $this->db->execute($sql, ['id' => $id]);
    }

    /**
     * İlgili haberleri getir
     */
    public function getRelated($category, $excludeId, $limit = 4)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE category = :category AND id != :exclude_id AND status = 'published' 
                ORDER BY published_at DESC 
                LIMIT {$limit}";
        
        $result = $this->db->query($sql, [
            'category' => $category,
            'exclude_id' => $excludeId
        ]);
        return is_array($result) ? $result : [];
    }

    /**
     * Sayfalama ile haberleri getir
     */
    public function getPaginated($page = 1, $perPage = 10, $category = null)
    {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT * FROM {$this->table} 
                WHERE status = 'published'";
        
        $params = [];
        if ($category) {
            $sql .= " AND category = :category";
            $params['category'] = $category;
        }
        
        $sql .= " ORDER BY published_at DESC LIMIT {$perPage} OFFSET {$offset}";
        
        $result = $this->db->query($sql, $params);
        return is_array($result) ? $result : [];
    }

    /**
     * Slug oluştur
     */
    public function generateSlug($title)
    {
        $slug = $this->turkishToEnglish($title);
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $slug)));
        
        // Eğer aynı slug varsa numaralandır
        $originalSlug = $slug;
        $count = 1;
        
        while ($this->slugExists($slug)) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        
        return $slug;
    }

    /**
     * Slug'ın var olup olmadığını kontrol et
     */
    private function slugExists($slug)
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE slug = :slug";
        $result = $this->db->query($sql, ['slug' => $slug]);
        
        // Safely check if slug exists
        if (is_array($result) && !empty($result)) {
            return $result[0]['count'] > 0;
        }
        
        return false;
    }

    /**
     * Türkçe karakterleri İngilizce'ye çevir
     */
    private function turkishToEnglish($text)
    {
        $turkish = ['ç', 'ğ', 'ı', 'ö', 'ş', 'ü', 'Ç', 'Ğ', 'İ', 'Ö', 'Ş', 'Ü'];
        $english = ['c', 'g', 'i', 'o', 's', 'u', 'C', 'G', 'I', 'O', 'S', 'U'];
        return str_replace($turkish, $english, $text);
    }

    /**
     * Haber arama
     */
    public function search($keyword, $limit = 20)
    {
        if (empty($keyword)) {
            return [];
        }

        // PDO doesn't allow reusing the same named parameter multiple times
        // So we use separate parameters for each field
        $sql = "SELECT * FROM {$this->table} 
                WHERE (title LIKE :keyword1 OR content LIKE :keyword2 OR excerpt LIKE :keyword3) 
                AND status = 'published' 
                ORDER BY published_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        $searchTerm = '%' . $keyword . '%';
        $result = $this->db->query($sql, [
            'keyword1' => $searchTerm,
            'keyword2' => $searchTerm,
            'keyword3' => $searchTerm
        ]);
        
        // Ensure we always return an array, even if query fails
        return is_array($result) ? $result : [];
    }

    /**
     * Toplam haber sayısı
     */
    public function getTotalCount($category = null)
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE status = 'published'";
        $params = [];
        
        if ($category) {
            $sql .= " AND category = :category";
            $params['category'] = $category;
        }
        
        $result = $this->db->query($sql, $params);
        return $result[0]['total'] ?? 0;
    }
    
    /**
     * Haberin galeri resimlerini getir
     */
    public function getGalleryImages($newsId)
    {
        $sql = "SELECT * FROM news_gallery WHERE news_id = ? ORDER BY sort_order ASC";
        $result = $this->db->query($sql, [$newsId]);
        return is_array($result) ? $result : [];
    }
}