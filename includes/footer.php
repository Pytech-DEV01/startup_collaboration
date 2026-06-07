    </div><!-- end .page-content -->

    <!-- Footer -->
    <footer class="footer-bar">
        <p>&copy; 2026 Startup Collaboration Portal. Built with ❤️</p>
    </footer>

    <!-- Main Script -->
    <script src="<?= $basePath ?>/assets/script.js"></script>

    <!-- Sidebar Toggle -->
    <script>
        document.querySelector('.mobile-toggle')?.addEventListener('click', () => {
            document.querySelector('.sidebar').classList.toggle('active');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            const sidebar = document.querySelector('.sidebar');
            const toggle = document.querySelector('.mobile-toggle');
            if (window.innerWidth <= 768 && sidebar?.classList.contains('active')) {
                if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });
    </script>
</body>
</html>
