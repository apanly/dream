;
var chart_ops = {
    drawLine:function( data ){
        $('#'+data.target).highcharts({
            chart:{
                height:270
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
    }
};
