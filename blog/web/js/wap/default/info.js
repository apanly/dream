;
var default_info_ops = {
    init: function () {
        this.eventBind();
        this.adaptVideo();
        this.adaptImage();
        this.ifram_bug();//手机端专门修复的
    },
    eventBind: function () {
        prettyPrint();
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
            $(this).attr("width", "100%");
            if( $(this).attr("src").indexOf("v.qq.com/iframe") > -1 ){
                $(this).attr("height", height);
            }
            if( $(this).hasClass("iframe_bug") ){
                $(this).hide();
            }
        });
    },
    adaptImage:function(){
        var windowWidth = $(window).width();
        var dpi = window.devicePixelRatio;
        var width = windowWidth;
        if(dpi){
            width = windowWidth * dpi;
        }
        var picwidth = this.calPicWidth(width);
        if( picwidth > 1024 ){
            picwidth = 1024;
        }

        $("article .am-article-bd img").each(function(){
            $(this).attr("title","点击查看大图");
            $(this).attr("alt","点击查看大图");
            var image_url = $(this).attr("src");
            image_url = image_url.replace(/\/w\/\d+/,"/w/" + picwidth);
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
    calPicWidth:function(width){
        var tmp_int = Math.ceil(width/50);
        return tmp_int*50;
    },
    ifram_bug:function(){
        var width = $(document).width() - 30;
        $("iframe.iframe_bug").each(function(){
            var url = common_ops.getHostUrl("/public/iframe") + "?width=" +width+ "&url=" + encodeURIComponent( $(this).attr("src") );
            $(this).attr("src",url);
            $(this).show();
        });
    }
};

$(document).ready(function () {
    default_info_ops.init();
});