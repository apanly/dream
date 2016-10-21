;
var chart_ops = {
    drawLine:function( data ){
        $('#'+data.target).highcharts({
            chart:{
                height:270,
                type:'spline'
            },
            title: {
                text: data.title,
                align:"left"
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                labels: {
                    formatter: function() {
                        return data.categories[this.value];
                    }
                },
                tickInterval:1
            },
            yAxis: {
                title: {
                    text: ''
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            plotOptions: {
                spline: {
                    marker: {
                        enabled: true
                    }
                }
            },
            tooltip: {
                formatter:function () {
                    var s = '<b>' +data.categories[this.x] + '</b>';
                    var weekArray = ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"];
                    s += '<br/>' + weekArray[ new Date( data.categories[this.x] ).getDay() ];
                    $.each(this.points, function () {
                        s += '<br/>' + this.series.name + ': ' + this.y + '次';
                    });

                    return s;
                },
                shared: true
            },
            legend: {
                enabled:true,
                layout:"vertical",
                align: 'right',
                verticalAlign: 'top',
                floating: true
            },
            credits: {
                enabled:false
            },
            series: data.series
        });
    },
    drawPie:function( data ){
        $('#'+data.target).highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
                height:270
            },
            title: {
                text: data.title,
                align:"left"
            },
            credits: {
                enabled:false
            },
            tooltip: {
                pointFormat: '<b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: <br/>{point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: data.series
        });
    }
};
