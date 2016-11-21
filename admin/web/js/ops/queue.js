;
var queue_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        //prettyPrint();
        if( parseInt( $(".hide_wrap input[name=status]").val() ) < 0 ){
            setTimeout('window.location.reload()',4000); //指定4秒刷新一次
        }
    }
};
$(document).ready( function(){
    queue_ops.init();
});