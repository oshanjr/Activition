<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();

$id = $_GET['id'] ?? null;
if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM tags WHERE id = ?");
        $stmt->execute([$id]);
    }
    catch (PDOException $e) {
        die("Could not delete tag: " . $e->getMessage());
    }
}

header("Location: /Activition/admin/tags.php");
exit;
