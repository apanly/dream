;
var default_info_ops = {
    init: function () {
        this.eventBind();
        this.adaptVideo();
        this.adaptImage();

    },
    eventBind: function () {
        prettyPrint();
    },
    adaptVideo: function () {
        var width = $(window).width();
        width = (width > 1000) ? 1000 : width;
        height = Math.ceil(width * 0.4);
        $(".post-content iframe").each(function () {
            $(this).attr("width", "100%");
            if( $(this).attr("src").indexOf("v.qq.com/iframe") > -1 ){
                $(this).attr("height", height);
            }
        });
    },
    adaptImage:function(){
        var that = this;
        var windowWidth = $(window).width();
        var dpi = window.devicePixelRatio;
        var width = windowWidth;
        if(dpi){
            width = windowWidth * dpi;
        }
        var picwidth = this.calPicWidth(width);
        if( picwidth > 1024 ){
            picwidth = 1024;
        }

        $("article .post-content img").each(function(){
            $(this).attr("title","点击查看大图");
            $(this).attr("alt","点击查看大图");
            var image_url = $(this).attr("src");
            var wrap_width = that.calPicWidth( $("article.post").width() );
            wrap_width = dpi?(wrap_width*dpi):wrap_width;
            $(this).attr("width",wrap_width  );
            $(this).attr("src",image_url.replace(/\/w\/\d+/,"/w/" + wrap_width ) );
            image_url = image_url.replace(/\/w\/\d+/,"/w/" + picwidth);
            var target = $('<a class="zoom" href="'+image_url+'" data-lightbox="roadtrip"></a>');
            $( this).clone(true).appendTo(target);
            target.insertBefore(  $(this) );
            $(this).hide();
        });
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true
        })
    },
    calPicWidth:function(width){
        var tmp_int = Math.ceil(width/50);
        return tmp_int*50;
    },
    getBrushFullPath:function(path){
        var static_path = $("#domain_static").val();
        var args = arguments,result = [];

        for(var i = 0; i < args.length; i++){
            result.push(args[i].replace('@', static_path + "syntaxhighlighter/scripts/"));
        }
        return result
    },
};

var contents_ops = {
    initHeading:function(){
        var h2 = [];
        var h3 = [];
        var h2index = 0;
        //获取DOM中h2,h3标签
        $.each($('h2,h3'),function(index,item){
            if(item.tagName.toLowerCase() == 'h2'){
                var h2item = {};
                h2item.name = $(item).text();
                h2item.id = 'menuIndex'+index;
                h2.push(h2item);
                h2index++;
            }else{
                var h3item = {};
                h3item.name = $(item).text();
                h3item.id = 'menuIndex'+index;
                if(h2index-1<0){
                    alert('2货别在使用h2标签之前使用h3标签');
                }
                if(!h3[h2index-1]){
                    h3[h2index-1] = [];
                }
                h3[h2index-1].push(h3item);
            }
            item.id = 'menuIndex' + index;
        });
        return {h2:h2,h3:h3}
    },
    genTmpl:function(){
        //开始拼接
        var tmpl = '<ul>';
        var heading = this.initHeading();
        var h2 = heading.h2;
        var h3 = heading.h3;
        for(var i=0;i<h2.length;i++){
            tmpl += '<li><a href="javascript:void(0);" data-id="'+h2[i].id+'">'+h2[i].name+'</a></li>';
            if(h3[i]){
                for(var j=0;j<h3[i].length;j++){
                    tmpl += '<li class="h3"><a href="javascript:void(0);" data-id="'+h3[i][j].id+'">'+h3[i][j].name+'</a></li>';
                }
            }
        }
        tmpl += '</ul>';
        return tmpl;
    },
    getIndex:function(){
        var tmpl = this.genTmpl();
        //创建div标签
        var indexCon = '<div id="menuIndex" class="sidenav"></div>';
        //加载到页面中
        $('#content').append(indexCon);
        $('#menuIndex').append($(tmpl)).delegate('a','click',function(e){
            var selector = $(this).attr('data-id') ? '#'+$(this).attr('data-id') : 'h1';
            var scrollNum = $(selector).offset().top;
            $('body, html').animate({ scrollTop: scrollNum - 15 }, 300, 'linear');
            $('#menuIndex ul li').removeClass("active");
            $(this).parent().addClass("active");
        });


    }
};

$(document).ready(function () {
    default_info_ops.init();
    //contents_ops.getIndex();
});
