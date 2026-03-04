<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

// Fetch categories for filtering
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();

$category_filter = $_GET['category'] ?? '';
$search_query = trim($_GET['search'] ?? '');

// Build query dynamically based on logic
$sql = "SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE 1=1";
$params = [];

if ($category_filter) {
    $sql .= " AND c.slug = ?";
    $params[] = $category_filter;
}
if ($search_query) {
    $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)";
    $params[] = '%' . $search_query . '%';
    $params[] = '%' . $search_query . '%';
}
$sql .= " ORDER BY p.id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<div class="bg-primary text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-extrabold mb-4">Product Shop</h1>
        <p class="text-blue-100 max-w-2xl mx-auto">Browse our comprehensive selection of point-of-sale systems, printing solutions, accessories, and digital licenses.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col md:flex-row gap-8">
        
        <!-- Sidebar Filters -->
        <div class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Categories</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="/Activition/shop.php" class="block text-sm transition-colors <?php echo empty($category_filter) ? 'text-accent font-bold' : 'text-gray-600 hover:text-primary'; ?>">
                            All Products
                        </a>
                    </li>
                    <?php foreach ($categories as $cat): ?>
                        <li>
                            <a href="/Activition/shop.php?category=<?php echo urlencode($cat['slug']); ?>" 
                               class="block text-sm transition-colors <?php echo $category_filter === $cat['slug'] ? 'text-accent font-bold' : 'text-gray-600 hover:text-primary'; ?>">
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </a>
                        </li>
                    <?php
endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="flex-1">
            <?php if (empty($products)): ?>
                <div class="bg-white rounded-xl shadow border border-gray-100 p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No products found</h3>
                    <p class="text-gray-500">We couldn't find any products in this category.</p>
                </div>
            <?php
else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($products as $product): ?>
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col group">
                            <div class="relative h-48 bg-gray-50 flex items-center justify-center p-4">
                                <?php if ($product['is_license']): ?>
                                    <div class="absolute top-2 right-2 bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded">Digital</div>
                                <?php
        endif; ?>
                                <?php if ($product['stock'] <= 5 && $product['stock'] > 0): ?>
                                    <div class="absolute top-2 left-2 bg-orange-100 text-orange-800 text-xs font-bold px-2 py-1 rounded">Low Stock</div>
                                <?php
        elseif ($product['stock'] == 0): ?>
                                    <div class="absolute top-2 left-2 bg-red-100 text-red-800 text-xs font-bold px-2 py-1 rounded">Out of Stock</div>
                                <?php
        endif; ?>
                                <a href="/Activition/product.php?id=<?php echo $product['id']; ?>" class="h-full flex items-center justify-center">
                                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="max-h-full object-contain group-hover:scale-105 transition-transform duration-300">
                                </a>
                            </div>
                            <div class="p-5 flex-1 flex flex-col">
                                <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1"><?php echo htmlspecialchars($product['category_name']); ?></div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">
                                    <a href="/Activition/product.php?id=<?php echo $product['id']; ?>" class="hover:text-accent"><?php echo htmlspecialchars($product['name']); ?></a>
                                </h3>
                                <p class="text-sm text-gray-600 mb-4 flex-1 line-clamp-3"><?php echo htmlspecialchars($product['description']); ?></p>
                                
                                <div class="flex justify-between items-end mt-auto pt-4 border-t border-gray-100">
                                    <span class="text-2xl font-black text-gray-900">LKR <?php echo number_format($product['price'], 2); ?></span>
                                    
                                    <?php if ($product['stock'] > 0): ?>
                                        <a href="/Activition/cart.php?action=add&product_id=<?php echo $product['id']; ?>" class="bg-gray-900 hover:bg-accent text-white py-2 px-4 rounded-lg text-sm font-bold transition-colors shadow flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            Add to Cart
                                        </a>
                                    <?php
        else: ?>
                                        <button disabled class="bg-gray-200 text-gray-500 py-2 px-4 rounded-lg text-sm font-bold cursor-not-allowed">
                                            Out of Stock
                                        </button>
                                    <?php
        endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php
    endforeach; ?>
                </div>
            <?php
endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
