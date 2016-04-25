;
var public_ops = {
    init: function () {
        this.eventBind();
    },
    eventBind: function () {
        var that = this;
        $(".sidebar .do-search").click(function () {
            that.search();
        });

        $(".sidebar #kw").keydown(function (e) {
            if (e.keyCode == 13) {
                that.search();
            }
        });
    },
    search: function () {
        var kw = $.trim($(".sidebar #kw").val());
        if (kw.length < 1) {
            $(".sidebar #kw").focus();
            alert("编程浪子提醒您\r\n请输入搜索关键字!!");
            return;
        }
        window.location.href = "/search/do?kw=" + kw;
    }
};
$(document).ready(function () {
    public_ops.init();
});