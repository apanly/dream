;
var public_ops = {
    init: function () {
        this.eventBind();
        this.backToTop();
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
    },
    backToTop: function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
        $('#back-to-top').on('click', function (e) {
            e.preventDefault();
            $('html, body').animate({scrollTop: 0}, 1000);
            return false;
        });
    }
};
$(document).ready(function () {
    public_ops.init();
});