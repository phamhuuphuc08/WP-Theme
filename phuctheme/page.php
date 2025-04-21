<!-- page.php -->
<?php
/**
 * The template for displaying static pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#page-template
 *
 * @package phuctheme
 */

get_header(); ?>

<main class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <?php
            while (have_posts()) :
                the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header mb-4">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                        <div class="entry-meta text-muted">
                            <p><?php _e('Published on', 'phuctheme'); ?> <?php echo get_the_date(); ?></p>
                        </div>
                    </header>

                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile; // End of the loop. ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>