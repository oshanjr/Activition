<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();

$id = $_GET['id'] ?? null;

if ($id) {
    // Check total slides count before deleting
    $total_slides = $pdo->query("SELECT COUNT(*) FROM hero_slides")->fetchColumn();

    if ($total_slides > 2) {
        try {
            $stmt = $pdo->prepare("DELETE FROM hero_slides WHERE id = ?");
            $stmt->execute([$id]);
        }
        catch (PDOException $e) {
            die("Could not delete slide: " . $e->getMessage());
        }
    }
    else {
        die("You must have at least 2 slides in the carousel. Cannot delete this slide. <a href='/Activition/admin/slides.php'>Go Back</a>");
    }
}

header("Location: /Activition/admin/slides.php");
exit;
