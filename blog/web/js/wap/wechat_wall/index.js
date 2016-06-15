;

var wechat_wall_index_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){

    },
    getLatestMesage:function(){
        if( $(".am-comments-list .am-comment").size() < 1 ){
            return;
        }
        var max_id = $( $(".am-comments-list .am-comment").get(0) ).attr("data_id");
        $.ajax({
            url:common_ops.getUrlPrefix() + "/wechat_wall/getLatestMessage",
            type:'post',
            data:{'max_id':max_id},
            dataType:'json',
            success:function( res ){
                if( res.code == 200 ){

                }
            }
        });
    }
};

$(document).ready( function(){
    wechat_wall_index_ops.init();
} );