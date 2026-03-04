<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');

    if (empty($name)) {
        $error = 'Tag name is required.';
    }
    else {
        $stmt = $pdo->prepare("INSERT INTO tags (name) VALUES (?)");
        try {
            if ($stmt->execute([$name])) {
                $success = 'Tag added successfully.';
            }
            else {
                $error = 'Failed to add tag.';
            }
        }
        catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage() . ' (Make sure the tag name is unique)';
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
                    <li><a href="/Activition/admin/tags.php" class="block text-sm text-accent font-bold">Manage Tags</a></li>
                </ul>
            </div>
        </div>

        <!-- Content -->
        <div class="flex-1">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-extrabold text-gray-900">Add Tag</h1>
                <a href="/Activition/admin/tags.php" class="text-gray-600 hover:text-primary">&larr; Back to Tags</a>
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
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tag Name</label>
                        <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent" placeholder="e.g. Wireless, Refurbished...">
                    </div>
                    
                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="bg-gray-900 hover:bg-accent text-white font-bold py-2 px-6 rounded-lg shadow transition-colors">
                            Save Tag
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
