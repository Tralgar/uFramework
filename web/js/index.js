$(document).ready(function(){

    $("#orderBy").change(function () {
        if($("#orderBy").val()) {
            $("#direction").css('visibility', 'visible');
        }
    })
});