function hideGallery(href) {
    $("#container").show();
}
block = 0;
function collections_right(id, all_photos) {

    if (block == 0) {
        block = 1;
        $(".olegfox_zoom_wrap" + id).animate({"left": -$(".olegfox_zoom_wrap" + id).width()}, {duration: 500, complete: function() {
                $(".olegfox_zoom_wrap" + id).remove();
                index = 0;
                for (i = 0; i < all_photos.length; i++) {
                    if (all_photos[i]["id"] == id) {

                        if (i == all_photos.length - 1) {
                            index = 0;
                        }
                        else {
                            index = i + 1;
                        }
                    }
                }
                $(".olegfox_zoom_btn_right").unbind("click");
                $(".olegfox_zoom_btn_right").click(function() {
                    collections_right(all_photos[index]['id'], all_photos);
                });
                $(".olegfox_zoom_btn_left").unbind("click");
                $(".olegfox_zoom_btn_left").click(function() {
                    collections_left(all_photos[index]['id'], all_photos);
                });
                if ($(".olegfox_zoom_wrap" + all_photos[index]['id'] + "").length >= 0) {
                    $(".olegfox_zoom_wrap" + all_photos[index]['id'] + "").remove();
                }
                $("body").prepend("<div class='olegfox_zoom_wrap" + all_photos[index]['id'] + " olegfox'><img class='olegfox_zoom olegfox_zoom" + all_photos[index]['id'] + "' /><div class='olegfox_zoom_title" + all_photos[index]['id'] + "'></div></div>");

                $(".olegfox_zoom" + all_photos[index]['id'] + "").attr("src", "./media/pictures/" + all_photos[index]['photo']);
                $(".olegfox_zoom" + all_photos[index]['id'] + "").load(function() {
                    width_new = $(".olegfox_zoom" + all_photos[index]['id']).width();
                    height_new = $(".olegfox_zoom" + all_photos[index]['id']).height();
                    scale = width_new / height_new;
                    if (height_new > $("body").height() - 100) {
                        height_new = $("body").height()-100;
                        width_new = scale * height_new;
                    }
                    $(".olegfox_zoom" + all_photos[index]['id']).css({"display": "none"});
                    $(".olegfox_zoom_title" + all_photos[index]['id']).css({
                        "width": width_new - 20
                    });
                    $(".olegfox_zoom_wrap" + all_photos[index]['id']).css({
                        "left": $("body").width() + width_new
                    });
                    top_new = ($("body").height() - height_new) / 2 -5;
                    left_new = ($("body").width() - width_new) / 2;
                    $(".olegfox_zoom" + all_photos[index]['id']).css({"display": "block", "opacity": 1});
                    $(".olegfox_zoom_wrap" + all_photos[index]['id']).css({
                        "width": width_new,
                        "height": height_new + $(".olegfox_zoom_title" + all_photos[index]['id']).height(),
                        "margin-top": 0,
                        "margin-left": 0,
                        "position": "fixed",
                        "z-index": 2001,
                    });
                    $(".olegfox_zoom" + all_photos[index]['id'] + "").css({
                        "width": width_new,
                        "height": height_new,
                        "margin-top": 0,
                        "margin-left": 0,
                        "z-index": 2001,
                    });
                    $(".olegfox_zoom_wrap" + all_photos[index]['id']).css({
                        "top": top_new
                    });
                    drag = 1;
                    $(".olegfox_zoom_title" + all_photos[index]['id']).show();
                    $(".olegfox_zoom_wrap" + all_photos[index]['id']).animate({
                        "left": left_new
                    }, {duration: 500, queue: false, complete: function() {
                            block = 0;
                            $(".olegfox_zoom_wrap" + all_photos[index]['id'] + "").draggable({drag: function() {
                                    drag = 2;
                                }, stop: function() {
                                }});
                        }});
                    $(".olegfox_zoom" + all_photos[index]['id'] + "").click(function() {
                        if (drag > 1) {
                            drag--;
                        }
                        else {
                            $(".olegfox_zoom_title" + all_photos[index]['id']).hide();
                            $(".olegfox_bg").animate({
                                "opacity": "0"
                            }, {duration: 500, complete: function() {

                                    $(this).remove();
                                }});
                            $(".olegfox_zoom_btn_left").animate({"left": "-100px"}, 500);
                            $(".olegfox_zoom_btn_right").animate({"right": "-100px"}, 500);
                            $(".olegfox_zoom_btn_left, .olegfox_zoom_btn_right").animate({
                                "opacity": "0",
                            }, {duration: 500, complete: function() {
                                    $(this).remove();
                                }});
                            $(".olegfox_zoom_wrap" + all_photos[index]['id'] + "").animate({
                                "width": $("#box" + all_photos[index]['id']).width(),
                                "height": $("#box" + all_photos[index]['id']).height(),
                                "left": $("#box" + all_photos[index]['id']).offset().left,
                                "top": $("#box" + all_photos[index]['id']).offset().top - $(window).scrollTop()
                            }, {duration: 500, queue: false});

                            if (width_new > height_new) {
                                heightt = $("#box" + all_photos[index]['id']).height();
                                margin_left = -((heightt * (width_new / height_new)) - $("#box" + all_photos[index]['id']).width()) / 2;
                                $(".olegfox_zoom" + all_photos[index]['id'] + "").animate({
                                    "height": heightt,
                                    "width": heightt * (width_new / height_new),
                                    "margin-left": margin_left,
                                    "margin-top": 0
                                }, {duration: 500, queue: false, complete: function() {
                                        $(".olegfox").remove();
                                    }
                                });
                            }
                            else {
                                widthh = $("#box" + all_photos[index]['id']).width();
                                margin_top = -((widthh / (width_new / height_new)) - $("#box" + all_photos[index]['id']).height()) / 2;
                                $(".olegfox_zoom" + all_photos[index]['id'] + "").animate({
                                    "width": widthh,
                                    "height": widthh / (width_new / height_new),
                                    "margin-left": 0,
                                    "margin-top": margin_top
                                }, {duration: 500, queue: false, complete: function() {
                                        $(".olegfox").remove();
                                    }
                                });
                            }
                        }
                    });
                    $(".olegfox_bg").unbind("click");
                    $(".olegfox_bg").click(function() {
                        $(".olegfox_zoom" + all_photos[index]['id']).click();
                    });
//                                    $(".olegfox_zoom" + all_photos[index]['id'] + "").click(function() {
//                                        $(".olegfox_zoom").each(function(k, v) {
//                                            //if ($(this).attr("class") != $(".olegfox_zoom" + all_photos[index]['id'] + "").attr("class"))
//                                                $(this).click();
//                                            //$(this).keydown();
//                                        });
//                                    });
                });
                //$(this).remove();
            }});
    }
}
function collections_left(id, all_photos) {
    if (block == 0) {
        block = 1;
        $(".olegfox_zoom_wrap" + id).animate({"left": $("body").width() + $(".olegfox_zoom_wrap" + id).width()}, {duration: 500, complete: function() {
                $(".olegfox_zoom_wrap" + id).remove();
                index = 0;
                for (i = 0; i < all_photos.length; i++) {
                    if (all_photos[i]["id"] == id) {

                        if (i == 0) {
                            index = all_photos.length - 1;
                        }
                        else {
                            index = i - 1;
                        }
                    }
                }
                $(".olegfox_zoom_btn_right").unbind("click");
                $(".olegfox_zoom_btn_right").click(function() {
                    collections_right(all_photos[index]['id'], all_photos);
                });
                $(".olegfox_zoom_btn_left").unbind("click");
                $(".olegfox_zoom_btn_left").click(function() {
                    collections_left(all_photos[index]['id'], all_photos);
                });
                $("body").prepend("<div class='olegfox_zoom_wrap" + all_photos[index]['id'] + " olegfox'><img class='olegfox_zoom olegfox_zoom" + all_photos[index]['id'] + "' /><div class='olegfox_zoom_title" + all_photos[index]['id'] + "'></div></div>");

                $(".olegfox_zoom" + all_photos[index]['id'] + "").attr("src", "./media/pictures/" + all_photos[index]['photo']);
                $(".olegfox_zoom" + all_photos[index]['id'] + "").load(function() {
                    width_new = $(".olegfox_zoom" + all_photos[index]['id']).width();
                    height_new = $(".olegfox_zoom" + all_photos[index]['id']).height();
                    scale = width_new / height_new;
                    if (height_new > $("body").height() - 100) {
                        height_new = $("body").height()-100;
                        width_new = scale * height_new;
                    }
                    $(".olegfox_zoom" + all_photos[index]['id']).css({"display": "none"});
                    $(".olegfox_zoom_title" + all_photos[index]['id']).css({
                        "width": width_new - 20
                    });
                    $(".olegfox_zoom_wrap" + all_photos[index]['id']).css({
                        "left": -width_new
                    });
                    top_new = ($("body").height() - height_new) / 2 -5;
                    left_new = ($("body").width() - width_new) / 2;
                    $(".olegfox_zoom" + all_photos[index]['id']).css({"display": "block", "opacity": 1});
                    $(".olegfox_zoom_wrap" + all_photos[index]['id']).css({
                        "width": width_new,
                        "height": height_new + $(".olegfox_zoom_title" + all_photos[index]['id']).height(),
                        "margin-top": 0,
                        "margin-left": 0,
                        "position": "fixed",
                        "z-index": 2001,
                    });
                    $(".olegfox_zoom" + all_photos[index]['id'] + "").css({
                        "width": width_new,
                        "height": height_new,
                        "margin-top": 0,
                        "margin-left": 0,
                        "z-index": 2001,
                    });
                    $(".olegfox_zoom_wrap" + all_photos[index]['id']).css({
                        "top": top_new
                    });
                    drag = 1;
                    $(".olegfox_zoom_title" + all_photos[index]['id']).show();
                    $(".olegfox_zoom_wrap" + all_photos[index]['id']).animate({
                        "left": left_new
                    }, {duration: 500, queue: false, complete: function() {
                            block = 0;
                            $(".olegfox_zoom_wrap" + all_photos[index]['id'] + "").draggable({drag: function() {
                                    drag = 2;
                                }, stop: function() {
                                }});
                        }});
                    $(".olegfox_zoom" + all_photos[index]['id'] + "").click(function() {
                        if (drag > 1) {
                            drag--;
                        }
                        else {
                            $(".olegfox_zoom_title" + all_photos[index]['id']).hide();
                            $(".olegfox_bg").animate({
                                "opacity": "0"
                            }, {duration: 500, complete: function() {

                                    $(this).remove();
                                }});
                            $(".olegfox_zoom_btn_left").animate({"left": "-100px"}, 500);
                            $(".olegfox_zoom_btn_right").animate({"right": "-100px"}, 500);
                            $(".olegfox_zoom_btn_left, .olegfox_zoom_btn_right").animate({
                                "opacity": "0",
                            }, {duration: 500, complete: function() {
                                    $(this).remove();
                                }});
                            $(".olegfox_zoom_wrap" + all_photos[index]['id'] + "").animate({
                                "width": $("#box" + all_photos[index]['id']).width(),
                                "height": $("#box" + all_photos[index]['id']).height(),
                                "left": $("#box" + all_photos[index]['id']).offset().left,
                                "top": $("#box" + all_photos[index]['id']).offset().top - $(window).scrollTop()
                            }, {duration: 500, queue: false});

                            if (width_new > height_new) {
                                heightt = $("#box" + all_photos[index]['id']).height();
                                margin_left = -((heightt * (width_new / height_new)) - $("#box" + all_photos[index]['id']).width()) / 2;
                                $(".olegfox_zoom" + all_photos[index]['id'] + "").animate({
                                    "height": heightt,
                                    "width": heightt * (width_new / height_new),
                                    "margin-left": margin_left,
                                    "margin-top": 0
                                }, {duration: 500, queue: false, complete: function() {
                                        $(".olegfox").remove();
                                    }
                                });
                            }
                            else {
                                widthh = $("#box" + all_photos[index]['id']).width();
                                margin_top = -((widthh / (width_new / height_new)) - $("#box" + all_photos[index]['id']).height()) / 2;
                                $(".olegfox_zoom" + all_photos[index]['id'] + "").animate({
                                    "width": widthh,
                                    "height": widthh / (width_new / height_new),
                                    "margin-left": 0,
                                    "margin-top": margin_top
                                }, {duration: 500, queue: false, complete: function() {
                                        $(".olegfox").remove();
                                    }
                                });
                            }
                        }
                    });
                    $(".olegfox_bg").unbind("click");
                    $(".olegfox_bg").click(function() {
                        $(".olegfox_zoom" + all_photos[index]['id']).click();
                    });
                });
            }});
    }
}
function collections(id, photo_url, all_photos) {
    all_photos = $.parseJSON(all_photos);//парсим массив всех фоток
    if ($(".olegfox_zoom_wrap" + id + "").length <= 0) {

        if ($(".olegfox").length > 0) {
            $(".olegfox").click();
        }
        //вставляем дивы для фотки
        $("body").prepend("<div class='olegfox_bg'></div><div class='olegfox_zoom_btn_left'></div><div class='olegfox_zoom_btn_right'></div><div class='olegfox_zoom_wrap" + id + " olegfox'><img style='display:none;' class='olegfox_zoom olegfox_zoom" + id + "' /><div class='olegfox_zoom_title" + id + "'></div></div>");

        $(".olegfox_zoom_wrap" + id + "").offset({"top": $("#box" + id).offset().top - $(window).scrollTop(), "left": $("#box" + id).offset().left}).css({
            "width": $("#box" + id).width(),
            "height": $("#box" + id).height(),
            "position": "fixed",
            "overflow": "hidden",
            "z-index": 2001
        });
        $(".olegfox_zoom" + id + "").attr("src", "./media/pictures/" + photo_url);
        //ждём пока фотка загрузится и ...
        $(".olegfox_zoom" + id + "").load(function() {
            $(".olegfox_zoom" + id + "").show();
            //берём размеры реальной фотографии
            width = $(".olegfox_zoom" + id + "").width();
            height = $(".olegfox_zoom" + id + "").height();
            scale = width / height;
            if (height > $("body").height() - 100) {
                height = $("body").height()-100;
                width = scale * height;
            }
            $(".olegfox_zoom_title" + id).css({
                "width": width - 20
            });
            if ($(".olegfox_zoom" + id + "").width() > $(".olegfox_zoom" + id + "").height()) {
                $(".olegfox_zoom" + id + "").css({
                    "height": $("#box" + id).height()
                });
                $(".olegfox_zoom" + id + "").css({
                    "margin-left": -($(".olegfox_zoom" + id + "").width() - $("#box" + id).width()) / 2
                });
            }
            else {
                $(".olegfox_zoom" + id + "").css({
                    "width": $("#box" + id).width()
                });
                $(".olegfox_zoom" + id + "").css({
                    "margin-top": -($(".olegfox_zoom" + id + "").height() - $("#box" + id).height()) / 2
                });
            }
            topp = ($("body").height() - height) / 2 - 5;
            leftt = ($("body").width() - width) / 2;
            var drag = 0;
            $(".olegfox_bg").animate({
                "opacity": "0.97"
            }, 500);
            $(".olegfox_zoom_btn_left, .olegfox_zoom_btn_right").animate({
                "opacity": "1"
            }, 500);
            $(".olegfox_zoom_btn_left").animate({"left": "0px"}, {duration: 500, queue: false}).click(function() {
                collections_left(id, all_photos);
            });
            $(".olegfox_zoom_btn_right").animate({"right": "0px"}, {duration: 500, queue: false}).click(function() {
                collections_right(id, all_photos);
//                                    $(".olegfox_zoom_wrap" + id).animate({"left": $(this).offset().left + 100 + $(".olegfox_zoom_wrap" + id).width()}, {duration: 500, complete: function() {
//                                            //$(this).remove();
//                                        }});
            });

            $(document).keyup(function(e) {
                switch (e.keyCode) {
                    case 27:
                        $(".olegfox_bg").click();
                        break;
                    case 37:
                        $('.olegfox_zoom_btn_left').click();
                        break;
                    case 39:
                        $('.olegfox_zoom_btn_right').click();
                        break;
                }
            });
            window.galleryPopupKeyEvenentsSet = true;

            $(".olegfox_bg").click(function() {
                $(".olegfox_zoom" + id).click();
            });
            $(".olegfox_zoom" + id + "").css({"opacity": 1});
            $(".olegfox_zoom_wrap" + id).animate({
                "width": width,
                "height": height + $(".olegfox_zoom_title" + id).height(),
                "margin-top": 0,
                "margin-left": 0
            }, {duration: 500, queue: false});
            $(".olegfox_zoom" + id + "").animate({
                "width": width,
                "height": height,
                "margin-top": 0,
                "margin-left": 0
            }, {duration: 500, queue: false, complete: function() {
                    $(".olegfox_zoom_title" + id).show();
                    $(".olegfox_zoom_wrap" + id + "").draggable({drag: function() {
                            drag = 2;
                        }, stop: function() {
                        }});
                }
            }).click(function() {
                if (drag > 0) {
                    drag--;
                }
                else {
                    $(".olegfox_zoom_title" + id).hide();
                    $(".olegfox_zoom_wrap" + id + "").css({
                        "z-index": 2000
                    });
                    $(".olegfox_bg").animate({
                        "opacity": "0"
                    }, {duration: 500, complete: function() {

                            $(this).remove();
                        }});
                    $(".olegfox_zoom_btn_left").animate({"left": "-100px"}, 500);
                    $(".olegfox_zoom_btn_right").animate({"right": "-100px"}, 500);
                    $(".olegfox_zoom_btn_left, .olegfox_zoom_btn_right").animate({
                        "opacity": "0",
                    }, {duration: 500, complete: function() {
                            $(this).remove();
                        }});
                    $(".olegfox_zoom_wrap" + id + "").animate({
                        "width": $("#box" + id).width(),
                        "height": $("#box" + id).height(),
                        "left": $("#box" + id).offset().left,
                        "top": $("#box" + id).offset().top - $(window).scrollTop()
                    }, {duration: 500, queue: false});

                    if (width > height) {
                        heightt = $("#box" + id).height();
                        margin_left = -((heightt * (width / height)) - $("#box" + id).width()) / 2;
                        $(".olegfox_zoom" + id + "").animate({
                            "height": heightt,
                            "width": heightt * (width / height),
                            "margin-left": margin_left,
                            "margin-top": 0
                        }, {duration: 500, queue: false, complete: function() {
                                $(".olegfox_zoom_wrap" + id + "").remove();
                            }
                        });
                    }
                    else {
                        widthh = $("#box" + id).width();
                        margin_top = -((widthh / (width / height)) - $("#box" + id).height()) / 2;
                        $(".olegfox_zoom" + id + "").animate({
                            "width": widthh,
                            "height": widthh / (width / height),
                            "margin-left": 0,
                            "margin-top": margin_top
                        }, {duration: 500, queue: false, complete: function() {
                                $(".olegfox_zoom_wrap" + id + "").remove();
                            }
                        });
                    }
                }
            });
            $(".olegfox_zoom_wrap" + id + "").animate({
                "top": topp,
                "left": leftt
            }, {duration: 500, queue: false});
            $(".olegfox_zoom_wrap" + id + "").mouseover(function() {
                $(".olegfox_zoom_wrap" + id + "").css({
                    "z-index": 2001
                });
            });
            $(".olegfox_zoom" + id + "").mouseleave(function() {
                $(".olegfox_zoom_wrap" + id + "").css({
                    "z-index": 2001
                });
            });
        });
    }

}

