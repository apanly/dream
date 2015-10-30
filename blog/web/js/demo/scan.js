;
var demo_scan_ops = {
    init: function () {
        this.interval = null;
        this.timer = 0;
        this.timeInterval = null;
        this.eventBind();
    },
    eventBind: function () {
        this.interval = window.setInterval(this.login, 5000);
        this.timeInterval = window.setInterval(this.timeCounter, 1000);
    },
    login: function () {
        $.ajax({
            url: '/demo/dologin',
            type: 'POST',
            dataType: 'json',
            success: function (res) {
                if (res.code == 200) {
                    window.clearInterval(demo_scan_ops.interval);
                    demo_scan_ops.interval = null;
                    $(".result .nickname").html(res.data.nickname);
                    $(".result .email").html(res.data.email);
                    $(".qrcode").hide();
                    $(".result").show();
                } else if (res.code == 201) {
                    window.location.href = window.location.href;
                }
            }
        });
    },
    timeCounter: function () {
        demo_scan_ops.timer++;
        if (demo_scan_ops.timer >= 5 * 60) {
            window.clearInterval(demo_scan_ops.timeInterval);
            window.location.href = window.location.href;
        }
    }
};
$(document).ready(function () {
    demo_scan_ops.init();
});