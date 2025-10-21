<?php
/**
 * Test Staff Insert
 */

// Load configuration
if (getenv('DB_HOST') || isset($_ENV['DB_HOST'])) {
    require_once 'config/docker.php';
} else {
    require_once 'config/database.php';
}

require_once 'core/Database.php';
require_once 'core/Model.php';
require_once 'app/models/TechnicalStaffModel.php';

try {
    $staffModel = new TechnicalStaffModel();
    
    echo "Testing staff insertion...\n";
    
    $testData = [
        'name' => 'Test Antrenör',
        'position' => 'Baş Antrenör',
        'role' => 'Baş Antrenör',
        'experience' => '10 yıl',
        'license' => 'UEFA PRO',
        'bio' => 'Test biyografi',
        'status' => 'active'
    ];
    
    $result = $staffModel->create($testData);
    
    if ($result) {
        echo "✓ Staff member created successfully! ID: $result\n";
        
        // Clean up test data
        $staffModel->delete($result);
        echo "✓ Test data cleaned up!\n";
    } else {
        echo "✗ Failed to create staff member!\n";
        echo "Error: " . $staffModel->getLastError() . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
