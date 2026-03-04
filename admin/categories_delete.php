<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();

$id = $_GET['id'] ?? null;
if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->execute([$id]);
    }
    catch (PDOException $e) {
        // Fallback for integrity errors if cascading delete fails somehow
        die("Could not delete category: " . $e->getMessage());
    }
}

header("Location: /Activition/admin/categories.php");
exit;
