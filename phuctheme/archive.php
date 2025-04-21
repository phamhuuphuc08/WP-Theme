<?php
// archive.php

get_header(); ?>

<main class="container py-5">
    <header class="archive-header mb-4">
        <h1 class="archive-title"><?php the_archive_title(); ?></h1>
    </header>

    <div class="row">
        <?php if (have_posts()) : 
            while (have_posts()) : the_post(); ?>
                <div class="col-md-4 mb-4">
                    <?php get_template_part('template-parts/content'); ?>
                </div>
            <?php endwhile; ?>
            
            <!-- Phân trang -->
            <div class="col-12">
                <nav class="pagination-nav">
                    <?php
                    the_posts_pagination([
                        'mid_size' => 2,
                        'prev_text' => __('Previous', 'phuctheme'),
                        'next_text' => __('Next', 'phuctheme'),
                    ]);
                    ?>
                </nav>
            </div>
        <?php else : ?>
            <div class="col-12">
                <p class="text-center"><?php _e('Sorry, no posts matched your criteria.', 'phuctheme'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>