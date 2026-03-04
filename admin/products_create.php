<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();

$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
$tags = $pdo->query("SELECT * FROM tags ORDER BY name")->fetchAll();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $category_id = $_POST['category_id'] ?? '';
    $tags_input = $_POST['tags'] ?? [];
    $price = $_POST['price'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $description = trim($_POST['description'] ?? '');
    $image_url = trim($_POST['image_url'] ?? '');
    $is_license = isset($_POST['is_license']) ? 1 : 0;
    $license_key = trim($_POST['license_key'] ?? '');

    if (empty($name) || empty($category_id) || empty($price)) {
        $error = 'Name, category, and price are required.';
    }
    else {
        $stmt = $pdo->prepare("INSERT INTO products (category_id, name, description, price, image_url, stock, is_license, license_key) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$category_id, $name, $description, $price, $image_url, $stock, $is_license, $license_key])) {
            $product_id = $pdo->lastInsertId();
            if (!empty($tags_input)) {
                $tag_stmt = $pdo->prepare("INSERT INTO product_tags (product_id, tag_id) VALUES (?, ?)");
                foreach ($tags_input as $tid) {
                    $tag_stmt->execute([$product_id, $tid]);
                }
            }
            $success = 'Product added successfully.';
        }
        else {
            $error = 'Failed to add product.';
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
                    <li><a href="/Activition/admin/products.php" class="block text-sm text-accent font-bold">Manage Products</a></li>
                    <li><a href="/Activition/admin/categories.php" class="block text-sm text-gray-600 hover:text-primary transition-colors">Manage Categories</a></li>
                    <li><a href="/Activition/admin/tags.php" class="block text-sm text-gray-600 hover:text-primary transition-colors">Manage Tags</a></li>
                </ul>
            </div>
        </div>

        <!-- Content -->
        <div class="flex-1">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-extrabold text-gray-900">Add Product</h1>
                <a href="/Activition/admin/products.php" class="text-gray-600 hover:text-primary">&larr; Back to Products</a>
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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                            <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent" placeholder="e.g. Epson EcoTank L3250">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category_id" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent bg-white">
                                <option value="">Select a category</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                                <?php
endforeach; ?>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Price ($)</label>
                            <input type="number" step="0.01" name="price" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent" placeholder="199.99">
                        </div>
                        
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent" placeholder="Product details..."></textarea>
                        </div>
                        
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Image URL</label>
                            <input type="url" name="image_url" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent" placeholder="https://example.com/image.jpg">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity</label>
                            <input type="number" name="stock" value="0" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent" placeholder="10">
                        </div>
                        
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tags (Optional)</label>
                            <select name="tags[]" multiple class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent bg-white h-32">
                                <?php foreach ($tags as $tag): ?>
                                    <option value="<?php echo $tag['id']; ?>"><?php echo htmlspecialchars($tag['name']); ?></option>
                                <?php
endforeach; ?>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Hold CTRL (or CMD on Mac) to select multiple tags.</p>
                        </div>
                        
                        <div>
                            <label class="flex items-center space-x-2 mt-8">
                                <input type="checkbox" name="is_license" value="1" class="rounded border-gray-300 text-accent focus:ring-accent">
                                <span class="text-sm font-medium text-gray-700">Digital License Product</span>
                            </label>
                        </div>
                        
                        <div class="col-span-1 md:col-span-2 border-t border-gray-100 pt-6 mt-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">License Key (Optional)</label>
                            <input type="text" name="license_key" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent" placeholder="XXXXX-XXXXX-XXXXX">
                            <p class="text-xs text-gray-500 mt-1">Only applicable if 'Digital License Product' is checked.</p>
                        </div>
                    </div>
                    
                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="bg-gray-900 hover:bg-accent text-white font-bold py-2 px-6 rounded-lg shadow transition-colors">
                            Save Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
