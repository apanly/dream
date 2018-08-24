var app = getApp();
var WxParse = require('../../plugins/wxParse/wxParse.js');
Page({
    data: {
        info:null
    },
    onLoad: function (options) {
        var that = this;
        that.setData({
            id: options.id
        });
    },
    onShow: function ( options ) {

        this.getInfo();
    },
    //返回上一页
    navigateBack: function(e) {
        wx.navigateBack();
    },
    //打赏
    reward: function(e) {
        app.alert({ 'content':'您的分享与关注是对我最大的打赏~~' })
    },
    goToInfo:function( e ){
        wx.navigateTo({
            url: "/pages/info/index?id=" + e.currentTarget.dataset.id
        });
    },
    onShareAppMessage: function () {
        var that = this;
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
    wxParseTagATap:function( e ){
        wx.navigateTo({
            url: "/pages/webview/index?href=" + e.currentTarget.dataset.src
        });
    },
    getInfo:function(){
        var that = this;
        wx.request({
            url: app.buildUrl("/post/info"),
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
                    share_info: resp.data.share_info,
                    recommend_blogs:resp.data.recommend_blogs
                });

                WxParse.wxParse('article', 'html', that.data.info.content, that, 5);
            }
        });
    }
});