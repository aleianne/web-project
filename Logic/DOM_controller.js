/**
 * Created by utente pc on 26/08/2017.
 */


/* function to flush the form */
$("#registration-form").click(function (e) {
    e.target.value = "";
});
$("#login-form").click(function (e) {
    e.target.value = "";
});

/* restore the old value */
function restore_old_value() {

    $("#login-form input[name=pwd]").get(0).setAttribute("type", "text");
    $("#registration-form input[name=1-pwd]").get(0).setAttribute("type", "text");
    $("#registration-form input[name=2-pwd]").get(0).setAttribute("type", "text");

    var login_dom_obj = [];
    var reg_dom_obj = [];

    var login_dom_obj = document.getElementById("log-input-box").getElementsByTagName("Input");
    var reg_dom_obj = document.getElementById("reg-input-box").getElementsByTagName("Input");

    for (var i = 0; i < login_dom_obj.length; i++) {
        login_dom_obj[i].value = login_dom_obj[i].defaultValue;
    }

    for (var i = 0; i <reg_dom_obj.length; i++) {
        reg_dom_obj[i].value = reg_dom_obj[i].defaultValue;
    }

    $("#pwd-strength").hide();
    $(".error-box").hide();
}
$(".modalclose").click( function () {
    restore_old_value();
});

/* change the type of the input */
$("#login-form input[name=pwd]").focus(function () {
    this.setAttribute("type", "password");
    this.value = "";
});
$("#registration-form input[name=1-pwd]").focus(function () {
    this.setAttribute("type", "password");
    this.value = "";
});
$("#registration-form input[name=2-pwd]").focus(function () {
    this.setAttribute("type", "password");
    this.value = "";
});


/* check the strength of the password */
$("#registration-form input[name=1-pwd]").keyup(function () {
    var pwd = new password($("#registration-form input[name=1-pwd]").get(0).value);
    var pwd_string = $("#strength-str").get(0);

    switch (pwd.pass_strenght()) {
        case 1: {
            pwd_string.innerHTML = red;
            pwd_string.style.color = "red";
            break;
        }

        case 2: {
            pwd_string.innerHTML = yellow;
            pwd_string.style.color = "goldenrod";
            break;
        }

        case 3: {
            pwd_string.innerHTML = green;
            pwd_string.style.color = "green";
            break;
        }

        default: {
            pwd_string.innerHTML = err;
            pwd_string.style.color = "black";
            break;
        }
    }

    if (!$("#pwd-strength").is(":visible")) {
        $("#pwd-strength").show();
    }
});

/* button for toggling the sidebar*/
$("img#sidebar-icon").click(function (e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});

/* The leanModal library is used to show a popup login or reg form */
$("a[rel*=leanModal]").leanModal({top : 150, overlay : 0.6, closeButton: ".modalclose" });