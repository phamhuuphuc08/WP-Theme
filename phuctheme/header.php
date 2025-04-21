<?php
// File: wp-content/themes/phuctheme/header.php
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'menu_class' => 'navbar-nav ml-auto',
                        'container' => false,
                        'walker' => new WP_Bootstrap_Navwalker(),
                    ]);
                    ?>
                </div>
            </div>
        </nav>
        <!-- Thêm menu Series bên dưới menu chính -->
        <div class="series-menu container">
            <?php
            wp_nav_menu([
                'theme_location' => 'series_menu',
                'menu_class' => 'series-nav',
                'container' => false,
                'walker' => new WP_Bootstrap_Navwalker(),
                'fallback_cb' => false,
            ]);
            ?>
        </div>
    </header>