;
var file_index_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
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
    file_index_ops.init();
});