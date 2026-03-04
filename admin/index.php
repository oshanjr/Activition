<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();

// Get some stats
$total_products = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$total_users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$total_categories = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();

require_once __DIR__ . '/../includes/header.php';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Admin Sidebar -->
        <div class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Admin Menu</h3>
                <ul class="space-y-3">
                    <li><a href="/Activition/admin/index.php" class="block text-sm text-accent font-bold">Dashboard</a></li>
                    <li><a href="/Activition/admin/products.php" class="block text-sm text-gray-600 hover:text-primary transition-colors">Manage Products</a></li>
                    <li><a href="/Activition/admin/categories.php" class="block text-sm text-gray-600 hover:text-primary transition-colors">Manage Categories</a></li>
                    <li><a href="/Activition/admin/tags.php" class="block text-sm text-gray-600 hover:text-primary transition-colors">Manage Tags</a></li>
                </ul>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="flex-1">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Dashboard Overview</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="text-gray-500 text-sm font-medium mb-1">Total Products</div>
                    <div class="text-3xl font-black text-gray-900"><?php echo number_format($total_products); ?></div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="text-gray-500 text-sm font-medium mb-1">Total Users</div>
                    <div class="text-3xl font-black text-gray-900"><?php echo number_format($total_users); ?></div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="text-gray-500 text-sm font-medium mb-1">Total Categories</div>
                    <div class="text-3xl font-black text-gray-900"><?php echo number_format($total_categories); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
