! function (n) {
    "use strict";
    var e, t, a, o = localStorage.getItem("Dason-language"),
        r = "en";

    function d(t) {
        document.getElementById("header-lang-img") && ("en" == t ? document.getElementById("header-lang-img").src = "..//assets/images/flags/us.jpg" : "uz" == t ? document.getElementById("header-lang-img").src = "..//assets/images/flags/uzb.jpg" : "ru" == t && (document.getElementById("header-lang-img").src = "..//assets/images/flags/russia.jpg"))
    }

    function i() {
        var t = document.querySelectorAll(".counter-value");
        t.forEach(function (o) {
            ! function t() {
                var e = +o.getAttribute("data-target"),
                    a = +o.innerText,
                    n = e / 250;
                n < 1 && (n = 1), a < e ? (o.innerText = (a + n).toFixed(0), setTimeout(t, 1)) : o.innerText = e
            }()
        })
    }

    function s() {
        for (var t = document.getElementById("topnav-menu-content").getElementsByTagName("a"), e = 0, a = t.length; e < a; e++) t[e] && t[e].parentElement && "nav-item dropdown active" === t[e].parentElement.getAttribute("class") && (t[e].parentElement.classList.remove("active"), t[e].nextElementSibling && t[e].nextElementSibling.classList.remove("show"))
    }

    function l(t) {

    }

    function c() {
        document.webkitIsFullScreen || document.mozFullScreen || document.msFullscreenElement || n("body").removeClass("fullscreen-enable")
    }
    n("#side-menu").metisMenu(), i(), e = document.body.getAttribute("data-sidebar-size"),
        n("#sidebar-menu a").each(function () {
            var t = window.location.href.split(/[?#]/)[0];
            this.href == t && (n(this).addClass("active"), n(this).parent().addClass("mm-active"), n(this).parent().parent().addClass("mm-show"), n(this).parent().parent().prev().addClass("mm-active"), n(this).parent().parent().parent().addClass("mm-active"), n(this).parent().parent().parent().parent().addClass("mm-show"), n(this).parent().parent().parent().parent().parent().addClass("mm-active"))
        }), n(document).ready(function () {
            var t;
            0 < n("#sidebar-menu").length && 0 < n("#sidebar-menu .mm-active .active").length && (300 < (t = n("#sidebar-menu .mm-active .active").offset().top) && (t -= 300, n(".vertical-menu .simplebar-content-wrapper").animate({
                scrollTop: t
            }, "slow")))
        }), n(".navbar-nav a").each(function () {
            var t = window.location.href.split(/[?#]/)[0];
            this.href == t && (n(this).addClass("active"), n(this).parent().addClass("active"), n(this).parent().parent().addClass("active"), n(this).parent().parent().parent().addClass("active"), n(this).parent().parent().parent().parent().addClass("active"), n(this).parent().parent().parent().parent().parent().addClass("active"), n(this).parent().parent().parent().parent().parent().parent().addClass("active"))
        }), n('[data-toggle="fullscreen"]').on("click", function (t) {
            t.preventDefault(), n("body").toggleClass("fullscreen-enable"), document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement ? document.cancelFullScreen ? document.cancelFullScreen() : document.mozCancelFullScreen ? document.mozCancelFullScreen() : document.webkitCancelFullScreen && document.webkitCancelFullScreen() : document.documentElement.requestFullscreen ? document.documentElement.requestFullscreen() : document.documentElement.mozRequestFullScreen ? document.documentElement.mozRequestFullScreen() : document.documentElement.webkitRequestFullscreen && document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT)
        }), document.addEventListener("fullscreenchange", c), document.addEventListener("webkitfullscreenchange", c), document.addEventListener("mozfullscreenchange", c),
        function () {
            if (document.getElementById("topnav-menu-content")) {
                for (var t = document.getElementById("topnav-menu-content").getElementsByTagName("a"), e = 0, a = t.length; e < a; e++) t[e].onclick = function (t) {
                    t && t.target && "#" === t.target.getAttribute("href") && (t.target.parentElement.classList.toggle("active"), t.target.nextElementSibling && t.target.nextElementSibling.classList.toggle("show"))
                };
                window.addEventListener("resize", s)
            }
        }(), [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).map(function (t) {
            return new bootstrap.Tooltip(t)
        }), [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]')).map(function (t) {
            return new bootstrap.Popover(t)
        }), [].slice.call(document.querySelectorAll(".toast")).map(function (t) {
            return new bootstrap.Toast(t)
        }), window.sessionStorage && ((t = sessionStorage.getItem("is_visited")) ? n("#" + t).prop("checked", !0) : sessionStorage.setItem("is_visited", "layout-ltr")), n("#password-addon").on("click", function () {
            0 < n(this).siblings("input").length && ("password" == n(this).siblings("input").attr("type") ? n(this).siblings("input").attr("type", "input") : n(this).siblings("input").attr("type", "password"))
        }), o && "null" != o && o !== r && d(o), n(".language").on("click", function (t) {
            d(n(this).attr("data-lang"))
        }), feather.replace(), n(window).on("load", function () {
            n("#status").fadeOut(), n("#preloader").delay(350).fadeOut("slow")
        }), a = document.getElementsByTagName("body")[0], n(".right-bar-toggle").on("click", function (t) {
            n("body").toggleClass("right-bar-enabled")
        }), n("input[name='layout-direction']").on("change", function () {
            "ltr" == n(this).val() ? (document.getElementsByTagName("html")[0].removeAttribute("dir"), document.getElementById("bootstrap-style").setAttribute("href", "assets/css/bootstrap.min.css"), document.getElementById("app-style").setAttribute("href", "assets/css/app.min.css")) : (document.getElementById("bootstrap-style").setAttribute("href", "assets/css/bootstrap-rtl.min.css"), document.getElementById("app-style").setAttribute("href", "assets/css/app-rtl.min.css"), document.getElementsByTagName("html")[0].setAttribute("dir", "rtl"))
        }), Waves.init(), n("#checkAll").on("change", function () {
            n(".table-check .form-check-input").prop("checked", n(this).prop("checked"))
        }), n(".table-check .form-check-input").change(function () {
            n(".table-check .form-check-input:checked").length == n(".table-check .form-check-input").length ? n("#checkAll").prop("checked", !0) : n("#checkAll").prop("checked", !1)
        })
}(jQuery);
