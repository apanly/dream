;
var douban_mz_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $(".gallery-item-remove").each(function(){
            $(this).click(function(){
                if(!confirm("确定删除图片?")){
                    return;
                }
            });
        });

        $("a.image_gallary").fancybox({
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
    }
};

$(document).ready(function(){
    douban_mz_ops.init();
});