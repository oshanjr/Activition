</main>

<footer class="bg-gray-900 text-white pt-12 pb-8 border-t border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8" data-aos="fade-up" data-aos-duration="800">
            <div class="col-span-1 md:col-span-2">
                <a href="/Activition/index.php" class="font-bold text-xl tracking-tight flex items-center gap-2 mb-4 text-white">
                    <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                    Activition Splash
                </a>
                <p class="text-gray-400 text-sm max-w-sm mb-6">
                    Your premier destination for high-quality printers, POS systems, computer accessories, and genuine software licenses. Empowering businesses with top-tier technology.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <span class="sr-only">Facebook</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <span class="sr-only">Twitter</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
                    </a>
                </div>
            </div>
            
            <div>
                <h4 class="text-white font-bold mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="/Activition/shop.php" class="hover:text-accent transition-colors">Shop All Products</a></li>
                    <li><a href="/Activition/shop.php?category=printers" class="hover:text-accent transition-colors">Printers</a></li>
                    <li><a href="/Activition/shop.php?category=pos-systems" class="hover:text-accent transition-colors">POS Systems</a></li>
                    <li><a href="/Activition/shop.php?category=software" class="hover:text-accent transition-colors">Software Licenses</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="text-white font-bold mb-4">Support</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="/Activition/about.php" class="hover:text-accent transition-colors">About Us</a></li>
                    <li><a href="/Activition/contact.php" class="hover:text-accent transition-colors">Contact Us</a></li>
                    <li><a href="#" class="hover:text-accent transition-colors">Shipping Policy</a></li>
                    <li><a href="#" class="hover:text-accent transition-colors">Returns & Refunds</a></li>
                </ul>
            </div>
        </div>
        
        <div class="pt-8 border-t border-gray-800 text-center text-sm text-gray-500 flex flex-col items-center">
            <p>&copy; <?php echo date('Y'); ?> Activition Splash. All rights reserved.</p>
            <p class="mt-2 text-xs opacity-75">Developed by osh\anjr.</p>
        </div>
    </div>
</footer>

<!-- AOS Scripts -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  // Hide preloader when page loads
  window.addEventListener('load', function() {
    document.body.classList.add('loaded');
  });

  // Initialize AOS
  AOS.init({
    once: true,
    offset: 50,
  });
</script>

</body>
</html>
