/* function to flush the form */
// $("#registration-form").click(function (e) {
//     e.target.value = "";
// });
// $("#login-form").click(function (e) {
//     e.target.value = "";
// });

/* restore the old value */
function restoreOldValues() {

    // $("#login-form").find("input[name='password']").get(0).setAttribute("type", "text");
    // $("#registration-form").find("input[name='first-password']").get(0).setAttribute("type", "text");
    // $("#registration-form").find("input[name='second-password']").get(0).setAttribute("type", "text");

    // var login_dom_obj = document.getElementById("login-input-box").getElementsByTagName("Input");
    // var reg_dom_obj = document.getElementById("registration-input-box").getElementsByTagName("Input");
    //
    // for (var i = 0; i < login_dom_obj.length; i++)
    //     login_dom_obj[i].value = login_dom_obj[i].defaultValue;
    //
    // for (var i = 0; i <reg_dom_obj.length; i++)
    //     reg_dom_obj[i].value = reg_dom_obj[i].defaultValue;

    $("#login-input-box").find("input").each(function() {
       var inputElement = $(this);
       inputElement.val("");
    });

    $("#registration-input-box").find("input").each(function() {
        var inputElement = $(this);
        inputElement.val("");
    })

    $("#password-strength-box").hide();
    $(".error-box").hide();
}

$(".modalclose").click( function () {
    restoreOldValues();
});


function showBox(box_name) {
    if (!$(box_name).is(":visible"))
        $(box_name).show();
}

function hideBox(box_name) {
    if (!$(box_name).is(":hidden"))
        $(box_name).hide();
}