;
var public_ops = {
    init:function(){
        this.initTags();
        this.initBlogs();
        this.eventBind();
    },
    eventBind:function(){
        var that = this;
        $(".sidebar .do-search").click(function(){
            that.search();
        });

        $(".sidebar #kw").keydown(function(e){
            if(e.keyCode==13){
                that.search();
            }
        });
    },
    initTags:function(){
        var that = this;
        if( $(".tag-cloud").size() <= 0 ){
            return;
        }
        $.ajax({
            url:'/public/tags',
            dataType:'json',
            success:function(res){
                if(res.code == 200){
                    that.formatTags(res.data);
                }
            }
        });
    },
    formatTags:function(items){
        var html_tags = "";
        for(var idx in items){
            html_tags += '<a href="/search/do?kw='+items[idx]+'">'+items[idx]+'</a>';
        }
        $(".tag-cloud").each(function(){
            $(this).html(html_tags);
        });
    },
    initBlogs:function(){
        var that = this;
        $.ajax({
            url:'/public/blogs',
            dataType:'json',
            success:function(res){
                if(res.code == 200){
                    that.formatBlogs(res.data);
                }
            }
        });
    },
    formatBlogs:function(items){
        var items_hots = items.hots;
        var hots_html_blog = "";
        for(var idx in items_hots){
            hots_html_blog += '<div class="recent-single-post"><a href="'+items_hots[idx]['url']+'"  class="post-title">'+items_hots[idx]['title']+'</a></div>';
        }
        $(".hots-post").html(hots_html_blog);
        var items_news = items.news;
        var news_html_blog = "";
        for(var idx in items_news){
            news_html_blog += '<div class="recent-single-post"><a href="'+items_news[idx]['url']+'"  class="post-title">'+items_news[idx]['title']+'</a></div>';
        }
        $($(".recent-post").get(1)).html(news_html_blog);
    },
    search:function(){
        var kw = $.trim( $(".sidebar #kw").val() );
        if( kw.length < 1){
            $(".sidebar #kw").focus();
            alert("郭大帅哥提醒您\r\n请输入搜索关键字!!");
            return;
        }
        window.location.href = "/search/do?kw=" + kw;
    }
};
$(document).ready(function(){
    public_ops.init();
});