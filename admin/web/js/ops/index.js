;
var index_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $(".release").click( function(){
            common_ops.popLayer( "/ops/release",{ 'title':'发布代码' } );
        });
    }
};

$(document).ready( function(){
    index_ops.init();
});