<?php
/**
 * Template để hiển thị thông tin chi tiết của một Series
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package YourTheme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Thoát nếu truy cập trực tiếp
}

get_header(); ?>

<div class="single-series-content" style="padding: 2em;">

    <?php
    // Bắt đầu vòng lặp
    while ( have_posts() ) : the_post();
    ?>

        <div class="series-header">
            <h1><?php the_title(); ?></h1> <!-- Tiêu đề Series -->
            <p><?php the_content(); ?></p> <!-- Mô tả Series -->
        </div>

        <div class="series-meta">
            <?php
            // Lấy các trường tùy chỉnh
            $tac_gia = get_field('tac_gia'); // Trường Tác giả
            $ngay_cap_nhat = get_field('ngay_cap_nhat'); // Trường Ngày cập nhật
            $tinh_trang = get_field('tinh_trang'); // Trường Tình trạng
            $the_loai = get_field('the_loai_series'); // Trường Thể loại
            $anh_bia = get_field('anh_bia'); // Trường Ảnh bìa

            // Hiển thị các trường tùy chỉnh
            if ($tac_gia) {
                echo '<p><strong>✍️ Tác giả:</strong> ' . esc_html($tac_gia) . '</p>';
            }

            if ($ngay_cap_nhat) {
                echo '<p><strong>📅 Ngày cập nhật:</strong> ' . esc_html($ngay_cap_nhat) . '</p>';
            }

            if ($tinh_trang) {
                echo '<p><strong>🔖 Tình trạng:</strong> ' . esc_html($tinh_trang) . '</p>';
            }

            if ($the_loai) {
                echo '<p><strong>🏷️ Thể loại:</strong> ' . esc_html($the_loai) . '</p>';
            }

            if ($anh_bia) {
                echo '<div class="series-thumbnail" style="margin-top: 20px;">
                         <img src="' . esc_url($anh_bia) . '" alt="' . esc_attr(get_the_title()) . '" style="width:100%; max-width: 250px; border-radius: 8px;">
                      </div>';
            }
            ?>
        </div>

    <?php endwhile; ?>

</div><!-- .single-series-content -->

<?php get_footer(); ?>
