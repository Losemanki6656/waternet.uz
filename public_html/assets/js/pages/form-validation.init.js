! function () {
    "use strict";
    window.addEventListener("load", function () {
        var e = document.getElementsByClassName("needs-validation");
        Array.prototype.filter.call(e, function (t) {
            t.addEventListener("submit", function (e) {
                !1 === t.checkValidity() && (e.preventDefault(), e.stopPropagation()), t.classList.add("was-validated")
            }, !1)
        })
    }, !1)
}()
