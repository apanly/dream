;
var docs_ops = {
    init:function(){
        this.eventBind();
        this.sidebar();
        this.adaptImage();
    },
    eventBind:function(){
        $(".sub_menu_" + $(".hidden_wrap input[name=doc_id]").val() + " a").addClass("active");

        $(".markdown-body a").attr("target","_blank");//统一加链接
        prettyPrint();
    },
    sidebar:function(){
        $(".sidebar-nav").css("height", $(".page").height() );
    },
    adaptImage:function(){
        var dpi = window.devicePixelRatio;
        var original_wrap_width = $(".markdown-body").width();
        var wrap_width = this.calPicWidth( original_wrap_width );
        wrap_width = dpi?(wrap_width*dpi):wrap_width;

        $(".page .markdown-body img").each(function(){
            var image_url = $(this).attr("src");
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

$(document).ready( function(){
    docs_ops.init();
});