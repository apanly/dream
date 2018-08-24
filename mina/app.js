//app.js
App({
    onLaunch: function () {
    },
    globalData: {
        version: "1.0",
        app_name: "编程浪子走四方+",
        domain:"http://api.dr.test/mina"
        //domain:"https://api.54php.cn/mina"
    },
    confirm:function( params ){
        var that = this;
        var title = params.hasOwnProperty('title')?params['title']:'编程浪子提示您';
        var content = params.hasOwnProperty('content')?params['content']:'';
        wx.showModal({
            title: title,
            content: content,
            success: function(res) {
                if ( res.confirm ) {//点击确定
                    if( params.hasOwnProperty('cb_confirm') && typeof( params.cb_confirm ) == "function" ){
                        params.cb_confirm();
                    }
                }else{//点击否
                    if( params.hasOwnProperty('cb_cancel') && typeof( params.cb_cancel ) == "function" ){
                        params.cb_cancel();
                    }
                }
            }
        })
    },
    alert:function( params ){
        var title = params.hasOwnProperty('title')?params['title']:'编程浪子提示您';
        var content = params.hasOwnProperty('content')?params['content']:'';
        wx.showModal({
            title: title,
            content: content,
            showCancel:false,
            success: function(res) {
                if (res.confirm) {//用户点击确定
                    if( params.hasOwnProperty('cb_confirm') && typeof( params.cb_confirm ) == "function" ){
                        params.cb_confirm();
                    }
                }else{
                    if( params.hasOwnProperty('cb_cancel') && typeof( params.cb_cancel ) == "function" ){
                        params.cb_cancel();
                    }
                }
            }
        })
    },
    console:function( msg ){
        console.log( msg);
    },
    getRequestHeader:function(){
        return {
            'content-type': 'application/x-www-form-urlencoded',
            'Authorization': this.getCache( "token" )
        }
    },
    buildUrl:function( path,params ){
        var url = this.globalData.domain + path;
        var _paramUrl = "";
        if(  params ){
            _paramUrl = Object.keys( params ).map( function( k ){
                return [ encodeURIComponent( k ),encodeURIComponent( params[ k ] ) ].join("=");
            }).join("&");
            _paramUrl = "?" + _paramUrl;
        }
        return url + _paramUrl;
    },
    getCache:function( key ){
        var value = undefined;
        try {
            value = wx.getStorageSync( key );
        } catch (e) {
        }
        return value;
    },
    setCache:function(key,value){
        wx.setStorage({
            key:key,
            data:value
        });
    },
    calPicWidth:function(){
        var picWidth = 500;
        try{
            var sys_info = wx.getSystemInfoSync();
            picWidth = sys_info['pixelRatio'] * sys_info['windowWidth'];
        }catch (e) {

        }
        var tmp_int = Math.ceil( picWidth / 50 );
        return tmp_int * 50;
    }
});