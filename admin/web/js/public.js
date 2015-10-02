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

        if( pathname.indexOf("/richmedia") >= 0 ){
            $(".x-navigation .menu_richmedia").addClass("active");
            return;
        }

        if( pathname.indexOf("/library") >= 0 ){
            $(".x-navigation .menu_library").addClass("active");
            return;
        }

        if( pathname.indexOf("/douban") >= 0 ){
            $(".x-navigation .menu_doubanmz").addClass("active");
            return;
        }


        $(".x-navigation .menu_" + default_menu).addClass("active");
    }
};

$(document).ready(function(){
   public_ops.init();
});