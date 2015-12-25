;
var default_info_ops = {
    init: function () {
        this.eventBind();
        this.adaptVideo();
        this.syntaxHighlighter();
    },
    eventBind: function () {
        $("article .post-content img").each(function(){
            $(this).attr("title","点击查看大图");
            $(this).attr("alt","点击查看大图");
            var image_url = $(this).attr("src");
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
    adaptVideo: function () {
        var width = $(window).width();
        width = (width > 1000) ? 1000 : width;
        height = Math.ceil(width * 0.4);
        $("iframe").each(function () {
            $(this).attr("height", height);
        });
    },
    syntaxHighlighter:function(){
        $("pre").each(function(){
            var tmp_class = $(this).attr("class");
            if( tmp_class!= undefined && tmp_class.indexOf("brush:") > -1 ){
                $(this).attr("class",tmp_class.replace("toolbar:false","toolbar:true"));
            }
        });



        SyntaxHighlighter.autoloader.apply(null, this.getBrushFullPath(
            'applescript			@shBrushAppleScript.js',
            'actionscript3 as3		@shBrushAS3.js',
            'bash shell				@shBrushBash.js',
            'coldfusion cf			@shBrushColdFusion.js',
            'cpp c					@shBrushCpp.js',
            'c# c-sharp csharp		@shBrushCSharp.js',
            'css					@shBrushCss.js',
            'delphi pascal			@shBrushDelphi.js',
            'diff patch pas			@shBrushDiff.js',
            'erl erlang				@shBrushErlang.js',
            'groovy					@shBrushGroovy.js',
            'java					@shBrushJava.js',
            'jfx javafx				@shBrushJavaFX.js',
            'js jscript javascript	@shBrushJScript.js',
            'perl pl				@shBrushPerl.js',
            'php					@shBrushPhp.js',
            'text plain				@shBrushPlain.js',
            'py python				@shBrushPython.js',
            'ruby rails ror rb		@shBrushRuby.js',
            'sass scss				@shBrushSass.js',
            'scala					@shBrushScala.js',
            'sql					@shBrushSql.js',
            'vb vbnet				@shBrushVb.js',
            'xml xhtml xslt html	@shBrushXml.js'
        ));

        SyntaxHighlighter.defaults['smart-tabs'] = true;
        SyntaxHighlighter.defaults['tab-size'] = 4;
        SyntaxHighlighter.config.bloggerMode = true;
        SyntaxHighlighter.all()
    },
    getBrushFullPath:function(path){
        var static_path = $("#domain_static").val();
        var args = arguments,result = [];

        for(var i = 0; i < args.length; i++){
            result.push(args[i].replace('@', static_path + "syntaxhighlighter/scripts/"));
        }

        console.log(result);
        return result
    }
};

$(document).ready(function () {
    default_info_ops.init();
});
