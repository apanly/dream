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
            zIndex:4,
            serverUrl:'/upload/ueditor'
        });

        that.ue.addListener('beforeInsertImage', function (t,arg){
            //alert('这是图片地址：'+arg[0].src);
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

        $("#post_add_edit .save").click(function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                $.alert("正在保存，请不要重复提交~~");
                return false;
            }

            var title_target = $("#post_add_edit input[name=title]");
            var title_val = $.trim( title_target.val() );
            var content  = $.trim( that.ue.getContent() );
            var tags_val = $.trim( $("#post_add_edit input[name=tags]").val() );
            var type_target = $("#type");
            var type_val = $.trim( type_target.val() );
            var status_target = $("#status");
            var status_val = $.trim( status_target.val() );
            var original_target = $("#original");
            var original_val = $.trim( original_target.val() );

            if( title_val.length <= 0){
                title_target.tip("请输入博文标题~~");
                return false;
            }

            if( content.length <= 10){
                $.alert("请输入更多点博文内容~~");
                return false;
            }

            if( tags_val.length <= 0){
                $.alert("请输入博文tags~~");
                return false;
            }

            if( type_val == undefined || parseInt( type_val ) <= 0){
                type_target.tip("请选择类型~~");
                return false;
            }

            btn_target.addClass("disabled");

            var data = {
                id: $.trim($("#post_add_edit input[name=post_id]").val() ),
                title:title_val,
                content:content,
                tags:tags_val,
                type:type_val,
                status:status_val,
                original:original_val
            };
            $.ajax({
                url:'/posts/set',
                data:data,
                type:'POST',
                dataType:'json',
                success:function(res){
                    btn_target.removeClass("disabled");
                    var callback = {};
                    if(res.code == 200){
                        callback = {
                            ok:function(){
                                window.location.href = "/posts/set?id="+res.data.post_id;
                            },
                            cancel:function(){
                                window.location.href = "/posts/set?id="+res.data.post_id;
                            }
                        }
                    }
                    $.alert(res.msg,callback);
                }
            });
        });
    },
    initPlugins:function(){
        $("#post_add_edit input[name=tags]").tagsInput({
            width:'auto',
            height:60,
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