<?php
/**
 * Team Update Debug Tool
 * Test team update functionality
 */
require_once '../config/database.php';
require_once '../core/Database.php';
require_once '../core/Model.php';
require_once '../app/models/Team.php';

echo "<!DOCTYPE html>";
echo "<html><head><title>Team Update Debug</title>";
echo "<style>body{font-family:Arial;margin:20px;background:#1e3c72;color:white;} .container{max-width:1000px;margin:0 auto;background:#2a5298;padding:30px;border-radius:8px;} .success{color:#90EE90;} .error{color:#FFB6C1;} .info{color:#87CEEB;} .warning{color:#FFD700;} .test-section{background:#0d1b2a;padding:20px;margin:20px 0;border-radius:8px;} table{width:100%;border-collapse:collapse;margin:20px 0;} th,td{padding:10px;border:1px solid #444;text-align:left;} th{background:#1e3c72;}</style>";
echo "</head><body>";
echo "<div class='container'>";

echo "<h1>🔧 Team Update Debug Tool</h1>";

try {
    $database = new Database();
    $teamModel = new Team();
    echo "<p class='success'>✅ Database ve Team model başarıyla yüklendi</p>";
    
    // Test 1: Check table structure
    echo "<div class='test-section'>";
    echo "<h2>📋 Teams Tablosu Yapısı</h2>";
    $columns = $database->query("DESCRIBE teams");
    
    if ($columns) {
        echo "<table>";
        echo "<tr><th>Alan</th><th>Tip</th><th>Null</th><th>Varsayılan</th></tr>";
        foreach ($columns as $column) {
            echo "<tr>";
            echo "<td><strong>" . $column['Field'] . "</strong></td>";
            echo "<td>" . $column['Type'] . "</td>";
            echo "<td>" . $column['Null'] . "</td>";
            echo "<td>" . ($column['Default'] ?? 'NULL') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    echo "</div>";
    
    // Test 2: Check existing teams
    echo "<div class='test-section'>";
    echo "<h2>📊 Mevcut Takımlar</h2>";
    $teams = $teamModel->findAll();
    
    if ($teams && !empty($teams)) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Ad</th><th>Tip</th><th>Kategori</th><th>Durum</th><th>Actions</th></tr>";
        foreach (array_slice($teams, 0, 5) as $team) {
            echo "<tr>";
            echo "<td>" . $team['id'] . "</td>";
            echo "<td>" . htmlspecialchars($team['name']) . "</td>";
            echo "<td>" . ($team['team_type'] ?? 'N/A') . "</td>";
            echo "<td>" . ($team['category'] ?? 'N/A') . "</td>";
            echo "<td>" . ($team['status'] ?? 'N/A') . "</td>";
            echo "<td><a href='test_update.php?id=" . $team['id'] . "' style='color:#FFD700;'>Test Update</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='warning'>⚠️ Hiç takım bulunamadı</p>";
    }
    echo "</div>";
    
    // Test 3: Test update operation
    if (isset($_GET['test_update']) && isset($_GET['id'])) {
        echo "<div class='test-section'>";
        echo "<h2>🧪 Update Test</h2>";
        
        $testId = (int)$_GET['id'];
        $originalTeam = $teamModel->findById($testId);
        
        if ($originalTeam) {
            echo "<h3>Orijinal Takım Bilgileri:</h3>";
            echo "<pre>" . print_r($originalTeam, true) . "</pre>";
            
            // Test update with only valid fields
            $updateData = [
                'name' => $originalTeam['name'] . ' (Test)',
                'team_type' => $originalTeam['team_type'] ?? 'A',
                'description' => 'Test güncelleme: ' . date('Y-m-d H:i:s'),
                'status' => $originalTeam['status'] ?? 'active'
            ];
            
            echo "<h3>Update Data:</h3>";
            echo "<pre>" . print_r($updateData, true) . "</pre>";
            
            $result = $teamModel->update($testId, $updateData);
            
            if ($result) {
                echo "<p class='success'>✅ Update işlemi başarılı!</p>";
                
                // Get updated data
                $updatedTeam = $teamModel->findById($testId);
                echo "<h3>Güncellenmiş Takım Bilgileri:</h3>";
                echo "<pre>" . print_r($updatedTeam, true) . "</pre>";
                
                // Revert changes
                $revertData = [
                    'name' => $originalTeam['name'],
                    'description' => $originalTeam['description'],
                ];
                $teamModel->update($testId, $revertData);
                echo "<p class='info'>ℹ️ Değişiklikler geri alındı</p>";
                
            } else {
                echo "<p class='error'>❌ Update işlemi başarısız!</p>";
            }
        } else {
            echo "<p class='error'>❌ Takım bulunamadı!</p>";
        }
        echo "</div>";
    }
    
    // Test 4: Field validation
    echo "<div class='test-section'>";
    echo "<h2>✅ Alan Doğrulama</h2>";
    
    $requiredFields = ['name', 'team_type', 'status'];
    $optionalFields = ['description', 'category', 'league', 'coach_id'];
    $problemFields = ['coach_name', 'coach']; // These don't exist in DB
    
    echo "<h3>Gerekli Alanlar:</h3>";
    foreach ($requiredFields as $field) {
        $exists = false;
        foreach ($columns as $column) {
            if ($column['Field'] === $field) {
                $exists = true;
                break;
            }
        }
        echo "<p class='" . ($exists ? 'success' : 'error') . "'>" . 
             ($exists ? '✅' : '❌') . " $field</p>";
    }
    
    echo "<h3>İsteğe Bağlı Alanlar:</h3>";
    foreach ($optionalFields as $field) {
        $exists = false;
        foreach ($columns as $column) {
            if ($column['Field'] === $field) {
                $exists = true;
                break;
            }
        }
        echo "<p class='" . ($exists ? 'success' : 'warning') . "'>" . 
             ($exists ? '✅' : '⚠️') . " $field</p>";
    }
    
    echo "<h3>Problemli Alanlar:</h3>";
    foreach ($problemFields as $field) {
        $exists = false;
        foreach ($columns as $column) {
            if ($column['Field'] === $field) {
                $exists = true;
                break;
            }
        }
        echo "<p class='" . ($exists ? 'warning' : 'info') . "'>" . 
             ($exists ? '⚠️ Var ama kullanılmamalı' : '✅ Yok (doğru)') . " $field</p>";
    }
    echo "</div>";
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Hata: " . $e->getMessage() . "</p>";
}

// Quick test buttons
if (!empty($teams)) {
    $firstTeam = $teams[0];
    echo "<h2>🚀 Hızlı Test</h2>";
    echo "<p><a href='?test_update=1&id=" . $firstTeam['id'] . "' style='background:#FFD700;color:#1e3c72;padding:10px 20px;text-decoration:none;border-radius:4px;'>Test Update İşlemi</a></p>";
}

echo "<p><a href='http://localhost:8090/admin/teams' target='_blank' style='color:#87CEEB;'>Admin Teams Sayfası</a></p>";
echo "<p><a href='debug_teams.php' target='_blank' style='color:#87CEEB;'>Teams Debug Tool</a></p>";

echo "</div>";
echo "</body></html>";
?>