var app = getApp();
Page({
    data: {
        info:null,
        text:"点我扫码"
    },
    onLoad: function (options) {

    },
    onShow: function () {

    },
    setText:function( txt ){
        this.setData({
            text:txt
        });
    },
    scanBar:function(){
        var that = this;
        that.setText("识别图片中...");
        wx.scanCode({
            success:function( res ){
                var scanType = res.scanType;
                var result = res.result;
                that.setText( "查询结果中..." );
                that.bookQuery( scanType,result );
            },
            fail:function( res ){
                that.setText( "点我扫码" );
                app.alert({ "content":"扫码失败，失败原因：" + res.errMsg });
            }
        });
    },
    bookQuery:function( scan_type,result ){
        var that = this;
        wx.request({
            url: app.buildUrl("/library/scan"),
            header: app.getRequestHeader(),
            method:'POST',
            data: {
                type:scan_type,
                isbn:result
            },
            success: function (res) {
                var resp = res.data;
                that.setText( "点我扫码" );
                if (resp.code != 200) {
                    app.alert({"content": resp.msg});
                    return;
                }

                that.setData({
                    info:resp.data
                });
            }
        });
    }
});