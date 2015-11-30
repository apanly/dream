;
var my_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $(".am-tabs-nav a").each(function(idx){
            $(this).click(function(){
                var url = common_ops.getUrlPrefix() + "/my/about";
                switch(idx){
                    case 1:
                        url = common_ops.getUrlPrefix() + "/my/about#contact";
                        break;
                }
                window.location.href = url;
            });
        });

        var hash = window.location.hash;
        var hash_idx = 0;
        if( hash == "contact" ){
            hash_idx = 1;
        }
        $( $(".am-tabs-nav li").get(hash_idx) ).addClass("am-active");
    }
};

$(document).ready(function(){
    my_ops.init();
});