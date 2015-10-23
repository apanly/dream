;
var richmedia_index_ops = {
    init:function(){
        this.p = 1;
        this.eventBind();
    },
    eventBind:function(){
        var that = this;
        $(window).scroll(function () {
            if (($(window).scrollTop() + $(window).height() > $(document).height() - 10) && stop) {
                stop = false;
                $('.loading').show();
                that.p += 1;
                var p = that.p;
                $.ajax({
                    url: common_ops.getUrlPrefix() + '/richmedia/search',
                    type: 'GET',
                    dataType: 'json',
                    data: {'p':p},
                    success: function (res) {
                        if (res.code == 200) {
                            var t = setTimeout(function () {
                                $('.loading').hide();
                                if (res.data.has_data) {
                                    $(".am-gallery").append(res.data.html);
                                    stop = true;
                                }
                                if (!res.data.has_next) {
                                    stop = false;
                                }
                            }, 5);
                        }
                    }
                });
            }
        });
    }
};

$(document).ready(function(){
    richmedia_index_ops.init();
});