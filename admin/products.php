<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();

$products = $pdo->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC")->fetchAll();

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
                    <li><a href="/Activition/admin/products.php" class="block text-sm text-accent font-bold">Manage Products</a></li>
                    <li><a href="/Activition/admin/categories.php" class="block text-sm text-gray-600 hover:text-primary transition-colors">Manage Categories</a></li>
                    <li><a href="/Activition/admin/tags.php" class="block text-sm text-gray-600 hover:text-primary transition-colors">Manage Tags</a></li>
                </ul>
            </div>
        </div>

        <!-- Products Content -->
        <div class="flex-1">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-extrabold text-gray-900">Products</h1>
                <a href="/Activition/admin/products_create.php" class="bg-accent hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow">Add Product</a>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($products as $p): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#<?php echo $p['id']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900"><?php echo htmlspecialchars($p['name']); ?></div>
                                    <?php if ($p['is_license']): ?>
                                        <div class="text-xs text-blue-600">Digital License</div>
                                    <?php
    endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($p['category_name']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">$<?php echo number_format($p['price'], 2); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $p['stock']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="/Activition/admin/products_edit.php?id=<?php echo $p['id']; ?>" class="text-accent hover:text-blue-900 mr-3">Edit</a>
                                    <a href="/Activition/admin/products_delete.php?id=<?php echo $p['id']; ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                                </td>
                            </tr>
                            <?php
endforeach; ?>
                            <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No products found.</td>
                            </tr>
                            <?php
endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
