;
var default_info_ops = {
    init: function () {
        this.eventBind();
        this.adaptVideo();
    },
    eventBind: function () {

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
