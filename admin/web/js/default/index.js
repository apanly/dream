;
var default_index_ops = {
    init:function(){
        this.drawAccessLine();
        this.drawClentOsPie();
        this.drawSourcePie();
        this.drawBrowserPie();
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
    drawClentOsPie:function(){
        var data_client_os = $("#hidden_wrap input[name=data_client_os]").val();
        if( data_client_os.length < 1 ){
            return ;
        }
        data_client_os = eval('('+ data_client_os +')');
        data = {
            'title':'操作系统',
            'target':'client_os_chart',
            'series':data_client_os.series
        };
        chart_ops.drawPie( data );
    },
    drawSourcePie:function(){
        var data_source = $("#hidden_wrap input[name=data_source]").val();
        if( data_source.length < 1 ){
            return ;
        }
        data_source = eval('('+ data_source +')');
        data = {
            'title':'来路域名',
            'target':'source_chart',
            'series':data_source.series
        };
        chart_ops.drawPie( data );
    },
    drawBrowserPie:function(){
        var data_client_browser = $("#hidden_wrap input[name=data_client_browser]").val();
        if( data_client_browser.length < 1 ){
            return ;
        }
        data_client_browser = eval('('+ data_client_browser +')');
        data = {
            'title':'浏览器',
            'target':'client_browser_chart',
            'series':data_client_browser.series
        };
        chart_ops.drawPie( data );
    }
};

$(document).ready( function(){
    default_index_ops.init();
} );