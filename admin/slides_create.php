<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image_url = trim($_POST['image_url'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $subtitle = trim($_POST['subtitle'] ?? '');
    $button_text = trim($_POST['button_text'] ?? '');
    $button_link = trim($_POST['button_link'] ?? '');
    $order_index = (int)($_POST['order_index'] ?? 0);

    if (empty($image_url) || empty($title)) {
        $error = 'Image URL and Title are required.';
    }
    else {
        $stmt = $pdo->prepare("INSERT INTO hero_slides (image_url, title, subtitle, button_text, button_link, order_index) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$image_url, $title, $subtitle, $button_text, $button_link, $order_index])) {
            $success = 'Slide added successfully.';
        }
        else {
            $error = 'Failed to add slide.';
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Admin Sidebar -->
        <?php require_once __DIR__ . '/../includes/admin_sidebar.php'; ?>

        <!-- Content -->
        <div class="flex-1">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-extrabold text-gray-900">Add Slide</h1>
                <a href="/Activition/admin/slides.php" class="text-gray-600 hover:text-primary">&larr; Back to Slides</a>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8">
                <?php if ($error): ?>
                    <div class="bg-red-50 text-red-600 p-3 rounded-lg mb-6 border border-red-100"><?php echo htmlspecialchars($error); ?></div>
                <?php
endif; ?>
                <?php if ($success): ?>
                    <div class="bg-green-50 text-green-700 p-3 rounded-lg mb-6 border border-green-200"><?php echo htmlspecialchars($success); ?></div>
                <?php
endif; ?>
                
                <form method="POST" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image URL</label>
                        <input type="url" name="image_url" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent" placeholder="https://example.com/image.jpg">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent" placeholder="Empower Your Business">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                        <textarea name="subtitle" rows="3" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent" placeholder="Source top-tier printers..."></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Button Text</label>
                            <input type="text" name="button_text" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent" placeholder="Explore Shop">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Button Link</label>
                            <input type="text" name="button_link" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent" placeholder="/Activition/shop.php">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Order Index</label>
                        <input type="number" name="order_index" value="0" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent">
                    </div>
                    
                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="bg-gray-900 hover:bg-accent text-white font-bold py-2 px-6 rounded-lg shadow transition-colors">
                            Save Slide
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
