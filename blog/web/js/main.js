var themeApp = {
    featuredMedia: function () {
        $(".post").each(function () {
            var thiseliment = $(this);
            var media_wrapper = $(this).find('featured');
            var media_content_image = media_wrapper.find($('img'));
            var media_content_embeded = media_wrapper.find('iframe');
            if (media_content_image.length > 0) {
                $(media_content_image).insertAfter(thiseliment.find('.post-head')).wrap("<div class='featured-media'></div>");
                thiseliment.addClass('post-type-image');
                media_wrapper.remove();
            }
            else if (media_content_embeded.length > 0) {
                $(media_content_embeded).insertAfter(thiseliment.find('.post-head')).wrap("<div class='featured-media'></div>");
                thiseliment.addClass('post-type-embeded');
            }
        });
    },
    responsiveIframe: function () {
        $('.post').fitVids();
    },
    sidebarConfig: function () {
        if (sidebar_left == true) {
            $('.main-content').addClass('col-md-push-4');
            $('.sidebar').addClass('col-md-pull-8');
        }
    },
    recentPost: function () {
    },
    highlighter: function () {
        $('pre code').each(function (i, block) {
            hljs.highlightBlock(block);
        });
    },
    backToTop: function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
        $('#back-to-top').on('click', function (e) {
            e.preventDefault();
            $('html, body').animate({scrollTop: 0}, 1000);
            return false;
        });
    },
    init: function () {
        themeApp.featuredMedia();
        themeApp.responsiveIframe();
        themeApp.sidebarConfig();
        themeApp.recentPost();
        themeApp.highlighter();
        themeApp.backToTop();
    }
}

/*===========================
 2. Initialization
 ==========================*/
$(document).ready(function () {
    themeApp.init();
});