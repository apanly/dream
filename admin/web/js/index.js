;
var default_index_ops = {
    init:function(){
        this.drawLine();
    },
    drawLine:function(){
        var data_access = $("#hidden_wrap input[name=data_access]").val();
        if( data_access.length < 1 ){
            return ;
        }

        data_access = eval('('+ data_access +')');
        data = {
            'title':'访问量',
            'target':'access_line',
            'categories':data_access.categories,
            'series':data_access.series
        };
        chart_ops.drawLine( data );
    }
};

$(document).ready( function(){
    default_index_ops.init();
} );