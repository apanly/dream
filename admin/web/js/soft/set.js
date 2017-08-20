;
var soft_set_ops = {
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

        $("#soft_set_wrap .save").click(function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                $.alert("正在保存，请不要重复提交~~");
                return false;
            }

            var title_target = $("#soft_set_wrap input[name=title]");
            var title_val = $.trim( title_target.val() );
            var content  = $.trim( that.ue.getContent() );
            var tags_val = $.trim( $("#soft_set_wrap input[name=tags]").val() );
            var down_url = $.trim( $("#soft_set_wrap input[name=down_url]").val() );
            var type_target = $("#type");
            var type_val = $.trim( type_target.val() );
            var status_target = $("#status");
            var status_val = $.trim( status_target.val() );

            if( title_val.length <= 0){
                title_target.tip("请输入标题~~");
                return false;
            }

            if( type_val == undefined || parseInt( type_val ) <= 0){
                type_target.tip("请选择类型~~");
                return false;
            }

            btn_target.addClass("disabled");

            var data = {
                id: $.trim($("#soft_set_wrap input[name=soft_id]").val() ),
                title:title_val,
                content:content,
                down_url:down_url,
                tags:tags_val,
                type:type_val,
                status:status_val
            };
            $.ajax({
                url:'/soft/set',
                data:data,
                type:'POST',
                dataType:'json',
                success:function(res){
                    btn_target.removeClass("disabled");
                    var callback = {};
                    if(res.code == 200){
                        callback = {
                            ok:function(){
                                window.location.href = "/soft/set?id="+res.data.id;
                            },
                            cancel:function(){
                                window.location.href = "/soft/set?id="+res.data.id;
                            }
                        }
                    }
                    $.alert(res.msg,callback);
                }
            });
        });
    },
    initPlugins:function(){
        $("#soft_set_wrap input[name=tags]").tagsInput({
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
    soft_set_ops.init();
});