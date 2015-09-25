$(function() {
    if( $(".summernote").length > 0 ){
        $(".summernote").summernote({
            height: 250,
            focus: true,
            codemirror: {
                mode: 'text/html',
                htmlMode: true,
                lineNumbers: true,
                theme: 'default'
            },
            toolbar: [
                ['style', ['style']],
                ["style", ["bold", "italic", "underline",  "strikethrough", "clear"]],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']], // no table button
                ["insert", ["link", "picture", "video", "hr"]],
                ['view', ['fullscreen', "codeview"]],
                ['help', ['help']] //no help butt
            ],
            onImageUpload: function(files, editor, $editable) {
                //console.log('image upload:', files, editor, $editable);
                sendFile(files[0],editor,$editable);
            }
        });
    }

});