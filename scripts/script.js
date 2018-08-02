function isJSON(data) {
    try {
        JSON.parse(data);
    } catch (e) {
        return false;
    }
    return true;
}
var idofrec;
function funcSuccess(data) {
    if(data == "delete"){
        location.reload();
    }
    else if(isJSON(data)){
        $('#append').empty();
        var result = JSON.parse(data);
        $('#append').append("<form method='post' action='scriptforadmin.php' class=\"reg_form\">\n" +
            "<label for=\"text\">Логин</label><textarea id=\"text\" name=\"text\" placeholder=\"Отредактируйте сообщение\">" + result['text'] + "</textarea><br>\n" +
            "<input class='buttons' type='button' id=\"changeRecord\" value='Изменить'/>\n" +
            "</form>");
        $('#changeRecord').bind("click", function (){
            var text = $('#text').val();
            $('#append').empty();
            $.ajax({
                url: "scriptforadmin.php",
                type: "post",
                data: ({rec_id: idofrec, text: text, changeRecord: 1}),
                dataType: "html",
                success: function () {
                    location.reload();
                }
            });
        });

    }
}

$(document).ready(function () {
    $('.buttons').bind("click", function () {
        var rec_id = $(this).attr('id');
        var temp_rec_id = rec_id.split("_");
        idofrec = Number(temp_rec_id[0]);
        $('#append').empty();
        $('#append').append("<div class='reg_form'>" +
            "Are you sure?"+
            "<input type='button' class='buttons' id='yes' value='yes'>" +
            "<input type='button' class='buttons' id='no' value='no'>" +
            "</div>");
        $('.buttons').bind("click", function (){
           var id = $(this).attr('id');
           if(id == "yes"){
               $('#append').empty();
               $.ajax({
                   url: "scriptforadmin.php",
                   type: "post",
                   data: ({rec_id: rec_id}),
                   dataType: "html",
                   success: funcSuccess
               });
           }
           else {
               location.reload();
           }
        });

    });
});

