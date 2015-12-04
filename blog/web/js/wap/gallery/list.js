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
                        fillLastRow	:false,
                        alternateHeight	: true,
                        alternateHeightRange : {
                            min	: 90,
                            max	: 250
                        },
                        margin : 0
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

//liquid					: true, // if you use percentages (or no width at all) for the container's width, then set this to true
//    // this will set the body's overflow-y to scroll ( fix for the scrollbar's width problem )
//    margin					: 1,	// space between images.
//    minw					: 70,	// the minimum width that a picture should have.
//    minh					: 20,	// the minimum height that a picture should have.
//    maxh					: 250,	// the maximum height that a picture should have.
//    alternateHeight			: false,// alternate the height value for every row. If true this has priority over defaults.fixedHeight.
//    alternateHeightRange	: {		// the height will be a random value between min and max.
//    min	: 100,
//        max	: 300
//},
//fixedHeight				: null,	// if the value is set this has priority over defaults.minsize. All images will have this height.
//    minsize					: false,// minw,minh are irrelevant. Chosen height is the minimum one available.
//    fillLastRow				: false	// if true, there will be no gaps in the container. The last image will fill any white space available