// pages/tools/book/scan.js
Page({
    data: {},
    onLoad: function (options) {

    },
    onShow: function () {

    },
    scanBar:function(){
        wx.scanCode({
            success:function( res ){

            }
        });
    }
});