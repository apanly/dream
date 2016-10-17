;
var log_uuid_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $('#search_from input.form-control').datepicker({
            language: 'zh-CN',
            autoclose:true
        });
    }
};

$(document).ready( function(){
    log_uuid_ops.init();
});