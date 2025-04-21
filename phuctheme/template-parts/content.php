<?php
// File: template-parts/content.php
// This file defines reusable content templates for displaying posts or other content types.
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('card h-100'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <a href="<?php the_permalink(); ?>">
            <img src="<?php the_post_thumbnail_url('medium'); ?>" class="card-img-top" alt="<?php the_title(); ?>">
        </a>
    <?php endif; ?>

    <div class="card-body">
        <header class="entry-header">
            <h2 class="entry-title card-title">
                <a href="<?php the_permalink(); ?>" class="text-decoration-none"><?php the_title(); ?></a>
            </h2>
            <div class="entry-meta text-muted mb-2">
                <span><?php _e('Published on', 'phuctheme'); ?> <?php echo get_the_date(); ?></span>
            </div>
        </header>

        <div class="entry-content">
            <?php the_excerpt(); ?>
        </div>

        <a href="<?php the_permalink(); ?>" class="btn btn-primary"><?php _e('Read More', 'phuctheme'); ?></a>
    </div>
</article>