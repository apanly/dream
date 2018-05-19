;
var default_info_ops = {
    init: function () {
        this.eventBind();
        this.adaptImage();
    },
    eventBind: function () {
        $(".buy_soft").click( function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                $.alert("正在保存，请不要重复提交~~");
                return false;
            }


            $.ajax({
                url:common_ops.buildMarketUrl("/order/buy"),
                type:'POST',
                data:{
                    id:$("input[name=soft_id]").val()
                },
                dataType:'json',
                success:function( res ){

                }
            });
        } );
    },
    adaptImage:function(){

        var dpi = window.devicePixelRatio;
        var original_wrap_width = $(".article-main-content").width();
        var wrap_width = this.calPicWidth( original_wrap_width );
        wrap_width = dpi?(wrap_width*dpi):wrap_width;

        $(".article-main-content  img").each(function(){
            var image_url = $(this).attr("src");
            if( image_url.indexOf("/default/qrcode") > 0  ){
                return true;
            }

            $(this).attr("width",original_wrap_width  );
            $(this).attr("src",image_url.replace(/\/w\/\d+/,"/w/" + wrap_width ) );
            image_url = image_url.replace(/\/w\/\d+/,"/w/" + wrap_width);

            var img_title = $(this).attr("title");
            img_title = ( img_title != undefined && img_title.length > 1 )?img_title:'';

            var target = $('<a class="fancybox" rel="gallery1" href="'+image_url+'" title="'+img_title+'"></a>');

            $(this).attr("title","点击查看大图");
            $(this).attr("alt","点击查看大图");

            $( this).clone(true).appendTo(target);
            target.insertBefore(  $(this) );
            $(this).hide();
        });


        $(".fancybox").fancybox({
            openEffect	: 'none',
            closeEffect	: 'none',
            nextClick: true,
            helpers: {
                title : {
                    type : 'inside'
                }
            },
            afterLoad : function() {
                this.title = '图库 ' + (this.index + 1) + ' / ' + this.group.length + (this.title ? ' - ' + this.title : '');
            }
        });
    },
    calPicWidth:function(width){
        var tmp_int = Math.ceil(width/50);
        return tmp_int*50;
    }
};

$(document).ready(function () {
    default_info_ops.init();
});