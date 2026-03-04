<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        $error = 'Please fill out all fields.';
    }
    else {
        // In a real application, you'd send an email or save to DB here
        // mail("support@techsupply.hub", "Contact Form: $name", $message, "From: $email");
        $success = 'Thank you for your message! Our team will get back to you shortly.';
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<!-- Header Banner -->
<div class="bg-primary text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="fade-in">
        <h1 class="text-4xl font-extrabold mb-4">Contact Us</h1>
        <p class="text-blue-100 max-w-2xl mx-auto">We're here to help. Reach out to us for support, enterprise pricing, or any questions about our products.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <!-- Contact Info -->
        <div data-aos="fade-right">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">Get in Touch</h2>
            
            <div class="space-y-8">
                <div class="flex items-start">
                    <div class="flex-shrink-0 bg-blue-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Email Us</h3>
                        <p class="text-gray-600">support@techsupply.hub</p>
                        <p class="text-gray-600">sales@techsupply.hub</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0 bg-blue-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Call Us</h3>
                        <p class="text-gray-600">1-800-TECH-HUB (Toll Free)</p>
                        <p class="text-gray-500 text-sm">Mon-Fri from 8am to 5pm.</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0 bg-blue-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Headquarters</h3>
                        <p class="text-gray-600">123 Tech Lane</p>
                        <p class="text-gray-600">Silicon Valley, CA 94025</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8" data-aos="fade-left">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Send a Message</h3>
            
            <?php if ($error): ?>
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-6">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php
endif; ?>
            
            <?php if ($success): ?>
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php
endif; ?>

            <form method="POST" class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="name" id="name" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent">
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" id="email" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent">
                </div>
                
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                    <textarea name="message" id="message" rows="5" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent"></textarea>
                </div>
                
                <button type="submit" class="w-full bg-accent hover:bg-blue-600 text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transition-all">
                    Send Message
                </button>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
