;
var docs_ops = {
    init:function(){
        this.eventBind();
        this.sidebar();
    },
    eventBind:function(){
        $(".sub_menu_" + $(".hidden_wrap input[name=doc_id]").val() + " a").addClass("active");

        $(".markdown-body a").attr("target","_blank");//统一加链接
    },
    sidebar:function(){
        $(".sidebar-nav").css("height", $(".page").height() );
    }
};

$(document).ready( function(){
    docs_ops.init();
});