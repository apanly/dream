;

var wechat_wall_index_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        var interval_id = setInterval(wechat_wall_index_ops.getLatestMesage,10000);
    },
    getLatestMesage:function(){
        if( $(".am-comments-list .am-comment").size() < 1 ){
            return;
        }
        var max_id = $( $(".am-comments-list .am-comment").get(0) ).attr("data_id");
        $.ajax({
            url:common_ops.getUrlPrefix() + "/wechat_wall/get_latest_message",
            type:'post',
            data:{'max_id':max_id},
            dataType:'json',
            success:function( res ){
                if( res.code == 200 && res.data.hasOwnProperty("message") ){
                    var size = $(".am-comments-list .am-comment").size();
                    if( size >= 5 ){
                        $( $(".am-comments-list .am-comment").get( size - 1) ).remove();
                    }
                   $(".am-comments-list").prepend(res.data.message);
                }
            }
        });
    }
};

$(document).ready( function(){
    wechat_wall_index_ops.init();
} );