;
var queue_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        prettyPrint();
    }
};
$(document).ready( function(){
    queue_ops.init();
});