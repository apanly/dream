;
var music_index_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $(".btn-search").click(function(){
            var kw = $("#search input[name=kw]").val();
            if( kw.length < 1 ){
                alert("请输入输入歌名或歌手~");
                return;
            }
            $("#search").submit();
        });
    }
};

$(document).ready(function(){
    music_index_ops.init();
});