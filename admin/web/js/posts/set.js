;
var post_set_ops = {
    init:function(){
        this.ue = null;
        this.initPlugins();
        this.eventBind();
    },
    eventBind:function(){
        var that = this;
        that.ue = UE.getEditor('editor',{
            toolbars: [
                ['fullscreen','source','preview', 'searchreplace', '|', 'undo', 'redo', '|',
                'bold', 'italic', 'underline', 'strikethrough', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall',  '|',
                'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
                'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
                'directionalityltr', 'directionalityrtl', 'indent', '|',
                'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
                'link', 'unlink', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'insertframe', 'insertcode', 'pagebreak', 'template', 'background', '|',
                'horizontal', 'date', 'time', 'spechars', 'snapscreen', 'wordimage'],
                ['inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols']
            ],
            enableAutoSave:true,
            saveInterval:60000,
            elementPathEnabled:false,
            serverUrl:'/upload/ueditor'
        });

        that.ue.addListener('beforeInsertImage', function (t,arg){
            //alert('这是图片地址：'+arg[0].src);
        });

        $("#post_add_edit .save").click(function(){
            if( $(this).hasClass("disabled") ){
                alert("请不要重复提交");
                return false;
            }

            if(!that.inputCheck()){
                return false;
            }
            that.dataSubmit();
            return false;
        });
        $(".get_tags").click(function(){
            var content  = $.trim( that.ue.getContent() );
            $.ajax({
                url:'/posts/get_tags',
                data:{content:content},
                type:'POST',
                dataType:'json',
                success:function(res){
                    if(res.code == 200){
                        for( var idx in res.data){
                            $("#post_add_edit input[name=tags]").addTag(res.data[idx]);
                        }
                    }

                }
            });
        });
    },
    inputCheck:function(){
        var title = $.trim( $("#post_add_edit input[name=title]").val() );
        var content  = $.trim( this.ue.getContent() );
        var tags = $.trim( $("#post_add_edit input[name=tags]").val() );
        var type = $.trim($("#type").val());
        var status = $.trim($("#status").val());
        var original = $.trim($("#original").val());

        if(title.length <= 0){
            alert("请输入博文标题!!");
            $("#post_add_edit input[name=title]").focus();
            return false;
        }

        if(content.length <= 10){
            alert("请输入更多点博文内容!!");
            $("#post_add_edit .summernote").focus();
            return false;
        }

        if(tags.length <= 0){
            alert("请输入博文tags!!");
            $("#post_add_edit input[name=tags]").focus();
            return false;
        }

        if( type == undefined || parseInt(type) <= 0){
            alert("请选择类型!!");
            return false;
        }

        return true;
    },
    dataSubmit:function(){
        var _this = $("#post_add_edit .save");
        $(_this).addClass("disabled");

        var post_id = $.trim($("#post_add_edit input[name=post_id]").val() );
        var title = $.trim( $("#post_add_edit input[name=title]").val() );
        var content  = $.trim( this.ue.getContent() );
        var tags = $.trim( $("#post_add_edit input[name=tags]").val() );
        var type = $.trim($("#type").val());
        var status = $.trim($("#status").val());
        var original = $.trim($("#original").val());
        data = {
            id:post_id,
            title:title,
            content:content,
            tags:tags,
            type:type,
            status:status,
            original:original
        };
        $.ajax({
            url:'/posts/set',
            data:data,
            type:'POST',
            dataType:'json',
            success:function(res){
                alert(res.msg);
                $(_this).removeClass("disabled");
                if(res.code == 200){
                    window.location.href = "/posts/set?id="+res.data.post_id;
                }
            }
        });
    },
    initPlugins:function(){
        $("#post_add_edit input[name=tags]").tagsInput({
            width:'auto',
            height:30,
            onAddTag:function(tag){
            },
            onRemoveTag:function(tag){
            }
        });
    }
};

$(document).ready(function(){
    post_set_ops.init();
});