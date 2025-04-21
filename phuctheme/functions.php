<?php
// filepath: c:\xampp\htdocs\doctruyen\wp-content\themes\phuctheme\functions.php

function phuctheme_setup() {
    // Add support for post thumbnails
    add_theme_support('post-thumbnails');

    // Add support for title tag
    add_theme_support('title-tag');

    // Register navigation menus
    register_nav_menus([
        'primary' => __('Primary Menu', 'phuctheme'),
        'footer_menu' => __('Footer Menu', 'phuctheme'),
        'series_menu' => __('Series Menu', 'phuctheme'), // Thêm menu mới cho Series
    ]);
}
add_action('after_setup_theme', 'phuctheme_setup');

function phuctheme_register_sidebars() {
    register_sidebar([
        'name' => __('Main Sidebar', 'phuctheme'),
        'id' => 'main-sidebar',
        'description' => __('Add widgets here to appear in your sidebar.', 'phuctheme'),
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ]);
}
add_action('widgets_init', 'phuctheme_register_sidebars');

function phuctheme_enqueue_scripts() {
    // Enqueue Google Fonts (Roboto)
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap', [], null);

    // Enqueue styles
    wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    wp_enqueue_style('phuctheme-style', get_stylesheet_uri());
    wp_enqueue_style('custom-style', get_template_directory_uri() . '/assets/css/custom.css');

    // Enqueue scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js', ['jquery'], null, true);
    wp_enqueue_script('phuctheme-script', get_template_directory_uri() . '/assets/js/script.js', ['jquery'], null, true);

    // Đăng ký script AJAX
    wp_localize_script('phuctheme-script', 'phucthemeAjax', [
        'ajax_url' => admin_url('admin-ajax.php'),
    ]);
}
add_action('wp_enqueue_scripts', 'phuctheme_enqueue_scripts');

// Bootstrap Navwalker for menu styling
class WP_Bootstrap_Navwalker extends Walker_Nav_Menu {
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<ul class="dropdown-menu">';
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $classes[] = 'nav-item';
        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'dropdown';
        }
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $output .= '<li class="' . esc_attr($class_names) . '">';

        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        $attributes .= in_array('menu-item-has-children', $classes) ? ' class="nav-link dropdown-toggle" data-toggle="dropdown"' : ' class="nav-link"';

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    public function end_lvl(&$output, $depth = 0, $args = null) {
        $output .= '</ul>';
    }
}

// Xử lý AJAX cho gợi ý tìm kiếm
function phuctheme_search_suggestions() {
    $search_term = isset($_POST['search_term']) ? sanitize_text_field($_POST['search_term']) : '';

    if (empty($search_term)) {
        wp_send_json([]);
        wp_die();
    }

    $args = [
        'post_type' => 'post',
        'posts_per_page' => 5,
        's' => $search_term,
        'post_status' => 'publish',
    ];

    $query = new WP_Query($args);
    $suggestions = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $suggestions[] = [
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
            ];
        }
    }

    wp_reset_postdata();
    wp_send_json($suggestions);
    wp_die();
}
add_action('wp_ajax_phuctheme_search_suggestions', 'phuctheme_search_suggestions');
add_action('wp_ajax_nopriv_phuctheme_search_suggestions', 'phuctheme_search_suggestions');

// Xử lý AJAX cho nút "Thích"
function phuctheme_like_post() {
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;

    if ($post_id <= 0) {
        wp_send_json_error(['message' => 'Invalid post ID']);
        wp_die();
    }

    $like_count = get_post_meta($post_id, 'like_count', true);
    $like_count = $like_count ? intval($like_count) : 0;
    $like_count++;

    update_post_meta($post_id, 'like_count', $like_count);

    wp_send_json_success(['like_count' => $like_count]);
    wp_die();
}
add_action('wp_ajax_phuctheme_like_post', 'phuctheme_like_post');
add_action('wp_ajax_nopriv_phuctheme_like_post', 'phuctheme_like_post');

// Đăng ký post type và taxonomy cho MangaPress
function register_mangapress_series() {
    $args = array(
        'labels' => array(
            'name' => 'Series',
            'singular_name' => 'Series',
            'add_new_item' => 'Add New Series',
            'edit_item' => 'Edit Series',
            'new_item' => 'New Series',
            'view_item' => 'View Series',
            'all_items' => 'All Series',
            'search_items' => 'Search Series',
            'not_found' => 'No series found',
            'not_found_in_trash' => 'No series found in trash',
            'parent_item_colon' => '',
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'show_in_rest' => true, // Hỗ trợ Gutenberg
        'rewrite' => array('slug' => 'series'),
        'hierarchical' => true, // Nếu bạn muốn có mối quan hệ cha-con
        'taxonomies' => array('category', 'post_tag'), // Nếu bạn dùng các taxonomy
    );
    register_post_type('mangapress_series', $args);
}
add_action('init', 'register_mangapress_series');

function register_mangapress_series_taxonomy() {
    register_taxonomy('mangapress_series', 'mangapress_comic', array(
        'label'        => 'MangaPress Series',
        'rewrite'      => array('slug' => 'series'),
        'hierarchical' => true,
        'public'       => true,
        'show_in_rest' => true,
    ));
}
add_action('init', 'register_mangapress_series_taxonomy');

function show_series_shortcode() {
    ob_start();
    $terms = get_terms(array(
        'taxonomy' => 'mangapress_series',
        'hide_empty' => false,
    ));

    if (!empty($terms) && !is_wp_error($terms)) {
        echo '<div class="series-grid" style="display: flex; flex-wrap: wrap; gap: 20px;">';
        foreach ($terms as $term) {
            $image_url = get_field('anh_bia', 'term_' . $term->term_id);

            echo '<div class="series-item" style="width: 200px; text-align: center;">';
            echo '<a href="' . esc_url(get_term_link($term)) . '">';
            if ($image_url) {
                echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($term->name) . '" style="width:100%; height:auto;">';
            } else {
                echo '<div style="width:100%; height:150px; background:#eee;"></div>';
            }
            echo '<h3>' . esc_html($term->name) . '</h3>';
            echo '</a>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<p>Không có truyện nào.</p>';
    }

    return ob_get_clean();
}
add_shortcode('show_series', 'show_series_shortcode');