;
var docs_ops = {
    init:function(){
        this.eventBind();
        this.sidebar();
    },
    eventBind:function(){

    },
    sidebar:function(){
        $(".sidebar-nav").css("height", $(".page").height() );
    }
};

$(document).ready( function(){
    docs_ops.init();
});