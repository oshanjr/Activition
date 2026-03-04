<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

if (isLoggedIn()) {
    header("Location: /Activition/index.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($email) || empty($password)) {
        $error = 'All fields are required.';
    }
    else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'Email is already registered.';
        }
        else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'customer')");
            if ($stmt->execute([$name, $email, $hashed])) {
                header("Location: /Activition/login.php?registered=1");
                exit;
            }
            else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="max-w-md mx-auto px-4 py-16">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="bg-primary px-6 py-8 text-white text-center relative overflow-hidden">
            <h1 class="relative z-10 text-3xl font-bold mb-2">Create Account</h1>
            <p class="relative z-10 text-blue-100 font-medium">Join Activition Splash today.</p>
        </div>
        
        <div class="p-6 md:p-8">
            <?php if ($error): ?>
                <div class="bg-red-50 text-red-600 p-3 rounded-lg mb-6 text-sm border border-red-100"><?php echo htmlspecialchars($error); ?></div>
            <?php
endif; ?>
            
            <form method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="name" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent" placeholder="John Doe">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent" placeholder="john@example.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent" placeholder="••••••••">
                </div>
                <button type="submit" class="w-full mt-6 bg-gray-900 hover:bg-accent text-white font-bold py-3 px-4 rounded-lg shadow transition-colors">
                    Register
                </button>
            </form>
            
            <p class="text-center text-sm text-gray-600 mt-6">
                Already have an account? <a href="/Activition/login.php" class="text-accent font-semibold hover:underline">Log in here</a>
            </p>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
