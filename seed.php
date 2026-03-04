<?php
// seed.php
require 'config.php';

echo "Starting database seed...\n";

try {
    // Connect without dbname to create it
    $pdo_setup = new PDO("mysql:host=$db_host;charset=utf8mb4", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $pdo_setup->exec("DROP DATABASE IF EXISTS `$db_name`");
    $pdo_setup->exec("CREATE DATABASE `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database created.\n";

    $in_seed_post_creation = true;
    require 'config.php'; // Re-require to get $pdo connected to the new db

    // Create tables
    $pdo->exec("
        CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(150) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role ENUM('customer', 'admin') DEFAULT 'customer',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL,
            slug VARCHAR(50) NOT NULL UNIQUE,
            description TEXT
        );

        CREATE TABLE products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            category_id INT NOT NULL,
            name VARCHAR(200) NOT NULL,
            description TEXT,
            price DECIMAL(10, 2) NOT NULL,
            image_url VARCHAR(255),
            stock INT DEFAULT 0,
            is_license BOOLEAN DEFAULT FALSE,
            license_key VARCHAR(255) NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
        );
        CREATE TABLE tags (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL UNIQUE
        );

        CREATE TABLE product_tags (
            product_id INT NOT NULL,
            tag_id INT NOT NULL,
            PRIMARY KEY (product_id, tag_id),
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
            FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
        );

        CREATE TABLE hero_slides (
            id INT AUTO_INCREMENT PRIMARY KEY,
            image_url VARCHAR(255) NOT NULL,
            title VARCHAR(150),
            subtitle TEXT,
            button_text VARCHAR(50),
            button_link VARCHAR(255),
            order_index INT DEFAULT 0
        );
    ");
    echo "Tables created.\n";

    // Admin
    $admin_pw = password_hash('admin123', PASSWORD_DEFAULT);
    $pdo->exec("INSERT INTO users (name, email, password, role) VALUES ('Admin User', 'admin@techsupply.hub', '$admin_pw', 'admin')");

    // Super Admin
    $super_pw = password_hash('Oshan@2004', PASSWORD_DEFAULT);
    $pdo->exec("INSERT INTO users (name, email, password, role) VALUES ('oshanjr', 'oshanjr', '$super_pw', 'admin')");

    // Customer
    $customer_pw = password_hash('customer123', PASSWORD_DEFAULT);
    $pdo->exec("INSERT INTO users (name, email, password, role) VALUES ('John Doe', 'john@example.com', '$customer_pw', 'customer')");

    // Categories
    $pdo->exec("INSERT INTO categories (name, slug, description) VALUES 
        ('Printers', 'printers', 'High-quality printers for home and business.'),
        ('Computer Accessories', 'accessories', 'Peripherals and add-ons.'),
        ('POS Systems', 'pos-systems', 'Modern point-of-sale hardware.'),
        ('Software Licenses', 'software', 'Digital license keys.')
    ");

    // Products
    $pdo->exec("INSERT INTO products (category_id, name, description, price, image_url, stock, is_license, license_key) VALUES 
        (1, 'Epson EcoTank L3250', 'Wi-Fi All-in-One Ink Tank Printer', 199.99, 'https://placehold.co/400x300?text=Epson+EcoTank', 15, FALSE, NULL),
        (1, 'HP LaserJet Pro MFP M428fdw', 'Monochrome Laser Printer', 350.00, 'https://placehold.co/400x300?text=HP+LaserJet', 8, FALSE, NULL),
        (2, 'Logitech MX Master 3S', 'Wireless Performance Mouse', 99.99, 'https://placehold.co/400x300?text=Logitech+MX3S', 45, FALSE, NULL),
        (2, 'Keychron K2 Mechanical Keyboard', '75% Layout Bluetooth Keyboard', 79.99, 'https://placehold.co/400x300?text=Keychron+K2', 20, FALSE, NULL),
        (3, 'Square Terminal POS', 'All-in-one credit card machine for payments and receipts', 299.00, 'https://placehold.co/400x300?text=Square+Terminal', 10, FALSE, NULL),
        (3, 'Clover Station Duo', 'Fast and secure POS system for retail', 1200.00, 'https://placehold.co/400x300?text=Clover+Station', 5, FALSE, NULL),
        (4, 'Windows 11 Pro OEM Key', 'Digital activation key for Windows 11 Professional', 39.99, 'https://placehold.co/400x300?text=Win11+Pro', 100, TRUE, 'W269N-WFGWX-YVC9B-4J6C9-T83GX'),
        (4, 'Microsoft Office 2021 Professional Plus', 'Lifetime license key', 89.99, 'https://placehold.co/400x300?text=Office+2021', 50, TRUE, 'NMMKJ-6RK4F-KMJVX-8D9MJ-6PBKP')
    ");

    // Hero Slides
    $pdo->exec("INSERT INTO hero_slides (image_url, title, subtitle, button_text, button_link, order_index) VALUES 
        ('https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80', 'Empower Your Business With Premium Tech', 'Source top-tier printers, hardware POS systems, and software licenses trusted by modern enterprises. Fast, secure, and reliable.', 'Explore Shop', '/Activition/shop.php', 1),
        ('https://images.unsplash.com/photo-1504384308090-c894fdcc538d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80', 'Next-Gen Point of Sale Solutions', 'Upgrade your retail checkout experience with lightning-fast, beautifully designed POS hardware.', 'Shop POS Systems', '/Activition/shop.php?category=pos-systems', 2)
    ");

    echo "Dummy data inserted.\n";
    echo "Seeding completed successfully!\n";

}
catch (PDOException $e) {
    die("Seeding failed: " . $e->getMessage());
}
