<?php
// File: wp-content/themes/phuctheme/index.php
get_header(); ?>

<main class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <h1 class="text-center mb-4">Hello WordPress</h1>
            <div class="search-widget mb-4">
                <h3><?php _e('Search', 'phuctheme'); ?></h3>
                <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                    <label>
                        <span class="screen-reader-text"><?php _e('Search for:', 'phuctheme'); ?></span>
                        <input type="search" id="search-input" class="search-field" placeholder="<?php _e('Search', 'phuctheme'); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
                    </label>
                    <input type="submit" class="search-submit" value="<?php _e('Tìm kiếm', 'phuctheme'); ?>" />
                    <div id="search-suggestions" class="search-suggestions"></div>
                </form>
            </div>
            <?php
            $args = [
                'post_type' => 'post',
                'posts_per_page' => 10,
            ];
            $query = new WP_Query($args);

            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('mb-4'); ?>>
                        <header class="entry-header mb-3">
                            <h2 class="entry-title">
                                <a href="<?php the_permalink(); ?>" class="text-decoration-none"><?php the_title(); ?></a>
                            </h2>
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
                                <span class="comment-count"><?php echo get_comments_number(); ?></span>
                            </a>
                            <button class="btn btn-link share-button" data-post-id="<?php the_ID(); ?>">
                                <span class="share-icon">📤</span> Gửi
                            </button>
                        </div>
                    </article>
                <?php endwhile; ?>
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
                <?php wp_reset_postdata();
            else : ?>
                <p class="text-center"><?php _e('No content found', 'phuctheme'); ?></p>
            <?php endif; ?>
        </div>
        <div class="col-md-4">
            <?php get_sidebar(); ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>