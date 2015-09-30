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
    }
};

$(document).ready(function(){
    douban_mz_ops.init();
});