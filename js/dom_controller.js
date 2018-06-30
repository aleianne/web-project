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

function addOptionToSelect(departureSelect, arrivalSelect) {

    var page_url = "./model/retrieve_route.php";

    $.ajax({
        url: page_url,
        type: "post",
        dataType: "json",
        success: function (response, status, xhr) {

            console.log(response);

            $.each(response, function (i, item) {
                departureSelect.append($('<option>', {
                    value: i,
                    text: item
                }));
            });

            $.each(response, function (i, item) {
                arrivalSelect.append($('<option>', {
                    value: i,
                    text: item
                }));
            });
        },
        error: function (xhr, status, err) {
            window.alert("error");
        }
    });
}


function showBox(boxElement) {
    if (!boxElement.is(":visible"))
        boxElement.show();
}

function hideBox(boxElement) {
    if (!boxElement.is(":hidden"))
        boxElement.hide();
}