<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();

$id = $_GET['id'] ?? null;

if ($id) {
    if ($id == $_SESSION['user_id']) {
        die("You cannot delete your own account. <a href='/Activition/admin/users.php'>Go Back</a>");
    }

    // Check if the user is an admin
    $stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();

    if ($user && $user['role'] === 'admin') {
        // Enforce minimum 1 admin constraint
        $total_admins = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'admin'")->fetchColumn();
        if ($total_admins <= 1) {
            die("There must be at least one admin account. Cannot delete this admin. <a href='/Activition/admin/users.php'>Go Back</a>");
        }
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }
    catch (PDOException $e) {
        die("Could not delete user: " . $e->getMessage());
    }
}

header("Location: /Activition/admin/users.php");
exit;
