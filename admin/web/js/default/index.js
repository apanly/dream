;
var default_index_ops = {
    init:function(){
        this.drawAccessLine();
        this.drawBlogLine();
        this.drawClentOsPie();
    },
    drawAccessLine:function(){
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
    },
    drawBlogLine:function(){
        var data_blog = $("#hidden_wrap input[name=data_blog]").val();
        if( data_blog.length < 1 ){
            return ;
        }

        data_blog = eval('('+ data_blog +')');
        data = {
            'title':'博文统计',
            'target':'blog_line',
            'categories':data_blog.categories,
            'series':data_blog.series
        };
        chart_ops.drawLine( data );
    },
    drawClentOsPie:function(){
        var data_client_os = $("#hidden_wrap input[name=data_client_os]").val();
        if( data_client_os.length < 1 ){
            return ;
        }
        data_client_os = eval('('+ data_client_os +')');
        console.log(  data_client_os.series );
        data = {
            'title':'操作系统',
            'target':'client_os_chart',
            'series':data_client_os.series
        };
        chart_ops.drawPie( data );
    }
};

$(document).ready( function(){
    default_index_ops.init();
} );