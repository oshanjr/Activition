<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();

$tags = $pdo->query("SELECT * FROM tags ORDER BY name")->fetchAll();

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

        <!-- Tags Content -->
        <div class="flex-1">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-extrabold text-gray-900">Tags</h1>
                <a href="/Activition/admin/tags_create.php" class="bg-accent hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow">Add Tag</a>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($tags as $tag): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#<?php echo $tag['id']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                    <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-md"><?php echo htmlspecialchars($tag['name']); ?></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="/Activition/admin/tags_edit.php?id=<?php echo $tag['id']; ?>" class="text-accent hover:text-blue-900 mr-3">Edit</a>
                                    <a href="/Activition/admin/tags_delete.php?id=<?php echo $tag['id']; ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this tag?');">Delete</a>
                                </td>
                            </tr>
                            <?php
endforeach; ?>
                            <?php if (empty($tags)): ?>
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">No tags found.</td>
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
