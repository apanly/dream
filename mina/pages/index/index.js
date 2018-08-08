
var app = getApp();
Page({
    data: {
        loading:false,
        nodata:false,
        p:1,
        list:[]
    },
    onLoad: function () {
        var that = this;
    },
    onShow:function(){
        this.search();
    },
    onReachBottom: function () {
        var that = this;
        setTimeout(function () {
            that.search();
        }, 500);
    },
    search:function(){
        var that = this;
        if( that.data.loading ){
            return;
        }

        that.setData({
            loading:true
        });

        wx.request({
            url: app.buildUrl("/default/blog"),
            header: app.getRequestHeader(),
            data: {
                p: that.data.p
            },
            success: function (res) {
                var resp = res.data;
                if (resp.code != 200) {
                    app.alert({"content": resp.msg});
                    return;
                }

                that.setData({
                    list: that.data.list.concat( resp.data.list ),
                    p: that.data.p + 1,
                    loading:false
                });

                if( resp.data.has_more == 0 ){
                    that.setData({
                        nodata: true
                    });
                }

            }
        });
    },
    bindItemTap:function( e ){
        wx.navigateTo({
            url: "/pages/info/index?id=" + e.currentTarget.dataset.id
        });
    }
});
