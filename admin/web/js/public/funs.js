;
$(document).ready(function(){

    var html_click_avail = true;

    $("html").on("click", function(){
        if(html_click_avail)
            $(".x-navigation-horizontal li,.x-navigation-minimized li").removeClass('active');
    });

    $(".x-navigation-horizontal .panel").on("click",function(e){
        e.stopPropagation();
    });

    // XN PANEL DRAGGING
    $( ".xn-panel-dragging" ).draggable({
        containment: ".page-content", handle: ".panel-heading", scroll: false,
        start: function(event,ui){
            html_click_avail = false;
            $(this).addClass("dragged");
        },
        stop: function( event, ui ) {
            $(this).resizable({
                maxHeight: 400,
                maxWidth: 600,
                minHeight: 200,
                minWidth: 200,
                helper: "resizable-helper",
                start: function( event, ui ) {
                    html_click_avail = false;
                },
                stop: function( event, ui ) {
                    $(this).find(".panel-body").height(ui.size.height - 82);
                    $(this).find(".scroll").mCustomScrollbar("update");

                    setTimeout(function(){
                        html_click_avail = true;
                    },1000);

                }
            })

            setTimeout(function(){
                html_click_avail = true;
            },1000);
        }
    });
    // END XN PANEL DRAGGING

    /* DROPDOWN TOGGLE */
    $(".dropdown-toggle").on("click",function(){
        onresize();
    });
    /* DROPDOWN TOGGLE */

    /* CONTENT FRAME */
    $(".content-frame-left-toggle").on("click",function(){
        $(".content-frame-left").is(":visible")
            ? $(".content-frame-left").hide()
            : $(".content-frame-left").show();
        page_content_onresize();
    });
    $(".content-frame-right-toggle").on("click",function(){
        $(".content-frame-right").is(":visible")
            ? $(".content-frame-right").hide()
            : $(".content-frame-right").show();
        page_content_onresize();
    });
    /* END CONTENT FRAME */


    /* PANELS */

    $(".panel-fullscreen").on("click",function(){
        panel_fullscreen($(this).parents(".panel"));
        return false;
    });

    $(".panel-collapse").on("click",function(){
        panel_collapse($(this).parents(".panel"));
        $(this).parents(".dropdown").removeClass("open");
        return false;
    });
    $(".panel-remove").on("click",function(){
        panel_remove($(this).parents(".panel"));
        $(this).parents(".dropdown").removeClass("open");
        return false;
    });
    $(".panel-refresh").on("click",function(){
        window.location.href = window.location.href;
        return false;
    });
    /* EOF PANELS */

    /* ACCORDION */
    $(".accordion .panel-title a").on("click",function(){

        var blockOpen = $(this).attr("href");
        var accordion = $(this).parents(".accordion");
        var noCollapse = accordion.hasClass("accordion-dc");


        if($(blockOpen).length > 0){

            if($(blockOpen).hasClass("panel-body-open")){
                $(blockOpen).slideUp(200,function(){
                    $(this).removeClass("panel-body-open");
                });
            }else{
                $(blockOpen).slideDown(200,function(){
                    $(this).addClass("panel-body-open");
                });
            }

            if(!noCollapse){
                accordion.find(".panel-body-open").not(blockOpen).slideUp(200,function(){
                    $(this).removeClass("panel-body-open");
                });
            }

            return false;
        }

    });
    /* EOF ACCORDION */

    /* DATATABLES/CONTENT HEIGHT FIX */
    $(".dataTables_length select").on("change",function(){
        onresize();
    });
    /* END DATATABLES/CONTENT HEIGHT FIX */

    /* TOGGLE FUNCTION */
    $(".toggle").on("click",function(){
        var elm = $("#"+$(this).data("toggle"));
        if(elm.is(":visible"))
            elm.addClass("hidden").removeClass("show");
        else
            elm.addClass("show").removeClass("hidden");

        return false;
    });
    /* END TOGGLE FUNCTION */
    x_navigation();
});

function x_navigation_onresize(){

    var inner_port = window.innerWidth || $(document).width();

    if(inner_port < 1025){
        $(".page-sidebar .x-navigation").removeClass("x-navigation-minimized");
        $(".page-container").removeClass("page-container-wide");
        $(".page-sidebar .x-navigation li.active").removeClass("active");


        $(".x-navigation-horizontal").each(function(){
            if(!$(this).hasClass("x-navigation-panel")){
                $(".x-navigation-horizontal").addClass("x-navigation-h-holder").removeClass("x-navigation-horizontal");
            }
        });


    }else{
        if($(".page-navigation-toggled").length > 0){
            x_navigation_minimize("close");
        }

        $(".x-navigation-h-holder").addClass("x-navigation-horizontal").removeClass("x-navigation-h-holder");
    }

}

