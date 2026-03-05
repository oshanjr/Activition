<?php
$current_page = basename($_SERVER['PHP_SELF']);

$admin_links = [
    'index.php' => 'Dashboard',
    'products.php' => 'Manage Products',
    'categories.php' => 'Manage Categories',
    'tags.php' => 'Manage Tags',
    'slides.php' => 'Hero Slides',
    'users.php' => 'Manage Admins & Users',
    'pages.php' => 'Manage Pages (CMS)',
];

// Determine the base page for active state highlighting
$base_page = $current_page;
if (strpos($current_page, 'products_') === 0)
    $base_page = 'products.php';
if (strpos($current_page, 'categories_') === 0)
    $base_page = 'categories.php';
if (strpos($current_page, 'tags_') === 0)
    $base_page = 'tags.php';
if (strpos($current_page, 'slides_') === 0)
    $base_page = 'slides.php';
if (strpos($current_page, 'users_') === 0)
    $base_page = 'users.php';
if (strpos($current_page, 'pages_') === 0)
    $base_page = 'pages.php';
?>
<!-- Admin Sidebar -->
<div class="w-full md:w-64 flex-shrink-0">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Admin Menu</h3>
        <ul class="space-y-3">
            <?php foreach ($admin_links as $url => $label): ?>
                <?php
    $is_active = ($base_page === $url);
    $classes = $is_active
        ? "block text-sm text-accent font-bold"
        : "block text-sm text-gray-600 hover:text-primary transition-colors";
?>
                <li><a href="/Activition/admin/<?php echo $url; ?>" class="<?php echo $classes; ?>"><?php echo htmlspecialchars($label); ?></a></li>
            <?php
endforeach; ?>
        </ul>
    </div>
</div>
