<?php
use \blog\components\StaticService;
use \common\service\GlobalUrlService;
StaticService::includeStaticCss("/codemirror/lib/codemirror.css",\blog\assets\CodeMirrorAsset::className() );

StaticService::includeStaticCss("/codemirror/theme/material.css",\blog\assets\CodeMirrorAsset::className() );

StaticService::includeStaticJs("/codemirror/lib/codemirror.js",\blog\assets\CodeMirrorAsset::className() );
StaticService::includeStaticJs("/codemirror/mode/xml/xml.js",\blog\assets\CodeMirrorAsset::className() );
StaticService::includeStaticJs("/codemirror/mode/javascript/javascript.js",\blog\assets\CodeMirrorAsset::className() );
StaticService::includeStaticJs("/codemirror/mode/css/css.js",\blog\assets\CodeMirrorAsset::className() );
StaticService::includeStaticJs("/codemirror/mode/htmlmixed/htmlmixed.js",\blog\assets\CodeMirrorAsset::className() );


StaticService::includeAppCssStatic("/css/web/code/run.css",\blog\assets\CodeMirrorAsset::className() );
StaticService::includeAppJsStatic("/js/web/code/run.js",\blog\assets\CodeMirrorAsset::className() );
?>
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="row" id="code-box">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <textarea id="code_html">
                <!doctype html>
                <html>
                <head>
                    <meta charset=utf-8>
                    <title>HTML5 canvas demo</title>
                    <style>p {font-family: monospace;}</style>
                </head>
                <body>
                <p>Canvas pane goes here:</p>
                <canvas id=pane width=300 height=200></canvas>
                <script>
                    var canvas = document.getElementById('pane');
                    var context = canvas.getContext('2d');

                    context.fillStyle = 'rgb(250,0,0)';
                    context.fillRect(10, 10, 55, 50);

                    context.fillStyle = 'rgba(0, 0, 250, 0.5)';
                    context.fillRect(30, 30, 55, 50);
                </script>
                </body>
                </html>
            </textarea>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

        </div>
    </div>

</div>

<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="preview-box">
    <iframe id="preview" frameborder="no" border="0" marginwidth="0" marginheight="0"  allowtransparency="yes" ></iframe>
</div>