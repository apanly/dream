var app = getApp();
Page({
    data: {},
    onLoad: function (options) {
        var that = this;
        that.setData({
            href: options.href
        });
    },
    onShow: function () {

    },
    //返回上一页
    navigateBack: function(e) {
        wx.navigateBack();
    }
});