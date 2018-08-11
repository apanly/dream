// pages/info/index.js
var app = getApp();
var WxParse = require('../../wxParse/wxParse.js');
var utils = require('../../utils/util.js');

Page({
    /**
     * 页面的初始数据
     */
    data: {

    },
    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) {
        var that = this;
        that.setData({
            id: options.id
        });
    },
    onShow: function(){
        this.getInfo();
    },
    //返回上一页
    navigateBack: function(e) {
        wx.navigateBack();
    },
    //打赏
    reward: function() {
        app.alert( { "content":"您的分享与关注是对我最大的打赏~~" } );
    },
    /**
     * 用户点击右上角分享
     */
    onShareAppMessage: function () {
        return {
            title: that.data.share_info.title,
            path: '/page/info/index?id=' + that.data.id,
            success:function( res ){
                //转发成功
            },
            fail:function( res ){
                //转发失败
            }
        };
    },
    getInfo:function(){
        var that = this;
        wx.request({
            url: app.buildUrl("/default/info"),
            header: app.getRequestHeader(),
            method:'POST',
            data: {
                id:that.data.id
            },
            success: function (res) {
                var resp = res.data;
                if (resp.code != 200) {
                    app.alert({"content": resp.msg});
                    return;
                }

                that.setData({
                    info: resp.data.info,
                    share_info: resp.data.share_info
                });

                WxParse.wxParse('article', 'html', that.data.info.content, that, 5);
            }
        });
    }
});