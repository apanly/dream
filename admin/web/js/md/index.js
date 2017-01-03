;
var md_index_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $("#search_conditions .do").click(function(){
            $("#search_conditions").submit();
        });

        $("#search_conditions .clear_search").click( function(){
            $("#search_conditions select[name=status]").val(-99);
            $("#search_conditions input[name=kw]").val('');
            $("#search_conditions .do").click();
        });

        $("#search_conditions input[name=kw]").keydown(function (e) {
            if (e.keyCode == 13) {
                $("#search_conditions .do").click();
            }
        });
    }
};
$(document).ready( function(){
    md_index_ops.init();
});