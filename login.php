<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

if (isLoggedIn()) {
    header("Location: /Activition/index.php");
    exit;
}

$error = '';
$success = '';

if (isset($_GET['registered'])) {
    $success = 'Account created successfully. You can now log in.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Both fields are required.';
    } else {
        $stmt = $pdo->prepare("SELECT id, password, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            header("Location: /Activition/index.php");
            exit;
        } else {
            $error = 'Invalid email or password.';
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="max-w-md mx-auto px-4 py-16">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="bg-primary px-6 py-8 text-white text-center relative overflow-hidden">
            <h1 class="relative z-10 text-3xl font-bold mb-2">Welcome Back</h1>
            <p class="relative z-10 text-blue-100 font-medium">Log in to TechSupply Hub.</p>
        </div>
        
        <div class="p-6 md:p-8">
            <?php if ($error): ?>
                <div class="bg-red-50 text-red-600 p-3 rounded-lg mb-6 text-sm border border-red-100"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="bg-green-50 text-green-700 p-3 rounded-lg mb-6 text-sm border border-green-200"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <form method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent" placeholder="john@example.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent" placeholder="••••••••">
                </div>
                <button type="submit" class="w-full mt-6 bg-gray-900 hover:bg-accent text-white font-bold py-3 px-4 rounded-lg shadow transition-colors">
                    Log In
                </button>
            </form>
            
            <p class="text-center text-sm text-gray-600 mt-6">
                Don't have an account? <a href="/Activition/register.php" class="text-accent font-semibold hover:underline">Register here</a>
            </p>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
