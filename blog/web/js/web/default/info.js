;
var default_info_ops = {
    init: function () {
        this.eventBind();
        this.adaptVideo();
    },
    eventBind: function () {
        $("article img").each(function(){
            $(this).attr("title","点击查看大图");
            $(this).attr("alt","点击查看大图");
            var image_url = $(this).attr("src");
            var target = $('<a class="zoom" href="'+image_url+'" data-lightbox="roadtrip"></a>');
            $( this).clone(true).appendTo(target);
            target.insertBefore(  $(this) );
            $(this).hide();
        });
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true
        })
    },
    adaptVideo: function () {
        var width = $(window).width();
        width = (width > 1000) ? 1000 : width;
        height = Math.ceil(width * 0.4);
        $("iframe").each(function () {
            $(this).attr("height", height);
        });
    }
};

$(document).ready(function () {
    default_info_ops.init();
});
