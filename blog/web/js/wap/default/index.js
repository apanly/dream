;
var default_index_ops = {
    init: function () {
        this.p = 1;
        this.type = parseInt($("#type").val());
        this.eventBind();

    },
    eventBind: function () {
        var that = this;
        $($("#se_btn a").get((that.type - 1))).addClass("am-btn-success");

        $(window).scroll(function () {
            if (($(window).scrollTop() + $(window).height() > $(document).height() - 10) && stop) {
                stop = false;
                $('.loading').show();
                that.p += 1;
                var p = that.p;
                $.ajax({
                    url: common_ops.getUrlPrefix() + '/default/search',
                    type: 'GET',
                    dataType: 'json',
                    data: {'p': p, 'type': that.type},
                    success: function (res) {
                        if (res.code == 200) {
                            var t = setTimeout(function () {
                                $('.loading').hide();
                                if (res.data.has_data) {
                                    $(".am-list").append(res.data.html);
                                    stop = true;
                                }
                                if (!res.data.has_next) {
                                    stop = false;
                                }
                            }, 2);
                        }
                    }
                });
            }
        });
    }
};

$(document).ready(function () {
    default_index_ops.init();
});