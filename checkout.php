<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/header.php';

$product_id = $_GET['product_id'] ?? null;
$product = null;

if ($product_id) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();
}

$product_name = $product ? $product['name'] : 'Demo Product Selection';
$product_price = $product ? (float)$product['price'] : 299.00;
$tax = $product_price * 0.05;
$total = $product_price + $tax;
?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="bg-primary px-6 py-8 md:p-10 text-white text-center relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 blur-xl bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
            <h1 class="relative z-10 text-3xl md:text-4xl font-extrabold mb-3">Simulated Checkout</h1>
            <p class="relative z-10 text-blue-100 font-medium">This is a demonstration payment page for the high-fidelity prototype.</p>
        </div>
        
        <div class="p-6 md:p-10">
            <div class="flex flex-col md:flex-row gap-12">
                
                <!-- Order Summary Dummy -->
                <div class="flex-1 order-2 md:order-1">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8 border-b border-gray-100 pb-4">Payment Details</h2>
                    <form onsubmit="alert('Simulated Order Placed successfully!'); return false;" class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent transition-shadow focus:bg-white" placeholder="John Doe">
                            </div>
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-xs text-gray-400 font-normal">(for digital delivery)</span></label>
                                <input type="email" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent transition-shadow focus:bg-white" placeholder="john@example.com">
                            </div>
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
                                <div class="relative">
                                    <input type="text" required class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent transition-shadow focus:bg-white" placeholder="XXXX XXXX XXXX XXXX">
                                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                                <input type="text" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent transition-shadow focus:bg-white" placeholder="MM/YY">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">CVC</label>
                                <input type="text" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent transition-shadow focus:bg-white" placeholder="123">
                            </div>
                        </div>
                        <button type="submit" class="w-full mt-8 bg-gray-900 hover:bg-accent text-white font-bold py-3.5 px-4 rounded-lg shadow-md transition-all transform hover:-translate-y-0.5">
                            Complete Secure Checkout
                        </button>
                    </form>
                </div>

                <!-- Dummy Cart -->
                <div class="w-full md:w-80 order-1 md:order-2 bg-gray-50 p-6 rounded-2xl border border-gray-200 self-start">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Order Summary</h3>
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-start bg-white p-3 rounded-lg border border-gray-100 shadow-sm">
                            <div class="text-sm">
                                <p class="font-bold text-gray-900"><?php echo htmlspecialchars($product_name); ?></p>
                                <p class="text-gray-500 mt-1">Qty: 1</p>
                            </div>
                            <div class="text-sm font-bold text-gray-900">$<?php echo number_format($product_price, 2); ?></div>
                        </div>
                    </div>
                    <div class="pt-4 space-y-3 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-medium text-gray-900">$<?php echo number_format($product_price, 2); ?></span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Estimated Tax</span>
                            <span class="font-medium text-gray-900">$<?php echo number_format($tax, 2); ?></span>
                        </div>
                        <div class="flex justify-between text-lg font-black text-gray-900 pt-4 border-t border-gray-200 mt-2">
                            <span>Total</span>
                            <span>$<?php echo number_format($total, 2); ?></span>
                        </div>
                    </div>
                    
                    <div class="mt-8 flex items-center justify-center gap-2 text-xs text-gray-500 font-medium">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        SSL Secure Encrypted Payment
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
