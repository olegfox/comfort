(function() {
    var c = jQuery.event.special,
        i = "D" + +new Date,
        f = "D" + (+new Date + 1);
    c.scrollstart = {
        setup: function() {
            var d, a = function(a) {
                var g = arguments;
                d ? clearTimeout(d) : (a.type = "scrollstart", jQuery.event.handle.apply(this, g));
                d = setTimeout(function() {
                    d = null
                }, c.scrollstop.latency)
            };
            jQuery(this).bind("scroll", a).data(i, a)
        },
        teardown: function() {
            jQuery(this).unbind("scroll", jQuery(this).data(i))
        }
    };
    c.scrollstop = {
        latency: 300,
        setup: function() {
            var d, a = function(a) {
                var g = this,
                    e = arguments;
                d && clearTimeout(d);
                d = setTimeout(function() {
                    d =
                    null;
                    a.type = "scrollstop";
                    jQuery.event.handle.apply(g, e)
                }, c.scrollstop.latency)
            };
            jQuery(this).bind("scroll", a).data(f, a)
        },
        teardown: function() {
            jQuery(this).unbind("scroll", jQuery(this).data(f))
        }
    }
})();
(function(c) {
    function i(d) {
        d.type = "userstartscroll";
        return c.event.handle.call(this, d)
    }
    c.fn.userstartscroll = function(c) {
        return this[c ? "bind" : "trigger"]("userstartscroll", c)
    };
    c.event.special.userstartscroll = {
        setup: function() {
            c.event.add(this, f, i, {})
        },
        teardown: function() {
            c.event.remove(this, f, i)
        }
    };
    var f = !c.browser.mozilla ? "mousewheel" : "DOMMouseScroll" + (c.browser.version < "1.9" ? " mousemove" : "")
})(jQuery);
(function(c) {
    c.fn.drag = function(a, b, d) {
        var e = typeof a == "string" ? a : "",
            j = c.isFunction(a) ? a : c.isFunction(b) ? b : null;
        e.indexOf("drag") !== 0 && (e = "drag" + e);
        d = (a == j ? b : d) || {};
        return j ? this.bind(e, d, j) : this.trigger(e)
    };
    var i = c.event,
        f = i.special,
        d = f.drag = {
            defaults: {
                which: 1,
                distance: 0,
                not: ":input",
                handle: null,
                relative: !1,
                drop: !0,
                click: !1
            },
            datakey: "dragdata",
            livekey: "livedrag",
            add: function(a) {
                var b = c.data(this, d.datakey),
                    g = a.data || {};
                b.related += 1;
                if (!b.live && a.selector) b.live = !0, i.add(this, "draginit." + d.livekey, d.delegate);
                c.each(d.defaults, function(a) {
                    g[a] !== void 0 && (b[a] = g[a])
                })
            },
            remove: function() {
                c.data(this, d.datakey).related -= 1
            },
            setup: function() {
                if (!c.data(this, d.datakey)) {
                    var a = c.extend({
                        related: 0
                    }, d.defaults);
                    c.data(this, d.datakey, a);
                    i.add(this, "mousedown", d.init, a);
                    this.attachEvent && this.attachEvent("ondragstart", d.dontstart)
                }
            },
            teardown: function() {
                c.data(this, d.datakey).related || (c.removeData(this, d.datakey), i.remove(this, "mousedown", d.init), i.remove(this, "draginit", d.delegate), d.textselect(!0), this.detachEvent && this.detachEvent("ondragstart", d.dontstart))
            },
            init: function(a) {
                var b = a.data,
                    g;
                if (!(b.which > 0 && a.which != b.which) && !c(a.target).is(b.not) && (!b.handle || c(a.target).closest(b.handle, a.currentTarget).length)) if (b.propagates = 1, b.interactions = [d.interaction(this, b)], b.target = a.target, b.pageX = a.pageX, b.pageY = a.pageY, b.dragging = null, g = d.hijack(a, "draginit", b), b.propagates) {
                    if ((g = d.flatten(g)) && g.length) b.interactions = [], c.each(g, function() {
                        b.interactions.push(d.interaction(this, b))
                    });
                    b.propagates =
                    b.interactions.length;
                    b.drop !== !1 && f.drop && f.drop.handler(a, b);
                    d.textselect(!1);
                    i.add(document, "mousemove mouseup", d.handler, b);
                    return !1
                }
            },
            interaction: function(a, b) {
                return {
                    drag: a,
                    callback: new d.callback,
                    droppable: [],
                    offset: c(a)[b.relative ? "position" : "offset"]() || {
                        top: 0,
                        left: 0
                    }
                }
            },
            handler: function(a) {
                var b = a.data;
                switch (a.type) {
                case !b.dragging && "mousemove":
                    if (Math.pow(a.pageX - b.pageX, 2) + Math.pow(a.pageY - b.pageY, 2) < Math.pow(b.distance, 2)) break;
                    a.target = b.target;
                    d.hijack(a, "dragstart", b);
                    if (b.propagates) b.dragging = !0;
                case "mousemove":
                    if (b.dragging) {
                        d.hijack(a, "drag", b);
                        if (b.propagates) {
                            b.drop !== !1 && f.drop && f.drop.handler(a, b);
                            break
                        }
                        a.type = "mouseup"
                    }
                case "mouseup":
                    if (i.remove(document, "mousemove mouseup", d.handler), b.dragging && (b.drop !== !1 && f.drop && f.drop.handler(a, b), d.hijack(a, "dragend", b)), d.textselect(!0), b.click === !1 && b.dragging) jQuery.event.triggered = !0, setTimeout(function() {
                        jQuery.event.triggered = !1
                    }, 20), b.dragging = !1
                }
            },
            delegate: function(a) {
                var b = [],
                    g, e = c.data(this, "events") || {};
                c.each(e.live || [], function(j, h) {
                    if (h.preType.indexOf("drag") === 0 && (g = c(a.target).closest(h.selector, a.currentTarget)[0])) i.add(g, h.origType + "." + d.livekey, h.origHandler, h.data), c.inArray(g, b) < 0 && b.push(g)
                });
                return !b.length ? !1 : c(b).bind("dragend." + d.livekey, function() {
                    i.remove(this, "." + d.livekey)
                })
            },
            hijack: function(a, b, g, e, j) {
                if (g) {
                    var h = a.originalEvent,
                        s = a.type,
                        p = b.indexOf("drop") ? "drag" : "drop",
                        k, m = e || 0,
                        l, f, e = !isNaN(e) ? e : g.interactions.length;
                    a.type = b;
                    a.originalEvent = null;
                    g.results = [];
                    do
                    if ((l = g.interactions[m]) && !(b !== "dragend" && l.cancelled)) {
                        f = d.properties(a, g, l);
                        l.results = [];
                        c(j || l[p] || g.droppable).each(function(j, h) {
                            k = (f.target = h) ? i.handle.call(h, a, f) : null;
                            if (k === !1) {
                                if (p == "drag") l.cancelled = !0, g.propagates -= 1;
                                b == "drop" && (l[p][j] = null)
                            } else b == "dropinit" && l.droppable.push(d.element(k) || h);
                            if (b == "dragstart") l.proxy = c(d.element(k) || l.drag)[0];
                            l.results.push(k);
                            delete a.result;
                            if (b !== "dropinit") return k
                        });
                        g.results[m] = d.flatten(l.results);
                        if (b == "dropinit") l.droppable = d.flatten(l.droppable);
                        b == "dragstart" && !l.cancelled && f.update()
                    }
                    while (++m < e);
                    a.type = s;
                    a.originalEvent = h;
                    return d.flatten(g.results)
                }
            },
            properties: function(a, b, c) {
                var e = c.callback;
                e.drag = c.drag;
                e.proxy = c.proxy || c.drag;
                e.startX = b.pageX;
                e.startY = b.pageY;
                e.deltaX = a.pageX - b.pageX;
                e.deltaY = a.pageY - b.pageY;
                e.originalX = c.offset.left;
                e.originalY = c.offset.top;
                e.offsetX = a.pageX - (b.pageX - e.originalX);
                e.offsetY = a.pageY - (b.pageY - e.originalY);
                e.drop = d.flatten((c.drop || []).slice());
                e.available = d.flatten((c.droppable || []).slice());
                return e
            },
            element: function(a) {
                if (a && (a.jquery || a.nodeType == 1)) return a
            },
            flatten: function(a) {
                return c.map(a, function(a) {
                    return a && a.jquery ? c.makeArray(a) : a && a.length ? d.flatten(a) : a
                })
            },
            textselect: function(a) {
                c(document)[a ? "unbind" : "bind"]("selectstart", d.dontstart).attr("unselectable", a ? "off" : "on").css("MozUserSelect", a ? "" : "none")
            },
            dontstart: function() {
                return !1
            },
            callback: function() {}
        };
    d.callback.prototype = {
        update: function() {
            f.drop && this.available.length && c.each(this.available, function(a) {
                f.drop.locate(this, a)
            })
        }
    };
    f.draginit = f.dragstart = f.dragend = d
})(jQuery);
(function(c, i, f) {
    function d(a, b, d) {
        var e = d.type;
        d.type = b;
        c.event.handle.call(a, d);
        d.type = e
    }
    c.each("touchstart touchmove touchend orientationchange throttledresize tap taphold swipe swipeleft swiperight".split(" "), function(a, b) {
        c.fn[b] = function(a) {
            return a ? this.bind(b, a) : this.trigger(b)
        };
        c.attrFn[b] = !0
    });
    var a = "ontouchstart" in i,
        b = a ? "touchstart" : "mousedown",
        g = a ? "touchend" : "mouseup",
        e = a ? "touchmove" : "mousemove";
    c.event.special.tap = {
        setup: function() {
            var a = this,
                h = c(a);
            h.bind(b, function(c) {
                var b = c.originalEvent.touches;
                if (b && b.length === 1) {
                    var k = !0,
                        f = !1,
                        l = b[0].pageX,
                        i = b[0].pageY,
                        t, n = function() {
                            k = !1;
                            clearTimeout(t);
                            h.unbind(g, q).unbind("touchcancel", n)
                        },
                        q = function(c) {
                            n();
                            f || d(a, "tap", c)
                        };
                    h.bind(e, function(a) {
                        a = a.originalEvent.touches[0];
                        f = f || Math.abs(a.pageX - l) > 10 || Math.abs(a.pageY - i) > 10
                    }).bind("touchcancel", n).bind(g, q);
                    t = setTimeout(function() {
                        k && d(a, "taphold", c)
                    }, 750)
                }
            })
        }
    };
    c.event.special.swipe = {
        scrollSupressionThreshold: 10,
        durationThreshold: 1E3,
        horizontalDistanceThreshold: 30,
        verticalDistanceThreshold: 75,
        setup: function() {
            var a =
            c(this);
            a.bind(b, function(b) {
                function d(a) {
                    if (k) {
                        var b = a.originalEvent.touches ? a.originalEvent.touches[0] : a;
                        m = {
                            time: (new Date).getTime(),
                            coords: [b.pageX, b.pageY]
                        };
                        Math.abs(k.coords[0] - m.coords[0]) > c.event.special.swipe.scrollSupressionThreshold && a.preventDefault()
                    }
                }
                var i = b.originalEvent.touches ? b.originalEvent.touches[0] : b,
                    k = {
                        time: (new Date).getTime(),
                        coords: [i.pageX, i.pageY],
                        origin: c(b.target)
                    },
                    m;
                a.bind(e, d).one(g, function() {
                    a.unbind(e, d);
                    k && m && m.time - k.time < c.event.special.swipe.durationThreshold && Math.abs(k.coords[0] - m.coords[0]) > c.event.special.swipe.horizontalDistanceThreshold && Math.abs(k.coords[1] - m.coords[1]) < c.event.special.swipe.verticalDistanceThreshold && k.origin.trigger("swipe").trigger(k.coords[0] > m.coords[0] ? "swipeleft" : "swiperight");
                    k = m = f
                })
            })
        }
    };
    (function(a, b) {
        function c() {
            var a = e();
            a !== g && (g = a, d.trigger("orientationchange"))
        }
        var d = a(b),
            e, g;
        a.event.special.orientationchange = {
            setup: function() {
                if (a.support.orientation) return !1;
                g = e();
                d.bind("throttledresize", c)
            },
            teardown: function() {
                if (a.support.orientation) return !1;
                d.unbind("throttledresize", c)
            },
            add: function(a) {
                var b = a.handler;
                a.handler = function(a) {
                    a.orientation = e();
                    return b.apply(this, arguments)
                }
            }
        };
        a.event.special.orientationchange.orientation = e = function() {
            var a = document.documentElement;
            return a && a.clientWidth / a.clientHeight < 1.1 ? "portrait" : "landscape"
        }
    })(jQuery, i);
    (function() {
        c.event.special.throttledresize = {
            setup: function() {
                c(this).bind("resize", a)
            },
            teardown: function() {
                c(this).unbind("resize", a)
            }
        };
        var a = function() {
            e = (new Date).getTime();
            g = e - b;
            g >= 250 ? (b = e, c(this).trigger("throttledresize")) : (d && clearTimeout(d), d = setTimeout(a, 250 - g))
        },
            b = 0,
            d, e, g
    })();
    c.each({
        taphold: "tap",
        swipeleft: "swipe",
        swiperight: "swipe"
    }, function(a, b) {
        c.event.special[a] = {
            setup: function() {
                c(this).bind(b, c.noop)
            }
        }
    })
})(jQuery, this);
(function(c) {
    c.fn.extend({
        scrollboard: function(i) {
            var f = {
                page_min_gap: 80,
                page_max_gap: 200,
                navigation: !0,
                captions: !0,
                thumbnails: !0
            };
            return this.each(function() {
                var d = c.extend(f, i),
                    a = c(this),
                    b, g, e, j = 0,
                    h = c("div.page", a),
                    s = c("#full-view-holder"),
                    p = c("#loader"),
                    k = [],
                    m, l, u, t, n = !1,
                    q = new Image,
                    w = !1,
                    r, x = "ontouchstart" in window,
                    y = function() {
                        b = a.width() / 2;
                        m = b <= 480 ? d.page_min_gap : b >= 840 ? d.page_max_gap : (a.width() - 960) * (d.page_max_gap - d.page_min_gap) / 720 + d.page_min_gap;
                        e = g = c("div.pages", a).height();
                        l = Math.floor(e * 0.6);
                        r = 0;
                        h.each(function(d) {
                            var f = c(this),
                                D = h.eq(d).data("img");
                            k[d] = b + (e + m) * d;
                            f.css({
                                width: e,
                                height: g,
                                left: k[d] - e / 2
                            });
                            d != j && D.css({
                                width: e,
                                height: g
                            });
                            d == h.length - 1 && f.css("paddingRight", (a.width() - e) / 2)
                        });
                        a.scrollLeft((e + m) * j);
                        if (d.thumbnails) {
                            var f = e / t - 2;
                            u.css({
                                width: f,
                                height: f
                            })
                        }
                    },
                    o = function(b, c) {
                        if (!document.getElementById("page-" + b) && !document.getElementsByName("page-" + b)[0]) return !1;
                        a.animate({
                            scrollLeft: (e + m) * b
                        }, c)
                    },
                    z = function(b) {
                        a.stop();
                        var d = c(b).data("page_id");
                        if (d == j && d != n) if ((b = c(b).data("img")) && !w) E(d, parseInt(b.attr("id").split("-")[1]));
                        else return !1;
                        else o(d, 1E3)
                    },
                    A = function() {
                        a.stop();
                        j != h.length - 1 && (j = j < h.length - 2 ? j + 1 : h.length - 1, o(j, 600))
                    },
                    B = function() {
                        a.stop();
                        j != 0 && (j = j > 1 ? j - 1 : 0, o(j, 600))
                    },
                    E = function(d, g) {
                        var f = !1;
                        n = d;
                        r = b - e / 2 - m + 5;
                        h.eq(d).fadeOut(500);
                        v.fadeOut(500);
                        h.eq(d - 1).animate({
                            left: "-=" + r
                        }, 500);
                        h.eq(d + 1).animate({
                            left: "+=" + r
                        }, 500);
                        q.src = "/media/pictures/image_" + g + ".jpeg";
                        setTimeout(function() {
                            f || p.fadeIn(300)
                        }, 500);
                        q.onload = function() {
                            var d = b - this.width / 2,
                                e = (a.height() - this.height) / 2;
                            f = !0;
                            p.fadeOut(200);
                            $(".sh").fadeOut(200);
                            s.css({
                                backgroundImage: "url('" + this.src + "')",
                                backgroundPosition: d + "px " + e + "px"
                            }).fadeIn(500, function() {
                                var b = x ? "tap" : "click";
                                c(document).drag("start", function() {
                                    c(document).unbind(b)
                                }).drag(function(a, b) {
                                    s.css("backgroundPosition", d + b.deltaX + "px " + (e + b.deltaY) + "px")
                                }).drag("end", function(g, f) {
                                    d += f.deltaX;
                                    e += f.deltaY;
                                    setTimeout(function() {
                                        c(document).bind(b, function() {
                                            a.scroll()
                                        })
                                    }, 100)
                                }).bind(b, function() {
                                    a.scroll()
                                })
                            })
                        }
                    },
                    C = function(a, b) {
                        var f = h.eq(a),
                            j = f.data("img");
                        if (j) {
                            var i = (l - b) * 0.1;
                            j.css({
                                top: -i / 2,
                                left: -i / 2,
                                width: e + i,
                                height: g + i
                            });
                            (f = f.data("caption")) && d.captions && f.css({
                                opacity: (l - b) / 100
                            })
                        }
                        if (n != !1) c(document).unbind(), q.src = "", p.fadeOut(100), s.fadeOut(500, function() {
                        	$(".sh").fadeIn(500);
                            c(this).css("backgroundImage", "url('')")
                        }), h.eq(n).fadeIn(500), v.fadeIn(500), h.eq(n - 1).animate({
                            left: "+=" + r
                        }, 500), h.eq(n + 1).animate({
                            left: "-=" + r
                        }, 500), n = !1
                    };
                a.css({});
                a.scroll(function() {
                    for (var c = a.scrollLeft() + b, e, f = null, g = null, h = k.length, i = 0; i < h; i++) if (f = Math.abs(k[i] - c), f <= g || g == null) g = f, e = i;
                    else break;
                    g >= 0 && g <= l && (e != j && C(j, l), j = e, C(e, g), d.navigation && v.removeClass("current").eq(j).addClass("current"))
                });
                a.bind("scrollstart", function() {
                    w = !0
                });
                a.bind("scrollstop", function() {
                    w = !1;
                    o(j, 500)
                });
                a.bind("userstartscroll", function() {
                    a.stop()
                });
                h.each(function(a) {
                    var b = c(this),
                        e = b.children(".img-holder") || !1,
                        g = b.children(".caption") || !1;
                    if (e) {
                        var f = e.children("img");
                        f.width > f.height ? c(f).addClass("horizontal") : c(f).addClass("vertical");
                        b.data({
                            img: e,
                            caption: g,
                            page_id: a
                        })
                    }
                    if (a == h.length - 1 && d.thumbnails) u = c("ul > li", b), a = u.length, t = a > 16 ? 5 : a > 9 ? 4 : a > 4 ? 3 : a > 2 ? 2 : 1, c("ul > li > a", b).click(function() {
                        o(parseInt(this.hash.split("-")[1]), 600);
                        return !1
                    }), u.hover(function() {
                        c(this).find("a > img").animate({
                            top: "3%",
                            left: "3%",
                            width: "94%",
                            height: "94%"
                        }, 200)
                    }, function() {
                        c(this).find("a > img").animate({
                            top: "0",
                            left: "0",
                            width: "100%",
                            height: "100%"
                        }, 100)
                    })
                });
                if (d.navigation) {
                    var v = c(".navigation li a");
                    v.click(function() {
                        o(parseInt(this.hash.split("-")[1]), 600);
                        return !1
                    })
                }
                c(window).resize(y);
                $(function(){y();});
                c(window).keydown(function(b) {
                    switch (b.keyCode) {
                    case 33:
                    case 37:
                    case 38:
                        B();
                        break;
                    case 32:
                        h.eq(j).click();
                        break;
                    case 34:
                    case 39:
                    case 40:
                        A();
                        break;
                    case 36:
                        a.stop();
                        j != 0 && o(0, 600);
                        break;
                    case 35:
                        a.stop(), j != h.length - 1 && o(h.length - 1, 600)
                    }
                });
                x ? (a.bind("swipeleft", function() {
                    A()
                }).bind("swiperight", function() {
                    B()
                }), h.bind("tap", function() {
                    z(this)
                })) : h.bind("click", function() {
                    z(this)
                });
                y();
                a.scroll()
            })
        }
    })
})(jQuery);
$(function() {
    $("#scrollboard").scrollboard();
});
