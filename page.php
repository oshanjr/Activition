<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

$slug = $_GET['slug'] ?? null;

if (!$slug) {
    header("Location: /Activition/index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM pages WHERE slug = ?");
$stmt->execute([$slug]);
$page = $stmt->fetch();

if (!$page) {
    // 404
    http_response_code(404);
    require_once __DIR__ . '/includes/header.php';
    echo '<div class="py-32 text-center text-red-500 font-bold text-2xl">Page Not Found</div>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

require_once __DIR__ . '/includes/header.php';
?>

<!-- Header Banner -->
<div class="bg-primary text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="fade-in">
        <h1 class="text-4xl font-extrabold mb-4"><?php echo htmlspecialchars($page['title']); ?></h1>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="prose prose-blue lg:prose-lg mx-auto" data-aos="fade-up">
        <!-- Render the raw HTML stored in the DB -->
        <?php echo $page['content']; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
