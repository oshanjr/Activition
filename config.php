<?php
// config.php
$db_host = 'localhost';
$db_name = 'techsupply_demo';
$db_user = 'root';
$db_pass = 'Oshan@2004';

try {
    // Only connect if we aren't running seed.php without db creation first
    if (basename($_SERVER['PHP_SELF']) !== 'seed.php' || isset($in_seed_post_creation)) {
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
