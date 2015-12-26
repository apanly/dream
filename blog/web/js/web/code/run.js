;
var code_run_ops = {
    init:function(){
        this.editor = null;
        this.initCodeMirror();
        this.eventBind();
    },
    eventBind:function(){
        var that = this;
        $(".btn-run").click(function(){
            var previewFrame = document.getElementById('preview');
            var preview =  previewFrame.contentDocument ||  previewFrame.contentWindow.document;
            preview.open();
            preview.write(that.editor.getValue());
            preview.close();
        });
        $(".btn-run").click();
    },
    initCodeMirror:function(){
        var delay;
        // Initialize CodeMirror editor with a nice html5 canvas demo.
        var editor = CodeMirror.fromTextArea(document.getElementById('code_html'), {
            mode: 'text/html',
            lineNumbers: true,
            styleActiveLine: true,
            matchBrackets: true
        });
        editor.setOption("theme", "material");

        editor.on("change", function() {
            //$(".btn-run").click();
        });
        var height = $(window).height() - 50 ;
        $(".CodeMirror").css("height",height + "px");
        $("#preview-box").css("height",height + "px");
        this.editor = editor;
    }
}

$(document).ready(function(){
    code_run_ops.init();
});