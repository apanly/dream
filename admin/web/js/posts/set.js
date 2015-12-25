;
var post_set_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        var ue = UE.getEditor('editor');
        //UE.getEditor('editor').getContent();
    }
};

$(document).ready(function(){
    post_set_ops.init();
});