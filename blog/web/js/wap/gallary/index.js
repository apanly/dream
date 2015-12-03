;
var gallary_index_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){

        var $container 	= $('.am-g'),
            $imgs		= $container.find('img').hide(),
            totalImgs	= $imgs.length,
            cnt			= 0;

        $imgs.each(function(i) {
            var $img	= $(this);
            $('<img/>').load(function() {
                ++cnt;
                if( cnt === totalImgs ) {
                    $imgs.show();
                    $container.montage({
                        fillLastRow	: true,
                        alternateHeight	: true,
                        alternateHeightRange : {
                            min	: 200,
                            max	: 240
                        }
                    });
                    $('#overlay').fadeIn(500);
                }
            }).attr('src',$img.attr('src'));
        });
    }
};
$(document).ready(function(){
    gallary_index_ops.init();
});