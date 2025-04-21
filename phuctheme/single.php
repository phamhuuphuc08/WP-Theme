<?php
// File: wp-content/themes/phuctheme/single.php
get_header(); ?>

<main class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('mb-4'); ?>>
                        <header class="entry-header mb-3">
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                            <div class="entry-meta text-muted mb-2">
                                <span><?php _e('Published on', 'phuctheme'); ?> <?php echo get_the_date(); ?></span>
                            </div>
                        </header>
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                        <div class="post-actions mt-3">
                            <button class="btn btn-link like-button" data-post-id="<?php the_ID(); ?>">
                                <span class="like-icon">👍</span> Thích
                                <span class="like-count"><?php echo get_post_meta(get_the_ID(), 'like_count', true) ?: '0'; ?></span>
                            </button>
                            <a href="<?php the_permalink(); ?>#respond" class="btn btn-link comment-button">
                                <span class="comment-icon">💬</span> Bình luận
                            </a>
                            <button class="btn btn-link share-button" data-post-id="<?php the_ID(); ?>">
                                <span class="share-icon">📤</span> Gửi
                            </button>
                        </div>
                    </article>
                    <?php
                    // Hiển thị form bình luận
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                endwhile;
            else :
                ?>
                <p class="text-center"><?php _e('No content found', 'phuctheme'); ?></p>
            <?php endif; ?>
        </div>
        <div class="col-md-4">
            <?php get_sidebar(); ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>