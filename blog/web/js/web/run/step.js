;
var run_step_ops = {
    init:function(){
        this.drawChart();
    },
    drawChart:function(){
        var chart_data =  eval('(' + $("#chart_data").val() + ')');
        var chart_type = $("#chart_type").val();

        console.log(chart_data);
        $('#container').highcharts({
            global:{
                useUTC: true
            },
            lang:{
                "noData": "No data to display"
            },
            chart: {
                type: 'spline'
            },
            title: {
                useHTML:true,
                text: chart_data.title,
                align: 'left',
                x:20
            },
            subtitle: {
                floating:true,
                useHTML:true,
                text: chart_data.sub_title,
                align: 'right',
                y:17
            },
            legend:{
                enabled:false
            },
            credits:{
                enabled:false // 禁用版权信息
            },
            xAxis: {
                categories:chart_data.x_cat,
                startOnTick: true,
                showFirstLabel: true,
                showLastLabel: true,
                endOnTick: true,
                tickmarkPlacement:"between",
//                tickInterval:1,
                labels: {
                    step: chart_data.step,
                    staggerLines: 1,
                    formatter: function() {
                        //%Y-%m-%d
                        var format = '%H:%M';
                        if( chart_type == "monthly" ){
                            format = '%m/%d';
                        }
                        return  Highcharts.dateFormat(format, this.value);
                    }
                }
            },
            yAxis: {
                title: {
                    text: '步数'
                },
                min: 0,
                minorGridLineWidth: true,
                gridLineWidth: true,
                alternateGridColor: true,
                plotLines: [{   //一条延伸到整个绘图区的线，标志着轴中一个特定值。
                    color: '#339933',
                    dashStyle: 'Solid', //Dash,Dot,Solid,默认Solid
                    width: 1.5,
                    value: chart_data.avg,  //y轴显示位置
                    zIndex: 5
                }]
            },
            tooltip: {
                formatter: function() {
                    var format = '%H:%M';
                    if( chart_type == "monthly" ){
                        format = '%m/%d';
                    }
                    return'<b>'+ Highcharts.dateFormat(format, this.x) +': '+ this.y+' 步</b><br>';
                }
            },
            plotOptions: {
                spline: {
                    lineWidth: 2,
                    states: {
                        hover: {
                            lineWidth: 2
                        }
                    },
                    marker: {
                        enabled: false
                    }
                }
            },
            series: [{
                name: 'health_kit',
                data: chart_data.data
            }]
        });
    }
};

$(document).ready(function(){
    run_step_ops.init();
});