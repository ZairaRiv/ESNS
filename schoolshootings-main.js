var krnl = function(a, b) {
    return a.schoolshootings_main = function(a) {
        function b() {
            var b = c();
            a("#embed-text").attr("value", ' <iframe src="' + b + '/school-shootings-map-embed/" width="100%" height="600" frameborder="0"></iframe>'), a("#embed-toggle").click(function() {
                "none" === a("#embed").css("display") ? (a("#embed").show("slow"), a("#embed-text").select()) : a("#embed").hide("slow")
            })
        }

        function c() {
            var a = window.location;
            return a.protocol + "//" + a.hostname
        }
        return {
            init: b
        }
    }(b), a
}(krnl || {}, jQuery);
krnl.schoolshootings_main.init();