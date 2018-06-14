/**
 * Created by utente pc on 27/08/2017.
 */

$("#sidebar-icon").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});

/* when the page is ready set the username used for the login */
$(document).ready(function() {

    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }


    var value = getCookie("user_cookie");
    $("#username-box").val(value);
});

/* use the leanModal library to popup the login or reg form */
$("a[rel*=leanModal]").leanModal({top : 150, overlay : 0.6, closeButton: ".modalclose" });

/* change the type of the input */
$("#login-form input[name=pwd]").focus(function () {
    this.setAttribute("type", "Password");
    this.value = "";
});
