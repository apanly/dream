;
var docs_ops = {
    init:function(){
        this.eventBind();
        this.sidebar();
    },
    eventBind:function(){
        $(".sub_menu_" + $(".hidden_wrap input[name=doc_id]").val() + " a").addClass("active");
    },
    sidebar:function(){
        $(".sidebar-nav").css("height", $(".page").height() );
    }
};

$(document).ready( function(){
    docs_ops.init();
});