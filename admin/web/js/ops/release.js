;
var release_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $("#pop_layer_wrap").off("click",".release_wrap .save").on("click",".release_wrap .save",function(){
            var repo_target = $(".release_wrap select[name=repo]");
            var repo = repo_target.val();
            var note_target = $(".release_wrap textarea[name=note]");
            var note = note_target.val();

            if( repo == 0  ){
                repo_target.tip("请选择仓库~~");
                return false;
            }

            if( note == undefined || note.length < 5){
                note_target.tip("请输入不少于5个字符的描述~~");
                return false;
            }
            $.ajax({
                url : common_ops.buildAdminUrl("/ops/release"),
                type: 'POST',
                data:{'repo':repo,'note':note},
                dataType:'json',
                success:function(res){
                    callback = {};
                    if( res.code == 200 ){
                        callback = {
                            'ok':function(){
                                window.location.href = res.data.url;
                            }
                        };
                    }
                    $.alert( res.msg,callback );
                }
            });
        });
    }
};

$(document).ready( function(){
    release_ops.init();
});
