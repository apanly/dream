;
var default_index_ops = {
    init:function(){
        this.drawAccessLine();
        this.drawBlogLine();
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
    }
};

$(document).ready( function(){
    default_index_ops.init();
} );