<?php
// Prevent multiple inclusions
if (!defined('OPTICAL_MANAGEMENT_CONFIG')) {
    define('OPTICAL_MANAGEMENT_CONFIG', true);

    // Database configuration
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'optical_management');

    // Start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Create database connection
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    // Check if user is logged in
    function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    // Check if user is admin
    function isAdmin()
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    // Redirect if not logged in
    function requireLogin()
    {
        if (!isLoggedIn()) {
            header("Location: ../index.php");
            exit();
        }
    }

    // Redirect if not admin
    function requireAdmin()
    {
        requireLogin();
        if (!isAdmin()) {
            header("Location: ../user/dashboard.php");
            exit();
        }
    }

    // Get user data
    function getUserData($user_id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch();
    }
}
?>