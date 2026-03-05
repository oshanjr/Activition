<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

// Fetch up to 4 featured products
$stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC LIMIT 4");
$featured_products = $stmt->fetchAll();

// Fetch Hero Slides
$slides = $pdo->query("SELECT * FROM hero_slides ORDER BY order_index ASC")->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section (Dynamic Carousel) -->
<div class="relative w-full h-[85vh] md:h-[70vh] min-h-[450px] md:min-h-[500px] max-h-[800px] overflow-hidden group">
    <!-- Carousel Track -->
    <div id="heroCarousel" class="h-full w-full flex transition-transform duration-700 ease-in-out">
        <?php foreach ($slides as $index => $slide): ?>
            <div class="w-full shrink-0 h-full relative flex items-center justify-center overflow-hidden">
                <div class="absolute inset-0">
                    <img src="<?php echo htmlspecialchars($slide['image_url']); ?>" alt="<?php echo htmlspecialchars($slide['title']); ?>" class="w-full h-full object-cover opacity-30">
                    <div class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-r from-primary/90 via-primary/70 to-primary/40"></div>
                </div>
                
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full z-10 text-center md:text-left mt-10 md:mt-0">
                    <div class="max-w-2xl mx-auto md:mx-0" data-aos="fade-up" data-aos-duration="1000">
                        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-normal md:tracking-tight mb-4 md:mb-6 leading-tight text-white drop-shadow-md break-words">
                            <?php echo htmlspecialchars($slide['title']); ?>
                        </h1>
                        <p class="text-base sm:text-lg md:text-2xl text-blue-50 mb-6 md:mb-8 max-w-xl mx-auto md:mx-0 font-light drop-shadow">
                            <?php echo htmlspecialchars($slide['subtitle']); ?>
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 md:gap-4 items-center justify-center md:justify-start">
                            <?php if (!empty($slide['button_link']) && !empty($slide['button_text'])): ?>
                                <a href="<?php echo htmlspecialchars($slide['button_link']); ?>" class="inline-flex justify-center items-center text-center bg-accent hover:bg-blue-600 text-white font-bold py-3 px-8 md:py-4 md:px-10 rounded-lg shadow-xl shadow-blue-500/20 transition-transform transform hover:-translate-y-1 hover:scale-105">
                                    <?php echo htmlspecialchars($slide['button_text']); ?>
                                </a>
                            <?php
    endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
endforeach; ?>
    </div>

    <!-- Navigation Controls -->
    <?php if (count($slides) > 1): ?>
        <button id="prevSlide" class="absolute top-1/2 left-4 md:left-8 -translate-y-1/2 bg-white/10 hover:bg-white/30 text-white p-3 rounded-full backdrop-blur-sm transition-all opacity-0 group-hover:opacity-100 focus:opacity-100 z-20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <button id="nextSlide" class="absolute top-1/2 right-4 md:right-8 -translate-y-1/2 bg-white/10 hover:bg-white/30 text-white p-3 rounded-full backdrop-blur-sm transition-all opacity-0 group-hover:opacity-100 focus:opacity-100 z-20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
    <?php
endif; ?>
</div>

<!-- Carousel Script -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const carousel = document.getElementById('heroCarousel');
        const prevBtn = document.getElementById('prevSlide');
        const nextBtn = document.getElementById('nextSlide');
        const slideCount = <?php echo count($slides); ?>;
        
        if (slideCount <= 1) return;

        let currentIndex = 0;
        let slideInterval;

        function updateCarousel() {
            carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % slideCount;
            updateCarousel();
        }

        function prevSlide() {
            currentIndex = (currentIndex - 1 + slideCount) % slideCount;
            updateCarousel();
        }

        if(nextBtn && prevBtn) {
            nextBtn.addEventListener('click', () => { nextSlide(); resetInterval(); });
            prevBtn.addEventListener('click', () => { prevSlide(); resetInterval(); });
        }

        function resetInterval() {
            clearInterval(slideInterval);
            slideInterval = setInterval(nextSlide, 5000);
        }

        resetInterval();
    });
</script>

