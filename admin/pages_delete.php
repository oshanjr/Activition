<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();

$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM pages WHERE id = ?");
        $stmt->execute([$id]);
    }
    catch (PDOException $e) {
        die("Could not delete page: " . $e->getMessage());
    }
}

header("Location: /Activition/admin/pages.php");
exit;
