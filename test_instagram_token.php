<?php
/**
 * Instagram Token Test Script
 * Test your Instagram access token
 */

$accessToken = 'IGAAS51uK8b5xBZAFQ1V245ZAFh3ZAWc0UEtKN0NobHRJOVF6cEphUHNsMmVtUnRlc2I5WHFVZAlBKQmNsYkJPNGp1dVo1VjRaekU2S1ZAybkoxUlZAmeWNxYkZA5YlVCWEFZAZATdIWEtwOXhzRzVDdHhJUFVUM1h4bVdlZAEdmR2plVFNBVQZDZD';

echo "<h1>Instagram Token Test</h1>";
echo "<hr>";

// Test 1: Check token format
echo "<h2>1. Token Format Check</h2>";
echo "Token Length: " . strlen($accessToken) . " characters<br>";
echo "Token starts with: " . substr($accessToken, 0, 10) . "...<br>";
echo "<span style='color: green;'>✓ Token format looks valid</span><br><br>";

// Test 2: Get User Profile
echo "<h2>2. Testing API Connection - User Profile</h2>";
$url = "https://graph.instagram.com/me?fields=id,username&access_token={$accessToken}";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "<span style='color: red;'>✗ cURL Error: {$error}</span><br>";
} else {
    echo "HTTP Status Code: {$httpCode}<br>";
    echo "Response: <pre>" . htmlspecialchars($response) . "</pre>";
    
    $data = json_decode($response, true);
    if (isset($data['id'])) {
        echo "<span style='color: green;'>✓ Token is VALID!</span><br>";
        echo "User ID: " . $data['id'] . "<br>";
        echo "Username: " . ($data['username'] ?? 'N/A') . "<br>";
    } else if (isset($data['error'])) {
        echo "<span style='color: red;'>✗ API Error: " . $data['error']['message'] . "</span><br>";
        echo "Error Type: " . $data['error']['type'] . "<br>";
        echo "Error Code: " . $data['error']['code'] . "<br>";
    }
}

echo "<br><hr>";

// Test 3: Get Media
echo "<h2>3. Testing API Connection - Media Feed</h2>";
$url = "https://graph.instagram.com/me/media?fields=id,caption,media_type,media_url,permalink,thumbnail_url,timestamp&limit=5&access_token={$accessToken}";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "<span style='color: red;'>✗ cURL Error: {$error}</span><br>";
} else {
    echo "HTTP Status Code: {$httpCode}<br>";
    
    $data = json_decode($response, true);
    if (isset($data['data'])) {
        echo "<span style='color: green;'>✓ Successfully fetched media!</span><br>";
        echo "Total posts retrieved: " . count($data['data']) . "<br><br>";
        
        foreach ($data['data'] as $index => $post) {
            echo "<div style='border: 1px solid #ddd; padding: 10px; margin: 10px 0;'>";
            echo "<strong>Post " . ($index + 1) . ":</strong><br>";
            echo "ID: " . $post['id'] . "<br>";
            echo "Type: " . $post['media_type'] . "<br>";
            echo "Caption: " . substr($post['caption'] ?? 'No caption', 0, 100) . "...<br>";
            echo "URL: <a href='" . $post['permalink'] . "' target='_blank'>View on Instagram</a><br>";
            if ($post['media_type'] === 'IMAGE') {
                echo "<img src='" . $post['media_url'] . "' style='max-width: 200px; margin-top: 10px;'><br>";
            }
            echo "</div>";
        }
    } else if (isset($data['error'])) {
        echo "<span style='color: red;'>✗ API Error: " . $data['error']['message'] . "</span><br>";
    } else {
        echo "Response: <pre>" . htmlspecialchars($response) . "</pre>";
    }
}

echo "<br><hr>";
echo "<h2>Summary</h2>";
echo "<p>If you see green checkmarks above, your token is working correctly!</p>";
echo "<p>Next step: Add this token to your admin settings at: <a href='http://localhost:8090/admin/settings'>Admin Settings</a></p>";
?>
