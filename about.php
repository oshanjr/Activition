<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/header.php';
?>

<!-- Header Banner -->
<div class="relative bg-primary text-white py-20">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80" alt="About Us" class="w-full h-full object-cover opacity-20">
        <div class="absolute inset-0 bg-primary/80"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="fade-up">
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4">About Activition Splash</h1>
        <p class="text-xl text-blue-100 max-w-2xl mx-auto">Empowering businesses with premium technology solutions since 2024.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-16">
        <div data-aos="fade-right">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Mission</h2>
            <p class="text-lg text-gray-600 mb-4 leading-relaxed">
                At Activition Splash, our mission is to provide businesses of all sizes with the highest quality technology hardware and software solutions. We believe that the right tools can exponentially increase productivity and drive growth.
            </p>
            <p class="text-lg text-gray-600 leading-relaxed">
                From top-tier printers and robust POS systems to genuine software licenses, we carefully curate our catalog to ensure reliability, security, and performance.
            </p>
        </div>
        <div class="relative rounded-2xl overflow-hidden shadow-2xl" data-aos="fade-left">
            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Team working" class="w-full h-auto">
            <div class="absolute inset-0 bg-gradient-to-tr from-accent/20 to-transparent"></div>
        </div>
    </div>

    <div class="bg-gray-50 rounded-3xl p-8 md:p-12 text-center" data-aos="zoom-in">
        <h2 class="text-3xl font-bold text-gray-900 mb-12">Why Choose Us?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h3 class="text-xl font-bold mb-3">Authentic Products</h3>
                <p class="text-gray-600">We guarantee that 100% of our hardware and software licenses are genuine and manufacturer-backed.</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold mb-3">Instant Delivery</h3>
                <p class="text-gray-600">Receive your digital software licenses instantly via email alongside lightning-fast hardware shipping.</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold mb-3">Expert Support</h3>
                <p class="text-gray-600">Our team of technical experts is available 24/7 to help you choose and configure your tech stack.</p>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
