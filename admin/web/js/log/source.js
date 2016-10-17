;
var log_source_ops = {
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
    log_source_ops.init();
});