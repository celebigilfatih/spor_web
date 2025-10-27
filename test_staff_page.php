<?php
/**
 * Test Staff Page Loading
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set up environment
$_SERVER['REQUEST_URI'] = '/admin/staff';
$_GET['url'] = 'admin/staff';
session_start();
$_SESSION['admin_logged_in'] = true;
$_SESSION['admin_id'] = 1;
$_SESSION['admin_username'] = 'test';
$_SESSION['last_activity'] = time();

// Load the application
chdir(__DIR__ . '/public');
require_once __DIR__ . '/public/index.php';
