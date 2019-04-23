;
var demo_lvb_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        var that = this;
        var player =  new TcPlayer('id_test_video', {
            "m3u8": "http://lvb.54php.cn/live/54php.m3u8",
            "flv": "http://lvb.54php.cn/live/54php.flv", //增加了一个flv的播放地址，用于PC平台的播放 请替换成实际可用的播放地址
            "autoplay" : true,      //iOS下safari浏览器，以及大部分移动端浏览器是不开放视频自动播放这个能力的
            "coverpic" : "http://www.test.com/myimage.jpg",
            "width" :  '480',//视频的显示宽度，请尽量使用视频分辨率宽度
            "height" : '320'//视频的显示高度，请尽量使用视频分辨率高度
        });
    }
};


$(document).ready( function(){
    demo_lvb_ops.init();
} );