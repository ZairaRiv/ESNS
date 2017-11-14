var Url = function() {
        "use strict";
        var a = {
                protocol: "protocol",
                host: "hostname",
                port: "port",
                path: "pathname",
                query: "search",
                hash: "hash"
            },
            b = {
                ftp: 21,
                gopher: 70,
                http: 80,
                https: 443,
                ws: 80,
                wss: 443
            },
            c = function(c, d) {
                var f = document,
                    g = f.createElement("a"),
                    d = d || f.location.href,
                    h = d.match(/\/\/(.*?)(?::(.*?))?@/) || [];
                g.href = d;
                for (var i in a) c[i] = g[a[i]] || "";
                if (c.protocol = c.protocol.replace(/:$/, ""), c.query = c.query.replace(/^\?/, ""), c.hash = c.hash.replace(/^#/, ""), c.user = h[1] || "", c.pass = h[2] || "", c.port = b[c.protocol] == c.port || 0 == c.port ? "" : c.port, c.protocol || /^([a-z]+:)?\/\//.test(d)) c.path = c.path.replace(/^\/?/, "/");
                else {
                    var j = new Url(f.location.href.match(/(.*\/)/)[0]),
                        k = j.path.split("/"),
                        l = c.path.split("/");
                    k.pop();
                    for (var i = 0, m = ["protocol", "user", "pass", "host", "port"], n = m.length; n > i; i++) c[m[i]] = j[m[i]];
                    for (;
                        ".." == l[0];) k.pop(), l.shift();
                    c.path = ("/" != d.substring(0, 1) ? k.join("/") : "") + "/" + l.join("/")
                }
                e(c)
            },
            d = function(a) {
                return a = a.replace(/\+/g, " "), a = a.replace(/%([ef][0-9a-f])%([89ab][0-9a-f])%([89ab][0-9a-f])/gi, function(a, b, c, d) {
                    var e = parseInt(b, 16) - 224,
                        f = parseInt(c, 16) - 128;
                    if (0 == e && 32 > f) return a;
                    var g = parseInt(d, 16) - 128,
                        h = (e << 12) + (f << 6) + g;
                    return h > 65535 ? a : String.fromCharCode(h)
                }), a = a.replace(/%([cd][0-9a-f])%([89ab][0-9a-f])/gi, function(a, b, c) {
                    var d = parseInt(b, 16) - 192;
                    if (2 > d) return a;
                    var e = parseInt(c, 16) - 128;
                    return String.fromCharCode((d << 6) + e)
                }), a = a.replace(/%([0-7][0-9a-f])/gi, function(a, b) {
                    return String.fromCharCode(parseInt(b, 16))
                })
            },
            e = function(a) {
                var b = a.query;
                a.query = new function(a) {
                    for (var b, c = /([^=&]+)(=([^&]*))?/g; b = c.exec(a);) {
                        var e = decodeURIComponent(b[1].replace(/\+/g, " ")),
                            f = b[3] ? d(b[3]) : "";
                        null != this[e] ? (this[e] instanceof Array || (this[e] = [this[e]]), this[e].push(f)) : this[e] = f
                    }
                    this.clear = function() {
                        for (e in this) this[e] instanceof Function || delete this[e]
                    }, this.toString = function() {
                        var a = "",
                            b = encodeURIComponent;
                        for (var c in this)
                            if (!(this[c] instanceof Function))
                                if (this[c] instanceof Array) {
                                    var d = this[c].length;
                                    if (d)
                                        for (var e = 0; d > e; e++) a += a ? "&" : "", a += b(c) + "=" + b(this[c][e]);
                                    else a += (a ? "&" : "") + b(c) + "="
                                } else a += a ? "&" : "", a += b(c) + "=" + b(this[c]);
                        return a
                    }
                }(b)
            };
        return function(a) {
            this.toString = function() {
                return (this.protocol && this.protocol + "://") + (this.user && this.user + (this.pass && ":" + this.pass) + "@") + (this.host && this.host) + (this.port && ":" + this.port) + (this.path && this.path) + (this.query.toString() && "?" + this.query) + (this.hash && "#" + this.hash)
            }, c(this, a)
        }
    }(),
    krnl = function(a, b) {
        return a.schoolshootings = function(a) {
            function b() {
                a(document).ready(function() {
                    function b(b) {
                        h.addClass("show-info"), h.html(Mustache.render(i, b)), h.on("click", "section", function(a) {
                            a.stopPropagation()
                        }), a("#map-wrap").on("click", k, function(b) {
                            b.preventDefault(), h.removeClass("show-info"), h.html("");
                            var c = m.getSelectedPoints();
                            c.length && a.each(c, function(a) {
                                var b = c[a];
                                b.select(!1)
                            })
                        })
                    }

                    function c(a) {
                        window.location.hash = a.point.postid
                    }

                    function d(b) {
                        "object" == typeof school_shootings[b] && (school_shootings[b].share_vars.s_p_fb_url && a(".share-facebook").each(function() {
                            var c = new Url(a(this).attr("href"));
                            c.query.u = school_shootings[b].share_vars.s_p_fb_url;
                            var d = new Url(c.query.u);
                            d.query.source = d.query.source ? d.query.source : "fbno_schoolshootingsfb", d.query.utm_source = d.query.utm_source ? d.query.utm_source : "fb_n_", d.query.utm_medium = d.query.utm_medium ? d.query.utm_medium : "_o", d.query.utm_campaign = d.query.utm_campaign ? d.query.utm_campaign : "schoolshootingsfb", c.query.u = d, a(this).attr("href", c)
                        }), a(".share-twitter").each(function() {
                            var c = new Url(a(this).attr("href")),
                                d = school_shootings[b].share_vars;
                            if (d.s_p_tw_url) {
                                c.query.url = d.s_p_tw_url;
                                var e = new Url(c.query.url);
                                e.query.source = e.query.source ? e.query.source : "twno_schoolshootingstw", e.query.utm_source = e.query.utm_source ? e.query.utm_source : "tw_n_", e.query.utm_medium = e.query.utm_medium ? e.query.utm_medium : "_o", e.query.utm_campaign = e.query.utm_campaign ? e.query.utm_campaign : "schoolshootingstw", c.query.url = e
                            }
                            d.s_p_tweet && (c.query.text = d.s_p_tweet), d.s_p_hash_tags && (c.query.hashtags = d.s_p_hash_tags), a(this).attr("href", c)
                        }), a(".share-email").each(function() {
                            var c = new Url(a(this).attr("href")),
                                d = school_shootings[b].share_vars;
                            d.s_p_subject && (c.query.subject = d.s_p_subject), d.s_p_body && (c.query.body = d.s_p_body), a(this).attr("href", c)
                        }), a(".input-share-url").each(function() {
                            var c = school_shootings[b].share_vars;
                            c.s_p_cp_url && a(this).val(c.s_p_cp_url)
                        }))
                    }
                    var e = new Url,
                        f = Highcharts,
                        g = f.maps["countries/us/us-all"],
                        h = a("#info"),
                        i = a("#school-shooting-template").html(),
                        j = a(".btn-year:not(:last-child)"),
                        k = a("#info-close"),
                        l = {
                            chart: {
                                animation: !1,
                                margin: 0,
                                backgroundColor: "#1c242d"
                            },
                            credits: {
                                enabled: !1
                            },
                            title: {
                                text: "",
                                style: {
                                    display: "none"
                                }
                            },
                            legend: {
                                enabled: !1
                            },
                            tooltip: {
                                enabled: !1
                            },
                            series: [{
                                name: "Basemap",
                                mapData: g,
                                borderColor: "#1c242d",
                                nullColor: "#334048",
                                showInLegend: !1
                            }]
                        };
                    1 === embed ? (l.tooltip = {
                        useHTML: !0,
                        enabled: !0,
                        formatter: function() {
                            return '<p style="width:250px; white-space:normal;">' + this.point.school_name + "<br>" + this.point.city + ", " + this.point.usstate + ", " + this.point.date + "<br>" + this.point.shooting_category + "</p>"
                        }
                    }, l.subtitle = {
                        useHTML: !0,
                        text: 'View at <a style="color:white; text-decoration:underline;" href="http://everytownresearch.org/school-shootings/2982/?utm_source=allembeds&utm_medium=embed&utm_campaign=schoolshootings" target="_blank">everytownresearch.org</a>',
                        floating: !0,
                        align: "left",
                        x: -10,
                        verticalAlign: "bottom",
                        y: 0,
                        style: {
                            color: "white"
                        }
                    }, l.plotOptions = {
                        series: {
                            events: {
                                click: function(a) {}
                            }
                        }
                    }) : l.plotOptions = {
                        series: {
                            events: {
                                click: function(a) {
                                    c(a)
                                }
                            }
                        }
                    }, a("#map").highcharts("Map", l);
                    var m = a("#map").highcharts(),
                        n = m.addSeries({
                            type: "mappoint",
                            cursor: "pointer",
                            name: "shooting",
                            color: "#ec3029",
                            data: school_shootings,
                            allowPointSelect: !0,
                            marker: {
                                radius: 6,
                                symbol: "circle",
                                lineColor: "#1c242d",
                                lineWidth: "1",
                                states: {
                                    select: {
                                        enabled: !0,
                                        fillColor: "#ffffff",
                                        radius: 8,
                                        lineWidth: "1"
                                    },
                                    hover: {
                                        enabled: !1
                                    }
                                }
                            }
                        });
                    if (j.click(function() {
                            var b = m.getSelectedPoints();
                            b.length && a.each(b, function(a) {
                                var c = b[a];
                                c.select(!1)
                            });
                            var c, d = [],
                                e = a(this).data("year"),
                                f = e.toString();
                            if (a("button[data-year]").removeClass("active"), a('button[data-year="' + e + '"]').addClass("active"), a("#school-shootings-table tr[data-year]").hide(), "all" === e) n.setData(school_shootings), a("#school-shootings-table [data-year]").show();
                            else {
                                for (c = 0; c < school_shootings.length; c++) school_shootings[c].year === f && d.push(school_shootings[c]);
                                n.setData(d), a('#school-shootings-table [data-year="' + e + '"]').show()
                            }
                            a(window).trigger("resize")
                        }), 0 === embed) {
                        b(school_shootings[0]), d(0), m.series[1].data[0].select();
                        var o = e.path.split("/");
                        if ("" !== o[2]) {
                            var p = postidmap[o[2]];
                            school_shootings[p] && (b(school_shootings[p]), d(p), m.series[1].data[p].select())
                        }
                        school_shootings[postidmap[e.hash]] && (window.location = "/" + o[1] + "/" + e.hash);
                        var q = window.location.hash;
                        if (q) {
                            var r = q.substr(1),
                                s = postidmap[r];
                            school_shootings[s] && (b(school_shootings[s]), d(s), m.series[1].data[s].select())
                        }
                        a(window).hashchange(function() {
                            var a = location.hash.substr(1),
                                c = postidmap[a];
                            school_shootings[c] && (b(school_shootings[c]), d(c))
                        })
                    }
                })
            }
            return {
                init: b
            }
        }(b), a
    }(krnl || {}, jQuery);
krnl.schoolshootings.init();