<!-- Features -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center pt-8">
            <div class="p-6" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4 transition-transform hover:scale-110 duration-300 shadow-lg shadow-blue-500/20">
                    <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Verified Products</h3>
                <p class="text-gray-600">All hardware and software licenses are genuine and manufacturer guaranteed.</p>
            </div>
            <div class="p-6" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4 transition-transform hover:scale-110 duration-300 shadow-lg shadow-blue-500/20">
                    <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Fast Fulfillment</h3>
                <p class="text-gray-600">Instant delivery for digital software licenses and next-day shipping for hardware.</p>
            </div>
            <div class="p-6" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4 transition-transform hover:scale-110 duration-300 shadow-lg shadow-blue-500/20">
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
            <a href="/shop.php" class="hidden sm:inline-block text-accent font-semibold hover:underline">View All &rarr;</a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php $delay = 100;
foreach ($featured_products as $product): ?>
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                    <div class="relative h-48 bg-gray-50 flex items-center justify-center p-4">
                        <?php if ($product['is_license']): ?>
                            <div class="absolute top-2 right-2 bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded shadow-sm">Digital</div>
                        <?php
    endif; ?>
                        <a href="/product.php?id=<?php echo $product['id']; ?>" class="h-full flex items-center justify-center">
                            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="max-h-full object-contain group-hover:scale-110 transition-transform duration-500">
                        </a>
                    </div>
                    <div class="p-5">
                        <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1"><?php echo htmlspecialchars($product['category_name']); ?></div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">
                            <a href="/product.php?id=<?php echo $product['id']; ?>" class="hover:text-accent transition-colors"><?php echo htmlspecialchars($product['name']); ?></a>
                        </h3>
                        <div class="flex justify-between items-center mt-4">
                            <span class="text-xl font-black text-gray-900">LKR <?php echo number_format($product['price'], 2); ?></span>
                            <a href="/cart.php?action=add&product_id=<?php echo $product['id']; ?>" class="bg-gray-900 hover:bg-accent hover:-translate-y-1 text-white p-2 rounded-lg transition-all shadow-md">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            <?php $delay += 100;
endforeach; ?>
        </div>
        <div class="mt-8 sm:hidden text-center">
            <a href="/shop.php" class="inline-block text-accent font-semibold hover:underline">View All Products &rarr;</a>
        </div>
    </div>
</div>



<!-- Statistics Section -->
<div class="relative py-20 bg-primary text-white overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-blue-900 opacity-90"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-blue-800/50">
            <div data-aos="zoom-in" data-aos-delay="0">
                <div class="text-4xl md:text-5xl font-black text-accent mb-2">5K+</div>
                <div class="text-sm md:text-base text-blue-200 font-medium uppercase tracking-wider">Happy Clients</div>
            </div>
            <div data-aos="zoom-in" data-aos-delay="100">
                <div class="text-4xl md:text-5xl font-black text-accent mb-2">99%</div>
                <div class="text-sm md:text-base text-blue-200 font-medium uppercase tracking-wider">Uptime SLA</div>
            </div>
            <div data-aos="zoom-in" data-aos-delay="200">
                <div class="text-4xl md:text-5xl font-black text-accent mb-2">24/7</div>
                <div class="text-sm md:text-base text-blue-200 font-medium uppercase tracking-wider">Expert Support</div>
            </div>
            <div data-aos="zoom-in" data-aos-delay="300">
                <div class="text-4xl md:text-5xl font-black text-accent mb-2">10+</div>
                <div class="text-sm md:text-base text-blue-200 font-medium uppercase tracking-wider">Years Experience</div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="py-20 bg-gray-50 border-b border-gray-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="fade-up">
        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6">Ready to upgrade your infrastructure?</h2>
        <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto">
            Join thousands of businesses that trust Activition Splash for their critical hardware and software needs. Start browsing our catalog today.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="/shop.php" class="inline-flex justify-center items-center px-8 py-4 border border-transparent text-lg font-bold rounded-lg text-white bg-accent hover:bg-blue-600 shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-1">
                Shop Now
            </a>
            <a href="/contact.php" class="inline-flex justify-center items-center px-8 py-4 border-2 border-gray-300 text-lg font-bold rounded-lg text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 transition-all transform hover:-translate-y-1">
                Contact Sales
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
