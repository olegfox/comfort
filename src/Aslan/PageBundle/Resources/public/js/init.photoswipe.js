var pswpElement = document.querySelectorAll('.pswp')[0];

var items = [];

$(".square ul li a").each(function(i, e) {
    //var newImg = new Image();
    //newImg.src = $(e).attr("href");
    //var curHeight = newImg.height;
    //var curWidth = newImg.width;

    items.push({
        src: $(e).attr("href"),
        w: $(e).data("width"),
        h: $(e).data("height")
    });
});

$(".square ul li a").click(function(e) {
    e.preventDefault();

    var options = {
        index: $(".square ul li a").index(this)
    };

    var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
    gallery.init();
});

