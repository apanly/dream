;
var log_source_ops = {
    init:function(){
        this.eventBind();
        this.datetimepickerComponent();
    },
    eventBind:function(){

    },
    datetimepickerComponent:function(){
        $.datetimepicker.setLocale('zh');
        params = {
            scrollInput:false,
            scrollMonth:false,
            scrollTime:false,
            timepicker:true,
            dayOfWeekStart : 1,
            lang:'zh',
            todayButton:true,//回到今天
            defaultSelect:true,
            step:5,
            defaultDate:new Date().Format('yyyy-MM-dd'),
            format:'Y-m-d H:i',//格式化显示
            onChangeDateTime:function(dp,$input){
                //alert($input.val())
            }
        };
        $('#search_conditions input[name=date_from]').datetimepicker( params );
        $('#search_conditions input[name=date_to]').datetimepicker( params );
    }
};

$(document).ready( function(){
    log_source_ops.init();
});