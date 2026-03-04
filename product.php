<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: /Activition/shop.php");
    exit;
}

$stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    header("Location: /Activition/shop.php");
    exit;
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumbs -->
    <nav class="flex mb-8 text-sm text-gray-500">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="/Activition/index.php" class="hover:text-gray-900 transition-colors">Home</a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <a href="/Activition/shop.php" class="hover:text-gray-900 transition-colors">Shop</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <a href="/Activition/shop.php?category=<?php echo urlencode($product['category_name']); ?>" class="hover:text-gray-900 transition-colors"><?php echo htmlspecialchars($product['category_name']); ?></a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="text-gray-400 max-w-[150px] md:max-w-xs truncate"><?php echo htmlspecialchars($product['name']); ?></span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden relative">
        <div class="flex flex-col md:flex-row">
            <!-- Product Image -->
            <div class="w-full md:w-1/2 p-8 md:p-12 bg-gray-50 flex items-center justify-center border-b md:border-b-0 md:border-r border-gray-100">
                <div class="relative w-full max-w-sm aspect-square">
                    <?php if ($product['is_license']): ?>
                        <div class="absolute top-0 right-0 z-10 bg-blue-100 text-blue-800 text-sm font-bold px-3 py-1 rounded shadow-sm">Digital License</div>
                    <?php
endif; ?>
                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-full h-full object-contain">
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                <div class="text-sm text-accent font-bold tracking-wider uppercase mb-2"><?php echo htmlspecialchars($product['category_name']); ?></div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4"><?php echo htmlspecialchars($product['name']); ?></h1>
                
                <div class="text-3xl font-black text-gray-900 mb-6 border-b border-gray-100 pb-6">
                    $<?php echo number_format($product['price'], 2); ?>
                </div>
                
                <div class="prose prose-sm text-gray-600 mb-8">
                    <h3 class="font-bold text-gray-900 mb-2">Description</h3>
                    <p class="leading-relaxed"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                </div>
                
                <!-- Stock Status -->
                <div class="mb-8">
                    <?php if ($product['stock'] > 10): ?>
                        <div class="flex items-center text-green-600 font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            In Stock
                        </div>
                    <?php
elseif ($product['stock'] > 0): ?>
                        <div class="flex items-center text-orange-600 font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Only <?php echo $product['stock']; ?> left in stock
                        </div>
                    <?php
else: ?>
                        <div class="flex items-center text-red-600 font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Out of Stock
                        </div>
                    <?php
endif; ?>
                </div>
                
                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-4 mt-auto">
                    <?php if ($product['stock'] > 0): ?>
                        <a href="/Activition/cart.php?action=add&product_id=<?php echo $product['id']; ?>" class="flex-1 flex justify-center items-center bg-white hover:bg-gray-50 text-gray-900 border-2 border-gray-900 font-bold py-3.5 px-6 rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Add to Cart
                        </a>
                        <a href="/Activition/checkout.php?product_id=<?php echo $product['id']; ?>" class="flex-1 text-center bg-gray-900 hover:bg-accent text-white font-bold py-3.5 px-6 rounded-lg shadow-md transition-colors">
                            Buy it Now
                        </a>
                    <?php
else: ?>
                        <button disabled class="w-full bg-gray-200 text-gray-500 font-bold py-3.5 px-6 rounded-lg cursor-not-allowed">
                            Currently Unavailable
                        </button>
                    <?php
endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
