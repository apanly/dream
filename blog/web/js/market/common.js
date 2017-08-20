;
var common_ops = {
    init:function(){
        this.setMenuIconHighLight();
    },
    eventBind:function(){

    },
    setMenuIconHighLight:function(){
        if( $("#navbarCollapse li").size() < 1 ){
            return;
        }
        var pathname = window.location.pathname;
        var nav_name = "home";


        if(  pathname.indexOf("/default/mina") > -1  ){
            nav_name = "mina";
        }

        $("#navbarCollapse li."+nav_name).addClass("active");
    }
};

$(document).ready(function () {
    common_ops.init();
});