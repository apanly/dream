;
var library_info_ops = {
    init: function () {
        this.adaptImage();
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
        $(".am-figure img").each(function(){
            if(  $(this).attr("src") ){
                return true;
            }
            var url = $(this).attr("data-src")+"?format=/w/"+picwidth;
            if( $(this).attr("data") == 1 ){
                url = $(this).attr("data-src")+"?imageView/2/w/"+picwidth;
            }
            $(this).attr("src",url);
        });
    },
    calPicWidth:function(width){
        var tmp_int = Math.ceil(width/50);
        return tmp_int*50;
    }
};

$(document).ready(function () {
    library_info_ops.init();
});