function x_navigation_minimize(action){

    if(action == 'open'){
        $(".page-container").removeClass("page-container-wide");
        $(".page-sidebar .x-navigation").removeClass("x-navigation-minimized");
        $(".x-navigation-minimize").find(".fa").removeClass("fa-indent").addClass("fa-dedent");
        $(".page-sidebar.scroll").mCustomScrollbar("update");
    }

    if(action == 'close'){
        $(".page-container").addClass("page-container-wide");
        $(".page-sidebar .x-navigation").addClass("x-navigation-minimized");
        $(".x-navigation-minimize").find(".fa").removeClass("fa-dedent").addClass("fa-indent");
        $(".page-sidebar.scroll").mCustomScrollbar("disable",true);
    }

    $(".x-navigation li.active").removeClass("active");

}

function x_navigation(){

    $(".x-navigation-control").click(function(){
        $(this).parents(".x-navigation").toggleClass("x-navigation-open");

        onresize();

        return false;
    });

    if($(".page-navigation-toggled").length > 0){
        x_navigation_minimize("close");
    }

    $(".x-navigation-minimize").click(function(){

        if($(".page-sidebar .x-navigation").hasClass("x-navigation-minimized")){
            $(".page-container").removeClass("page-navigation-toggled");
            x_navigation_minimize("open");
        }else{
            $(".page-container").addClass("page-navigation-toggled");
            x_navigation_minimize("close");
        }

        onresize();

        return false;
    });

    $(".x-navigation  li > a").click(function(){

        var li = $(this).parent('li');
        var ul = li.parent("ul");

        ul.find(" > li").not(li).removeClass("active");

    });

    $(".x-navigation li").click(function(event){
        event.stopPropagation();

        var li = $(this);

        if(li.children("ul").length > 0 || li.children(".panel").length > 0 || $(this).hasClass("xn-profile") > 0){
            if(li.hasClass("active")){
                li.removeClass("active");
                li.find("li.active").removeClass("active");
            }else
                li.addClass("active");

            onresize();

            if($(this).hasClass("xn-profile") > 0)
                return true;
            else
                return false;
        }
    });

    /* XN-SEARCH */
    $(".xn-search").on("click",function(){
        $(this).find("input").focus();
    })
    /* END XN-SEARCH */

}
/* EOF X-NAVIGATION CONTROL FUNCTIONS */

/* PAGE ON RESIZE WITH TIMEOUT */
function onresize(timeout){
    timeout = timeout ? timeout : 200;

    setTimeout(function(){
        page_content_onresize();
    },timeout);
}
/* EOF PAGE ON RESIZE WITH TIMEOUT */

$(function(){
    onload();
});

$(window).resize(function(){
    x_navigation_onresize();
    page_content_onresize();
});

function onload(){
    x_navigation_onresize();
    page_content_onresize();
}

function page_content_onresize(){
    $(".page-content,.content-frame-body,.content-frame-right,.content-frame-left").css("width","").css("height","");

    var content_minus = 0;
    content_minus = ($(".page-container-boxed").length > 0) ? 40 : content_minus;
    content_minus += ($(".page-navigation-top-fixed").length > 0) ? 50 : 0;

    var content = $(".page-content");
    var sidebar = $(".page-sidebar");

    if(content.height() < $(document).height() - content_minus){
        content.height($(document).height() - content_minus);
    }

    if(sidebar.height() > content.height()){
        content.height(sidebar.height());
    }

    if($(window).width() > 1024){

        if($(".page-sidebar").hasClass("scroll")){
            if($("body").hasClass("page-container-boxed")){
                var doc_height = $(document).height() - 40;
            }else{
                var doc_height = $(window).height();
            }
            $(".page-sidebar").height(doc_height);

        }

        if($(".content-frame-body").height() < $(document).height()-162){
            $(".content-frame-body,.content-frame-right,.content-frame-left").height($(document).height()-162);
        }else{
            $(".content-frame-right,.content-frame-left").height($(".content-frame-body").height());
        }

        $(".content-frame-left").show();
        $(".content-frame-right").show();
    }else{
        $(".content-frame-body").height($(".content-frame").height()-80);

        if($(".page-sidebar").hasClass("scroll"))
            $(".page-sidebar").css("height","");
    }

    if($(window).width() < 1200){
        if($("body").hasClass("page-container-boxed")){
            $("body").removeClass("page-container-boxed").data("boxed","1");
        }
    }else{
        if($("body").data("boxed") === "1"){
            $("body").addClass("page-container-boxed").data("boxed","");
        }
    }
};