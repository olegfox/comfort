$(function() {
    $(".search input").on('keypress keydown change keyup blur', function() {
        if ($(".search input[type='text']").val() != "") {
            var search_text = $(".search input[type='text']").val();
            $(".cub").each(function() {
                console.log("h2 = "+$(this).find("h2 a").html());
                console.log("text = "+search_text);
                if ($(this).find("h2 a").html().toLowerCase().indexOf(search_text.toLowerCase()) + 1) {
                    $("#" + $(this).attr("id")).show();
                } else {
                    $("#" + $(this).attr("id")).hide();
                }
            });
        }else{
             $(".cub").show();
        }
    });
});


