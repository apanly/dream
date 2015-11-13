;
var richmedia_index_ops = {
    init: function () {
        this.p = 1;
        this.adaptImage();
        this.eventBind();

    },
    eventBind: function () {
        var that = this;
        $(window).scroll(function () {
            if (($(window).scrollTop() + $(window).height() > $(document).height() - 10) && stop) {
                stop = false;
                $('.loading').show();
                that.p += 1;
                var p = that.p;
                $.ajax({
                    url: common_ops.getUrlPrefix() + '/richmedia/search',
                    type: 'GET',
                    dataType: 'json',
                    data: {'p': p},
                    success: function (res) {
                        if (res.code == 200) {
                            var t = setTimeout(function () {
                                $('.loading').hide();
                                if (res.data.has_data) {
                                    $(".am-gallery").append(res.data.html);
                                    that.adaptImage();
                                    stop = true;
                                }
                                if (!res.data.has_next) {
                                    stop = false;
                                }
                            }, 2);
                        }
                    }
                });
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
        $(".am-gallery-item img").each(function(){
            if(  $(this).attr("src") ){
                return true;
            }
            var url = $(this).attr("data-src")+"??format=/w/"+picwidth;
            if( $(this).attr("data") == 1 ){
                url = $(this).attr("data-src")+"?imageView/2/w/"+picwidth;
            }
            $(this).attr("src",url);
            $(this).attr("data-rel",url);
        });
    },
    calPicWidth:function(width){
        var tmp_int = Math.ceil(width/50);
        return tmp_int*50;
    }
};

$(document).ready(function () {
    richmedia_index_ops.init();
});