<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'customer';

    if (empty($name) || empty($email) || empty($password)) {
        $error = 'Name, Email, and Password are required.';
    }
    else {
        try {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$name, $email, $hashed, $role])) {
                $success = 'User added successfully.';
            }
            else {
                $error = 'Failed to add user.';
            }
        }
        catch (PDOException $e) {
            $error = 'Database error: Note that emails must be unique.';
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Admin Sidebar -->
        <?php require_once __DIR__ . '/../includes/admin_sidebar.php'; ?>

        <!-- Content -->
        <div class="flex-1">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-extrabold text-gray-900">Add User</h1>
                <a href="/Activition/admin/users.php" class="text-gray-600 hover:text-primary">&larr; Back to Users</a>
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
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name or Username</label>
                        <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent" placeholder="John Doe">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent" placeholder="john@example.com">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Temporary Password</label>
                        <input type="password" name="password" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent" placeholder="Enter password">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select name="role" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent bg-white">
                            <option value="customer">Customer</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    
                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="bg-gray-900 hover:bg-accent text-white font-bold py-2 px-6 rounded-lg shadow transition-colors">
                            Save User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
