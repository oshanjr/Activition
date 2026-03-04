<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activition Splash</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e3a8a', // blue-900
                        secondary: '#475569', // slate-600
                        accent: '#3b82f6', // blue-500
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Smooth scrolling */
        html { scroll-behavior: smooth; }
        
        /* Preloader Styles */
        #preloader {
            position: fixed;
            inset: 0;
            background-color: #f8fafc; /* gray-50 */
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }
        
        .loader {
            width: 48px;
            height: 48px;
            border: 5px solid #e2e8f0;
            border-bottom-color: #3b82f6; /* accent blue */
            border-radius: 50%;
            display: inline-block;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
        }

        @keyframes rotation {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        body.loaded #preloader {
            opacity: 0;
            visibility: hidden;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

<!-- Preloader -->
<div id="preloader">
    <div class="loader"></div>
</div>

<!-- Sticky Glassmorphism Navbar -->
<nav class="sticky top-0 z-50 backdrop-blur-lg bg-primary/90 text-white shadow-lg border-b border-blue-800/50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 gap-4">
            <!-- Left: Logo & Links -->
            <div class="flex items-center shrink-0">
                <a href="/Activition/index.php" class="font-bold text-xl tracking-tight flex items-center gap-2">
                    <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                    <span class="hidden lg:inline">Activition Splash</span>
                </a>
                <div class="hidden md:block ml-6 lg:ml-10">
                    <div class="flex items-baseline space-x-2 lg:space-x-4">
                        <a href="/Activition/index.php" class="hover:bg-blue-800 px-3 py-2 rounded-md text-sm font-medium transition-colors">Home</a>
                        <a href="/Activition/shop.php" class="hover:bg-blue-800 px-3 py-2 rounded-md text-sm font-medium transition-colors">Shop</a>
                        <a href="/Activition/about.php" class="hover:bg-blue-800 px-3 py-2 rounded-md text-sm font-medium transition-colors">About</a>
                        <a href="/Activition/contact.php" class="hover:bg-blue-800 px-3 py-2 rounded-md text-sm font-medium transition-colors">Contact</a>
                    </div>
                </div>
            </div>

            <!-- Center: Search Bar -->
            <div class="hidden sm:flex flex-1 justify-center px-4 max-w-lg transition-all duration-300">
                <form action="/Activition/shop.php" method="GET" class="relative w-full flex items-center group">
                    <input type="text" name="search" placeholder="Search..." class="w-full pl-4 pr-10 py-1.5 rounded-full text-sm text-gray-900 border-none focus:outline-none focus:ring-2 focus:ring-accent shadow-inner transition-all duration-300 bg-white/90 focus:bg-white" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                    <button type="submit" class="absolute right-2 text-gray-400 hover:text-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>
            </div>
            <div class="flex items-center space-x-4">
                <a href="/Activition/cart.php" class="flex items-center gap-1 hover:text-accent transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="text-sm font-medium">Cart</span>
                </a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <a href="/Activition/admin/index.php" class="bg-accent hover:bg-blue-600 text-white px-3 py-1 rounded text-sm font-medium transition-colors">Admin</a>
                    <?php
    endif; ?>
                    <a href="/Activition/logout.php" class="text-sm font-medium hover:text-red-400 transition-colors">Logout</a>
                <?php
else: ?>
                    <a href="/Activition/login.php" class="text-sm font-medium hover:text-accent transition-colors">Login</a>
                <?php
endif; ?>
            </div>
        </div>
    </div>
</nav>

<main class="flex-grow">
