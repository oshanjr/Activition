<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

// Fetch up to 4 featured products
$stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC LIMIT 4");
$featured_products = $stmt->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section -->
<div class="relative bg-primary text-white overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80" alt="Tech Background" class="w-full h-full object-cover opacity-20">
        <div class="absolute inset-0 bg-gradient-to-r from-primary to-transparent opacity-90"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32">
        <div class="max-w-2xl">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-6 leading-tight">
                Empower Your Business With <span class="text-accent border-b-4 border-accent">Premium Tech</span>
            </h1>
            <p class="text-lg md:text-xl text-blue-100 mb-8 max-w-xl">
                Source top-tier printers, hardware POS systems, and software licenses trusted by modern enterprises. Fast, secure, and reliable.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="/Activition/catalog.php" class="inline-block text-center bg-accent hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition-transform transform hover:-translate-y-1">
                    Explore Catalog
                </a>
                <a href="/Activition/register.php" class="inline-block text-center bg-white text-primary hover:bg-gray-100 font-bold py-3 px-8 rounded-lg shadow-lg transition-transform transform hover:-translate-y-1">
                    Partner With Us
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Features -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center pt-8">
            <div class="p-6">
                <div class="w-16 h-16 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Verified Products</h3>
                <p class="text-gray-600">All hardware and software licenses are genuine and manufacturer guaranteed.</p>
            </div>
            <div class="p-6">
                <div class="w-16 h-16 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Fast Fulfillment</h3>
                <p class="text-gray-600">Instant delivery for digital software licenses and next-day shipping for hardware.</p>
            </div>
            <div class="p-6">
                <div class="w-16 h-16 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Secure Payments</h3>
                <p class="text-gray-600">Enterprise-grade encryption keeps your transaction and data completely secure.</p>
            </div>
        </div>
    </div>
</div>

<!-- Featured Products -->
<div class="py-16 bg-gray-50 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900">Featured Equipment</h2>
                <p class="text-gray-500 mt-2">Discover our top-rated hardware and software solutions.</p>
            </div>
            <a href="/Activition/catalog.php" class="hidden sm:inline-block text-accent font-semibold hover:underline">View All &rarr;</a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach ($featured_products as $product): ?>
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="relative h-48 bg-gray-100 flex items-center justify-center p-4">
                        <?php if ($product['is_license']): ?>
                            <div class="absolute top-2 right-2 bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded">Digital</div>
                        <?php endif; ?>
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="max-h-full object-contain group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-5">
                        <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1"><?php echo htmlspecialchars($product['category_name']); ?></div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <div class="flex justify-between items-center mt-4">
                            <span class="text-xl font-black text-gray-900">$<?php echo number_format($product['price'], 2); ?></span>
                            <a href="/Activition/checkout.php?product_id=<?php echo $product['id']; ?>" class="bg-gray-900 hover:bg-accent text-white p-2 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="mt-8 sm:hidden text-center">
            <a href="/Activition/catalog.php" class="inline-block text-accent font-semibold hover:underline">View All Products &rarr;</a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
