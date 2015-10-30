;
var default_info_ops = {
    init: function () {
        this.adaptVideo();
    },
    adaptVideo: function () {
        var width = $(window).width();
        width = (width > 1000) ? 1000 : width;
        height = Math.ceil(width * 0.3);
        var dpi = window.devicePixelRatio;
        if (dpi) {
            height = height * dpi;
        }
        $("iframe").each(function () {
            $(this).attr("height", height);
        });
    }
};

$(document).ready(function () {
    default_info_ops.init();
});