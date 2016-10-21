;
upload = {
    error:function( msg ){
        $.alert( msg );
    },
    success:function( msg ){
        $.alert( msg );
    }
};
var file_add_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $("#file_set .save").click(function(){
            $("#file_set").submit();
        });

        $("#file_set input[name=rich_media]").change(function(){
            $("#file_set .save").click();
        });
    }
};

$(document).ready(function(){
    file_add_ops.init();
});