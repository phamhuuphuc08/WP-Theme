<?php
// Lấy thông tin taxonomy hiện tại
$term = get_queried_object();

get_header(); ?>

<div class="series-header">
    <!-- Tên Series và mô tả -->
    <h1><?php echo esc_html( $term->name ); ?></h1> <!-- Tên Series -->
    <p><?php echo esc_html( $term->description ); ?></p> <!-- Mô tả Series -->

    <!-- Hiển thị các trường tùy chỉnh -->
    <div class="series-details">
        <p><strong>Tác giả:</strong> <?php echo esc_html(get_field('tac_gia', $term)); ?></p>
        <p><strong>Ngày cập nhật:</strong> <?php echo esc_html(get_field('ngay_cap_nhat', $term)); ?></p>
        <p><strong>Tình trạng:</strong>
    <?php 
        $tinh_trang = get_field('tinh_trang', $term); 
        echo esc_html($tinh_trang); // Kiểm tra nếu trường này có giá trị
        ?>
    </p>

        <p><strong>Thể loại:</strong>
            <?php 
            $the_loai = get_field('the_loai_series', $term); 
            if (is_array($the_loai)) {
                echo implode(', ', $the_loai); // Nếu thể loại là mảng, nối các giá trị với dấu phẩy
            } else {
                echo esc_html($the_loai); // Nếu chỉ là một giá trị, in trực tiếp
            }
            ?>
        </p>

        <?php 
        // Hiển thị ảnh bìa nếu có
        $image = get_field('anh_bia', $term);
        if ($image) {
            echo '<img src="' . esc_url($image) . '" alt="' . esc_attr($term->name) . '" class="series-image">';
        }
        ?>
    </div>
</div>

<div class="comics-list">
    <h2>Danh sách truyện trong Series</h2>

    <?php
    // Truy vấn các bài viết thuộc Series này
    $args = array(
        'post_type' => 'mangapress_comic',
        'tax_query' => array(
            array(
                'taxonomy' => 'mangapress_series',
                'terms'    => $term->term_id,
            ),
        ),
    );

    $query = new WP_Query( $args );

    if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();
            ?>
            <div class="comic-item">
                <a href="<?php the_permalink(); ?>">
                    <div class="comic-thumbnail">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    <h3><?php the_title(); ?></h3>
                </a>
            </div>
            <?php
        endwhile;
    else :
        echo '<p>Không có truyện trong Series này.</p>';
    endif;

    wp_reset_postdata();
    ?>
</div>

<?php get_footer(); ?>
