// File: wp-content/themes/phuctheme/assets/js/script.js
(function($) {
    $(document).ready(function() {
        console.log('PhucTheme JavaScript loaded!');

        // Xử lý gợi ý tìm kiếm
        $('#search-input').on('keyup', function() {
            var searchTerm = $(this).val().trim();
            var $suggestions = $('#search-suggestions');

            if (searchTerm.length < 1) {
                $suggestions.empty().hide();
                return;
            }

            $.ajax({
                url: phucthemeAjax.ajax_url,
                method: 'POST',
                data: {
                    action: 'phuctheme_search_suggestions',
                    search_term: searchTerm,
                },
                success: function(response) {
                    $suggestions.empty();
                    if (response.length > 0) {
                        response.forEach(function(item) {
                            $suggestions.append(
                                '<div class="suggestion-item"><a href="' + item.permalink + '">' + item.title + '</a></div>'
                            );
                        });
                        $suggestions.show();
                    } else {
                        $suggestions.hide();
                    }
                },
                error: function() {
                    $suggestions.empty().hide();
                }
            });
        });

        // Ẩn gợi ý khi click ra ngoài
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-form').length) {
                $('#search-suggestions').hide();
            }
        });

        // Xử lý nút "Thích"
        $('.like-button').on('click', function() {
            var $button = $(this);
            var postId = $button.data('post-id');

            $.ajax({
                url: phucthemeAjax.ajax_url,
                method: 'POST',
                data: {
                    action: 'phuctheme_like_post',
                    post_id: postId,
                },
                success: function(response) {
                    if (response.success) {
                        $button.find('.like-count').text(response.data.like_count);
                    }
                },
                error: function() {
                    console.log('Error liking post');
                }
            });
        });

        // Xử lý nút "Gửi" (Chia sẻ)
        $('.share-button').on('click', function() {
            var postId = $(this).data('post-id');
            var postUrl = window.location.origin + '/?p=' + postId;
            var postTitle = $(this).closest('article').find('.entry-title a').text();

            if (navigator.share) {
                navigator.share({
                    title: postTitle,
                    url: postUrl,
                }).catch(function(error) {
                    console.log('Error sharing:', error);
                });
            } else {
                // Fallback nếu trình duyệt không hỗ trợ Web Share API
                alert('Chia sẻ bài viết: ' + postTitle + '\n' + postUrl);
            }
        });

        // Các code khác (scroll navbar, smooth scroll, v.v.) vẫn giữ nguyên
        $(window).on('scroll', function() {
            if ($(window).scrollTop() > 50) {
                $('header').addClass('scrolled');
            } else {
                $('header').removeClass('scrolled');
            }
        });

        $('a[href*="#"]').not('[href="#"]').click(function(event) {
            if (
                location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') &&
                location.hostname == this.hostname
            ) {
                event.preventDefault();
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 60
                    }, 1000);
                    return false;
                }
            }
        });

        $('[data-toggle="tooltip"]').tooltip();

        $('.card').each(function() {
            var card = $(this);
            $(window).on('scroll', function() {
                var windowBottom = $(window).scrollTop() + $(window).height();
                var cardTop = card.offset().top;
                if (windowBottom > cardTop) {
                    card.addClass('fade-in');
                }
            });
        });

        $('.btn-primary').on('click', function(e) {
            console.log('Read More button clicked: ' + $(this).attr('href'));
        });
    });
})(jQuery);