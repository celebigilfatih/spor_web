<?php
/**
 * News Model
 * Haberler ve duyurular için model sınıfı
 */
class News extends Model
{
    protected $table = 'news';

    /**
     * Yayınlanmış haberleri getir
     */
    public function getPublished($limit = null)
    {
        $sql = "SELECT n.*, a.username as author_name 
                FROM {$this->table} n 
                LEFT JOIN admins a ON n.author_id = a.id 
                WHERE n.status = 'published' 
                ORDER BY n.published_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql);
    }

    /**
     * Öne çıkan haberleri getir
     */
    public function getFeatured($limit = 3)
    {
        $sql = "SELECT n.*, a.username as author_name 
                FROM {$this->table} n 
                LEFT JOIN admins a ON n.author_id = a.id 
                WHERE n.status = 'published' AND n.is_featured = 1 
                ORDER BY n.published_at DESC 
                LIMIT {$limit}";
        
        return $this->db->query($sql);
    }

    /**
     * Kategoriye göre haberleri getir
     */
    public function getByCategory($category, $limit = null)
    {
        $sql = "SELECT n.*, a.username as author_name 
                FROM {$this->table} n 
                LEFT JOIN admins a ON n.author_id = a.id 
                WHERE n.status = 'published' AND n.category = :category 
                ORDER BY n.published_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql, ['category' => $category]);
    }

    /**
     * Slug ile haber getir
     */
    public function getBySlug($slug)
    {
        $sql = "SELECT n.*, a.username as author_name 
                FROM {$this->table} n 
                LEFT JOIN admins a ON n.author_id = a.id 
                WHERE n.slug = :slug AND n.status = 'published'";
        
        $result = $this->db->query($sql, ['slug' => $slug]);
        return $result ? $result[0] : null;
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
        
        return $this->db->query($sql, [
            'category' => $category,
            'exclude_id' => $excludeId
        ]);
    }

    /**
     * Sayfalama ile haberleri getir
     */
    public function getPaginated($page = 1, $perPage = 10, $category = null)
    {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT n.*, a.username as author_name 
                FROM {$this->table} n 
                LEFT JOIN admins a ON n.author_id = a.id 
                WHERE n.status = 'published'";
        
        $params = [];
        if ($category) {
            $sql .= " AND n.category = :category";
            $params['category'] = $category;
        }
        
        $sql .= " ORDER BY n.published_at DESC LIMIT {$perPage} OFFSET {$offset}";
        
        return $this->db->query($sql, $params);
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
        return $result[0]['count'] > 0;
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
}