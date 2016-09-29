$(document).ready(function() {
    $('.b-bkg-slideshow').each(function(element) {
        var slideshow = $(this);
        var slides = $(slideshow).find('.b-bkg-slideshow-item');
        var pattern = $(slideshow).find('.b-bkg-slideshow-fx')[0];
        var buttons = $(slideshow).find('.b-bkg-slideshow-buttons-item');

        var period = 5000;
        var duration = 1500;

        var timer = false;
        var activeSlide = 0;
        var maxSlide = slides.length - 1;
        var animating = false;

        var Opera = /opera/i.test(navigator.userAgent);
        var MSIE = /*@cc_on!@*/0;

        var minZIndex = 1;
        $(slides).each(function(slide) {
            $($(slides)[slide]).css({
                'z-index': minZIndex++
            });
        });

        minZIndex += 2;
        $(pattern).css({
            'z-index': minZIndex
        });


        if (Opera || MSIE)
        {
            $($(slides)[0]).animate({
                'opacity': '1.0'
            }, duration, function() {
            });
        }
        else
        {
            $($(slides)[0]).addClass('changeSlide');
        }

        function worker() {
            nextSlide();

            timer = setTimeout(worker, period);
        }

        $($(buttons)[0]).addClass('b-bkg-slideshow-buttons-item-active');

        timer = setTimeout(worker, period);

        $($(buttons)[0]).parent('.b-bkg-slideshow-buttons').css({
            'z-index': (minZIndex + 1)
        });

        $(buttons).each(function(button_index) {
            $(this).live('click', function() {
                showSlide(button_index, true);
            });
        });

        function showSlide(id, clearThis) {
            if (activeSlide === id)
                return;

            if (Opera || MSIE)
            {
                $(buttons).removeClass('b-bkg-slideshow-buttons-item-active');
                $($(buttons)[id]).addClass('b-bkg-slideshow-buttons-item-active');

                if (clearThis)
                {
                    clearInterval(timer);

                    $($(slides)[activeSlide]).stop();
                    $($(slides)[animating]).stop();
                }

                animating = id;
                $($(slides)[id]).css({
                    'opacity': 0,
                    'z-index': (minZIndex - 1)
                }).animate({
                    'opacity': 1
                }, duration + 1000, function() {
                });

                if (activeSlide !== false)
                {
                    $($(slides)[activeSlide]).css('z-index', (minZIndex - 2));
                }

                var minCurZIndex = 1;
                $(slides).each(function(slide) {
                    if (slide != id && slide != activeSlide)
                    {
                        $($(slides)[slide]).css({
                            'z-index': minCurZIndex++
                        });
                    }
                    else
                    {
                        minCurZIndex++;
                    }
                });

                activeSlide = id;

                if (clearThis)
                {
                    timer = setTimeout(worker, period);
                }
            }
            else
            {
                $(buttons).removeClass('b-bkg-slideshow-buttons-item-active');
                $($(buttons)[id]).addClass('b-bkg-slideshow-buttons-item-active');

                if (clearThis)
                {
                    clearInterval(timer);

                    $($(slides)[activeSlide]).stop();
                    $($(slides)[animating]).stop();
                }

                animating = id;
                $($(slides)[id]).css({
                    'opacity': 0,
                    'z-index': (minZIndex - 1)
                }).addClass('changeSlide');

                if (activeSlide !== false)
                {
                    $($(slides)[activeSlide]).css('z-index', (minZIndex - 2));
                }

                var minCurZIndex = 1;
                $(slides).each(function(slide) {
                    if (slide != id && slide != activeSlide)
                    {
                        $($(slides)[slide]).css({
                            'z-index': minCurZIndex++
                        }).removeClass('changeSlide');
                    }
                    else
                    {
                        minCurZIndex++;
                    }
                });

                activeSlide = id;

                if (clearThis)
                {
                    timer = setTimeout(worker, period);
                }
            }
        }

        function nextSlide() {
            showSlide((activeSlide === maxSlide) ? 0 : (activeSlide + 1));
        }
    });
});