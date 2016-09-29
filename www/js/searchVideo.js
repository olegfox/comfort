$(function() {
    $(".search input").on('keypress keydown change keyup blur', function() {
        if ($(".search input[type='text']").val() != "") {
            var search_text = $(".search input[type='text']").val();
            $(".video").each(function() {
                if ($(this).find("h1").html().toLowerCase().indexOf(search_text.toLowerCase()) + 1) {
                   $(this).show();
                } else {
                   $(this).hide();
                }
            });
        }else{
             $(".video").show();
        }
    });
});


