<?php
/**
 * Instagram Controller
 * Instagram API integration
 */
class Instagram extends Controller
{
    private $settingsModel;
    
    public function __construct()
    {
        $this->settingsModel = $this->model('SiteSettings');
    }
    
    /**
     * Get Instagram feed
     * Returns JSON response with Instagram posts
     */
    public function feed()
    {
        header('Content-Type: application/json');
        
        // Get access token from settings
        $accessToken = $this->settingsModel->getSetting('instagram_access_token', '');
        
        if (empty($accessToken)) {
            echo json_encode([
                'success' => false,
                'error' => 'Instagram access token not configured'
            ]);
            return;
        }
        
        // Check cache first
        $cacheFile = BASE_PATH . '/cache/instagram_feed.json';
        $cacheTime = 3600; // 1 hour cache
        
        if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheTime) {
            // Return cached data
            echo file_get_contents($cacheFile);
            return;
        }
        
        // Fetch from Instagram API
        $fields = 'id,caption,media_type,media_url,permalink,thumbnail_url,timestamp';
        $limit = 12; // Number of posts to fetch
        
        $url = "https://graph.instagram.com/me/media?fields={$fields}&limit={$limit}&access_token={$accessToken}";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($httpCode !== 200 || $error) {
            echo json_encode([
                'success' => false,
                'error' => 'Failed to fetch Instagram feed: ' . $error
            ]);
            return;
        }
        
        $data = json_decode($response, true);
        
        if (!isset($data['data'])) {
            echo json_encode([
                'success' => false,
                'error' => 'Invalid response from Instagram API'
            ]);
            return;
        }
        
        // Format posts
        $posts = array_map(function($post) {
            return [
                'id' => $post['id'],
                'caption' => $post['caption'] ?? '',
                'image' => $post['media_type'] === 'VIDEO' ? ($post['thumbnail_url'] ?? $post['media_url']) : $post['media_url'],
                'type' => $post['media_type'],
                'url' => $post['permalink'],
                'timestamp' => $post['timestamp'] ?? ''
            ];
        }, $data['data']);
        
        $result = [
            'success' => true,
            'posts' => $posts
        ];
        
        // Cache the result
        if (!file_exists(dirname($cacheFile))) {
            mkdir(dirname($cacheFile), 0755, true);
        }
        file_put_contents($cacheFile, json_encode($result));
        
        echo json_encode($result);
    }
    
    /**
     * Refresh access token
     * Instagram tokens expire after 60 days
     */
    public function refreshToken()
    {
        header('Content-Type: application/json');
        
        $accessToken = $this->settingsModel->getSetting('instagram_access_token', '');
        
        if (empty($accessToken)) {
            echo json_encode([
                'success' => false,
                'error' => 'No access token found'
            ]);
            return;
        }
        
        // Refresh long-lived token
        $url = "https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token={$accessToken}";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            echo json_encode([
                'success' => false,
                'error' => 'Failed to refresh token'
            ]);
            return;
        }
        
        $data = json_decode($response, true);
        
        echo json_encode([
            'success' => true,
            'access_token' => $data['access_token'] ?? '',
            'expires_in' => $data['expires_in'] ?? 0
        ]);
    }
    
    /**
     * Clear Instagram cache
     */
    public function clearCache()
    {
        $cacheFile = BASE_PATH . '/cache/instagram_feed.json';
        
        if (file_exists($cacheFile)) {
            unlink($cacheFile);
        }
        
        echo json_encode(['success' => true, 'message' => 'Cache cleared']);
    }
}
