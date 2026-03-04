<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_GET['action'] ?? '';
$product_id = $_GET['product_id'] ?? null;

if ($action === 'add' && $product_id) {
    if (!isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = 1;
    }
    else {
        $_SESSION['cart'][$product_id]++;
    }
    header("Location: /Activition/cart.php");
    exit;
}
elseif ($action === 'remove' && $product_id) {
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
    header("Location: /Activition/cart.php");
    exit;
}
elseif ($action === 'clear') {
    $_SESSION['cart'] = [];
    header("Location: /Activition/cart.php");
    exit;
}

// Fetch products in cart
$cart_items = [];
$subtotal = 0;

if (!empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $in = str_repeat('?,', count($ids) - 1) . '?';
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($in)");
    $stmt->execute($ids);
    $products = $stmt->fetchAll();

    foreach ($products as $p) {
        $qty = $_SESSION['cart'][$p['id']];
        $line_total = $qty * $p['price'];
        $subtotal += $line_total;
        $cart_items[] = [
            'product' => $p,
            'qty' => $qty,
            'line_total' => $line_total
        ];
    }
}

$tax = $subtotal * 0.05;
$total = $subtotal + $tax;

require_once __DIR__ . '/includes/header.php';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Shopping Cart</h1>

    <?php if (empty($cart_items)): ?>
        <div class="bg-white rounded-xl shadow border border-gray-100 p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Your cart is empty</h3>
            <p class="text-gray-500 mb-6">Looks like you haven't added any products to your cart yet.</p>
            <a href="/Activition/shop.php" class="inline-block bg-primary hover:bg-blue-800 text-white font-bold py-2 px-6 rounded-lg transition-colors">Continue Shopping</a>
        </div>
    <?php
else: ?>
        <div class="flex flex-col md:flex-row gap-8">
            <div class="flex-1 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Price</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Quantity</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 p-4">
                        <?php foreach ($cart_items as $item): ?>
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <img src="<?php echo htmlspecialchars($item['product']['image_url']); ?>" alt="<?php echo htmlspecialchars($item['product']['name']); ?>" class="w-16 h-16 object-contain mr-4 bg-gray-50 p-1 rounded">
                                        <span class="font-medium text-gray-900"><?php echo htmlspecialchars($item['product']['name']); ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center text-gray-500">LKR <?php echo number_format($item['product']['price'], 2); ?></td>
                                <td class="px-6 py-4 text-center font-medium"><?php echo $item['qty']; ?></td>
                                <td class="px-6 py-4 text-right font-medium text-gray-900">LKR <?php echo number_format($item['line_total'], 2); ?></td>
                                <td class="px-6 py-4 text-right">
                                    <a href="/Activition/cart.php?action=remove&product_id=<?php echo $item['product']['id']; ?>" class="text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </a>
                                </td>
                            </tr>
                        <?php
    endforeach; ?>
                    </tbody>
                </table>
                <div class="p-4 border-t border-gray-100 text-right">
                    <a href="/Activition/cart.php?action=clear" class="text-sm text-gray-500 hover:text-red-600 transition-colors">Clear Cart</a>
                </div>
            </div>
            
            <div class="w-full md:w-80 bg-gray-50 p-6 rounded-xl border border-gray-200 self-start">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Order Summary</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span class="font-medium text-gray-900">LKR <?php echo number_format($subtotal, 2); ?></span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Estimated Tax</span>
                        <span class="font-medium text-gray-900">LKR <?php echo number_format($tax, 2); ?></span>
                    </div>
                    <div class="flex justify-between text-lg font-black text-gray-900 pt-4 border-t border-gray-200 mt-2">
                        <span>Total</span>
                        <span>LKR <?php echo number_format($total, 2); ?></span>
                    </div>
                </div>
                <a href="/Activition/checkout.php?cart=1" class="block w-full text-center mt-8 bg-gray-900 hover:bg-accent text-white font-bold py-3.5 px-4 rounded-lg shadow-md transition-all">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    <?php
endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
