/**
 * Created by utente pc on 24/08/2017.
 */


function UrlCreator(key, value) {
    this.url = String(key + "=" + value);
}

UrlCreator.prototype.append = function (key, value) {
    var string = String("&" + key + "=" + value);
    this.url = this.url + string;
}

UrlCreator.prototype.getUrl = function() {
    return this.url;
}

function reserveSeats() {

    var page_url = "./model/booking_request.php";

    var departure_address = getDepartureFormData();
    var arrival_address = getArrivalFormData();
    var departure_first = getDepartureRadio();
    var arrival_first = getArrivalFormData();
    var seats_number = $("#seats-number").val();

    var url = new UrlCreator("dep_address", departure_address);
    url.append("arr_address", arrival_address);
    url.append("dep_exists", departure_first);
    url.append("arr_exists", arrival_first);
    url.append("seats_number", seats_number);

    //var post_data = $("#purchase-form").find("select").serialize();
    $.ajax({
        url: page_url,
        type: "post",
        data_type: "string",
        data: url.getUrl(),
        success: function(response, status, xhr) {
            switch(response) {
                case "err_1":
                    window.confirm("Error: DB returned an error")
                    break;
                case "err_2":
                    window.confirm("Error: is not possible to booking the journey")
                    break;
                case "err_3":
                    /* trigger the login form */
                    $(".modalclose").trigger("click");
                    $("#login-trigger").trigger("click");
                    break;
                case "err_4":
                    window.confirm("Error: there is a problem with the session");
                    break;
                case "ok":
                    window.confirm("seats reserved correctly!");
                    $(".modalclose").trigger("click");
                    $("#list-div").load("./model/user_home_page.php #list-div");
                    break;
                default:
                    //
            }
        },
        error: function(xhr, status, error) {
            window.confirm("Error: there is a network problem "+ error);
        }
    });
};


function getDepartureFormData() {
    var departureForm = $("#departure-form");

    var radio1 = departureForm.find("#departure-1");
    var radio2 = departureForm.find("#departure-2");

    if (radio1.is(":checked") && !radio2.is(":checked")) {
        return departureForm.find("#departure-select option:selected").text();
    } else if (!radio1.is(":checked") && radio2.is(":checked")) {
        return departureForm.find("#departure-box").val();
    } else {
        // TODO error
    }
}

function getArrivalFormData() {
    var arrivalForm = $("#arrival-form");

    var radio1 = arrivalForm.find("#arrival-1");
    var radio2 = arrivalForm.find("#arrival-2");

    if (radio1.is(":checked") && !radio2.is(":checked")) {
        return arrivalForm.find("#arrival-select option:selected").text();
    } else if (!radio1.is(":checked") && radio2.is(":checked")) {
        return arrivalForm.find("#arrival-box").val();
    } else {
        // TODO error
    }
}

function getArrivalRadio() {
    var arrivalForm = $("#arrival-form");

    var radio1 = arrivalForm.find("#arrival-1");
    var radio2 = arrivalForm.find("#arrival-2");

    if (radio1.is(":checked") && !radio2.is(":checked")) {
        return true;
    } else if (!radio1.is(":checked") && radio2.is(":checked")) {
        return false;
    } else {
        // TODO error
    }
}

function getDepartureRadio() {
    var departureForm = $("#departure-form");

    var radio1 = departureForm.find("#departure-1");
    var radio2 = departureForm.find("#departure-2");

    if (radio1.is(":checked") && !radio2.is(":checked")) {
        return true;
    } else if (!radio1.is(":checked") && radio2.is(":checked")) {
        return false;
    } else {
        // TODO error
    }
}

function logout() {

    var php_logout_page_url = "./model/logout.php";
    var index_page = "./index.php";

    $.ajax({
        url: php_logout_page_url,
        success: function (response, status, xhr) {
            if (response === "ok"){
                window.location.href = index_page;
            }
        },
        error: function (xhr, status, err) {
            window.confirm("Error: there is a problem in the network, " + err);
        }
    });

};

$("#gift-btn").click(function () {

    var username = $("#gift-form input[name=username]").get(0).value;
    var delete_page_url = "./model/delete_a_booking.php";

   /* if (parseInt(value) !== parseInt(value, 10)) {
        showBox("#delete-form .error-box");
        $("#delete-form .error-box").html("Error: the value insert is not valid");
        return;
    } */

    var booking_code = $("#delete-form").serialize();

    $.ajax({
        url: delete_page_url,
        type: "post",
        data: booking_code,
        data_type: "string",
        success: function (response, status, xhr) {

            switch (response) {
                case "err_1":
                    show_box("#delete-form .error-box");
                    $("#gift-form .error-box").html("Error: DB returned an error");
                    break;
                case "err_2":
                    show_box("#delete-form .error-box");
                    $("#gift-form .error-box").html("Error: the parameter are wrong");
                    break;
                case "err_3":
                    show_box("#delete-form .error-box");
                    $("#gift-form .error-box").html("Error: the booking ID doesn't exist");
                    break;
                case "err_4":
                    /* trigger the login form */
                    $(".modalclose").trigger("click");
                    $("#login-trigger").trigger("click");
                    break;
                case "err_5":
                    show_box("#delete-form .error-box");
                    $("#gift-form .error-box").html("Error: session error");
                    break;
                case "ok":
                    hide_box("#gift-form .error-box");
                    window.confirm("Booking deleted");
                    $(".modalclose").trigger("click");
                    $("#list-div").load("../model/user_home_page.php #list-div");
                    break;
                default:
                    break;
            }

        },
        error: function (xhr, status, err) {
            show_box("#delete-form .error-box");
            var err_string;

            if (typeof(err) != undefined) {
                err_string = status + " " + err;
            }
            $("#delete-form-form .error-box").html("Error: " + err_string );
            return;
        }
    })

});

function restoreOldValues2() {
    // TODO DA IMPLEMENTARE
}

function show_box(box_name) {
    if (!$(box_name).is(":visible")) {
        $(box_name).show();
    }
}

function hide_box(box_name) {
    if (!$(box_name).is(":hidden")) {
        $(box_name).hide();
    }
}

// /* restore the old value */
// function restore_old_value() {
//
//     $("#login-form input[name=pwd]").get(0).setAttribute("type", "text");
//
//     var login_dom_obj = [];
//
//     var login_dom_obj = document.getElementById("log-input-box").getElementsByTagName("Input");
//
//     for (var i = 0; i < login_dom_obj.length; i++) {
//         login_dom_obj[i].value = login_dom_obj[i].defaultValue;
//     }
//
//    $("#delete-form input[name=bookID]").get(0).value = "";
//
//     hide_box("#delete-form .error-box");
//     hide_box("#login-form .error-box");
// }

// $(".modalclose").click( function () {
//     restore_old_value();
// });



