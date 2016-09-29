/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(window).load(function() {
  $('.flexslider').flexslider({
    animation: "slide"
  });
});
$(window).resize(function(){
    bottom = ($(window).height() - 336 - 60)/7;
    if(bottom > 40) bottom = 40;
    $(".list-menu div").css({
        "padding-bottom" : bottom
    });    
    top_ = ($(window).height() - $(".list-menu").height())/2;
    if(top_ < 60) top_ = 60;
    $(".list-menu").css({
        "height" : "auto",
        "min-height" : "336px",
        "top" : top_
    }); 
});
$(function() {
    bottom = ($(window).height() - 336 - 60)/7;
    if(bottom > 40) bottom = 40;
    $(".list-menu div").css({
        "padding-bottom" : bottom
    });    
    top_ = ($(window).height() - $(".list-menu").height())/2;
    if(top_ < 60) top_ = 60;
    $(".list-menu").css({
        "height" : "auto",
        "min-height" : "336px",
        "top" : top_
    });  
//    $.vegas('slideshow', {
//        backgrounds: [
//            {src: './img/background1.jpg', fade:1000},
//            {src: './img/background2.jpg', fade:1000},
//            {src: './img/background3.jpg', fade:1000},
//            {src: './img/background4.jpg', fade:1000},
//            {src: './img/background5.jpg', fade:1000},
//            {src: './img/background6.jpg', fade:1000},
//        ]
//    })('overlay');
});

