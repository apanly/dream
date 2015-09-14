;
var public_ops = {
    init:function(){
        this.initHighlightMenu();
    },
    initHighlightMenu:function(){
        var pathname = window.location.pathname;
        var default_menu = "dashboard";
        if( pathname.indexOf("/posts") >= 0 ){
            $(".x-navigation .menu_posts").addClass("active");
            return;
        }

        if( pathname.indexOf("/library") >= 0 ){
            $(".x-navigation .menu_library").addClass("active");
            return;
        }


        $(".x-navigation .menu_" + default_menu).addClass("active");
    }
};

$(document).ready(function(){
   public_ops.init();
});