;
var log_app_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $("#search_from select[name=type]").change( function( ){
            $("#search_from").submit();
        });
    }
};

$(document).ready( function(){
    log_app_ops.init();
} );