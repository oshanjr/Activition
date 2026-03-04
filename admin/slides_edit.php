<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: /Activition/admin/slides.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM hero_slides WHERE id = ?");
$stmt->execute([$id]);
$slide = $stmt->fetch();

if (!$slide) {
    echo "Slide not found.";
    exit;
}

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
        $stmt = $pdo->prepare("UPDATE hero_slides SET image_url=?, title=?, subtitle=?, button_text=?, button_link=?, order_index=? WHERE id=?");
        if ($stmt->execute([$image_url, $title, $subtitle, $button_text, $button_link, $order_index, $id])) {
            $success = 'Slide updated successfully.';
            $stmt = $pdo->prepare("SELECT * FROM hero_slides WHERE id = ?");
            $stmt->execute([$id]);
            $slide = $stmt->fetch();
        }
        else {
            $error = 'Failed to update slide.';
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Admin Sidebar -->
        <div class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Admin Menu</h3>
                <ul class="space-y-3">
                    <li><a href="/Activition/admin/index.php" class="block text-sm text-gray-600 hover:text-primary transition-colors">Dashboard</a></li>
                    <li><a href="/Activition/admin/products.php" class="block text-sm text-gray-600 hover:text-primary transition-colors">Manage Products</a></li>
                    <li><a href="/Activition/admin/categories.php" class="block text-sm text-gray-600 hover:text-primary transition-colors">Manage Categories</a></li>
                    <li><a href="/Activition/admin/tags.php" class="block text-sm text-gray-600 hover:text-primary transition-colors">Manage Tags</a></li>
                    <li><a href="/Activition/admin/slides.php" class="block text-sm text-accent font-bold">Hero Slides</a></li>
                    <li><a href="/Activition/admin/users.php" class="block text-sm text-gray-600 hover:text-primary transition-colors">Manage Admins</a></li>
                </ul>
            </div>
        </div>

        <!-- Content -->
        <div class="flex-1">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-extrabold text-gray-900">Edit Slide #<?php echo htmlspecialchars($slide['id']); ?></h1>
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
                        <input type="url" name="image_url" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent" value="<?php echo htmlspecialchars($slide['image_url']); ?>">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent" value="<?php echo htmlspecialchars($slide['title']); ?>">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                        <textarea name="subtitle" rows="3" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent"><?php echo htmlspecialchars($slide['subtitle'] ?? ''); ?></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Button Text</label>
                            <input type="text" name="button_text" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent" value="<?php echo htmlspecialchars($slide['button_text'] ?? ''); ?>">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Button Link</label>
                            <input type="text" name="button_link" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent" value="<?php echo htmlspecialchars($slide['button_link'] ?? ''); ?>">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Order Index</label>
                        <input type="number" name="order_index" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent" value="<?php echo $slide['order_index']; ?>">
                    </div>
                    
                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="bg-gray-900 hover:bg-accent text-white font-bold py-2 px-6 rounded-lg shadow transition-colors">
                            Update Slide
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
