var app = getApp();
Page({
    data: {
        active:0,
        type:1
    },
    onLoad: function (options) {
        this.reset();
        this.search();
    },
    onShow: function () {

    },
    onReachBottom: function () {
        var that = this;
        setTimeout(function () {
            that.search();
        }, 300);
    },
    onPullDownRefresh:function(){
        //wx.showNavigationBarLoading();
        this.reset();
        this.search();
        //wx.hideNavigationBarLoading(); //完成停止加载
        wx.stopPullDownRefresh(); //停止下拉刷新
    },
    onShareAppMessage: function () {

    },
    tabChange: function ( e ) {
        this.setData({
            type: e.detail + 1,
            active:e.detail
        });
        this.reset();
        this.search();
    },
    goToInfo:function( e ){
        wx.navigateTo({
            url: "/pages/info/index?id=" + e.currentTarget.dataset.id
        });
    },
    reset:function(){
        this.setData({
            p: 1,
            list: [],
            loading: false,
            no_data: false
        });
    },
    search: function () {
        var that = this;
        if (that.data.loading) {
            return;
        }

        if (that.data.no_data) {
            return;
        }

        that.setData({
            loading: true
        });

        wx.request({
            url: app.buildUrl("/post/index"),
            header: app.getRequestHeader(),
            data: {
                p: that.data.p,
                type:that.data.type
            },
            success: function (res) {
                var resp = res.data;
                if (resp.code != 200) {
                    app.alert({"content": resp.msg});
                    return;
                }
                var list = resp.data.list;
                var data_list = [];
                if (list) {
                    var width = app.calPicWidth();
                    var height = parseInt(9 * width / 16);
                    for (var idx in list) {
                        var tmp_data = list[idx];
                        tmp_data['image_url'] += "?imageView2/0/w/" + width;
                        data_list.push(list[idx]);
                    }
                }
                that.setData({
                    list: that.data.list.concat(resp.data.list),
                    p: that.data.p + 1,
                    loading: false
                });

                if (resp.data.has_more == 0) {
                    that.setData({
                        no_data: true
                    });
                }
            }
        });
    }
});