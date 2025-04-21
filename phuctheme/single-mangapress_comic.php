<?php
// Lấy thông tin bài viết hiện tại
if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        get_header(); ?>

        <div class="comic-header">
            <h1><?php the_title(); ?></h1>
            <div class="comic-meta">
                
            </div>
        </div>

        <div class="comic-content">
            <?php the_content(); ?>
        </div>

        <?php get_footer(); ?>
    <?php endwhile;
endif;
?>
