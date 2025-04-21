<?php
// File: wp-content/themes/phuctheme/sidebar.php
if (!dynamic_sidebar('main-sidebar')) : ?>
    <div class="widget">
        <h3><?php _e('Recent Posts', 'phuctheme'); ?></h3>
        <ul>
            <?php
            $recent_posts = new WP_Query([
                'posts_per_page' => 5,
                'post_status' => 'publish',
            ]);
            while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </ul>
    </div>
<?php endif; ?>