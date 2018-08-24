var app = getApp();
Page({
    data: {
        image_list:[
            "http://cdn.static.54php.cn/images/weixin/coderonin.jpg",
            "http://cdn.static.54php.cn/images/weixin/m_coreronin_my.png"
        ]
    },
    onLoad: function (options) {

    },
    previewImage: function (e) {
        var that = this;
        var current = e.target.dataset.src;
        app.console( current );
        wx.previewImage({
            current: current, // 当前显示图片的http链接
            urls:  that.data.image_list
        })
    }
});