$(function() {
//    $("#container").nanoScroller();
//    $(".pane").show();
//    $(".pane").css({
//        "height": $(".centerLayer").height() - 104
//    });
    $(".box img").css({
        "width": ($('.container-narrow').width() - 40) / 4
    });
    $('img.lazy').load(function() {
        $(".box img").css({
            "width": ($('.container-narrow').width() - 40) / 4
        });
//        $(".nano").nanoScroller({alwaysVisible: true});
//        $(".pane").show();
    });
    $("#c0 img.lazy").lazyload({
        effect: "fadeIn",
        threshold: 100,
        effectspeed: 500,
        failure_limit: 10,
        container: "#column0"
    });
    $("#c1 img.lazy").lazyload({
         effect: "fadeIn",
        threshold: 100,
        effectspeed: 500,
        failure_limit: 10
    });
    $("#c2 img.lazy").lazyload({
        effect: "fadeIn",
        threshold: 100,
        effectspeed: 500,
        failure_limit: 10
    });
    $("#c3 img.lazy").lazyload({
        effect: "fadeIn",
        threshold: 100,
        effectspeed: 500
    });
});
$(window).resize(function() {
    if ($('body').width() <= 1920) {
        $(".box img").css({
            "width": ($('.container-narrow').width() - 40) / 4
        });
//        $(".nano").nanoScroller();
//        $(".pane").css({
//            "height": $(".centerLayer").height() - 104
//        });
    }
});