;
var side_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
//        $('.sidebar #tag-cloud').tagcloud({
//            centrex:250,
//            centrey:250,
//            init_motion_x:10,
//            init_motion_y:10
//        });
    }
};
$(document).ready(function(){
    side_ops.init();
});
