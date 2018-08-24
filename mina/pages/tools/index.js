var app = getApp();
Page({
    data: {
        list:[]
    },
    onLoad: function (options) {

    },
    onShow: function () {
        var that = this;
        wx.request({
            url: app.buildUrl("/tools/index"),
            header: app.getRequestHeader(),
            success: function (res) {
                var resp = res.data;
                if (resp.code != 200) {
                    app.alert({"content": resp.msg});
                    return;
                }

                that.setData({
                    list: resp.data.tools
                });
            }
        });
    },
    openTool:function( e ){
        var data = e.currentTarget.dataset;
        var route = data.route;
        if( data.type == "http" ){
            route = "/pages/webview/index?href=" + route
        }

        wx.navigateTo({
            url: route
        });
    }
});