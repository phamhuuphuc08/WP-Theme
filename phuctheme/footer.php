<?php
// File: wp-content/themes/phuctheme/footer.php
?>
<footer class="bg-dark text-white py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <p>© <?php echo date('Y'); ?> Hello WordPress Phuc. All rights reserved.</p>
            </div>
            <div class="col-12 text-center mt-2">
                <?php
                wp_nav_menu([
                    'theme_location' => 'footer_menu',
                    'menu_class' => 'list-inline',
                    'container' => false,
                    'fallback_cb' => false,
                    'depth' => 1,
                ]);
                ?>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>