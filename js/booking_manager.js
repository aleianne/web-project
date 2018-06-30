/**
 * Created by utente pc on 24/08/2017.
 */

function UrlCreator(key, value) {
    this.url = String(key + "=" + value);
}

UrlCreator.prototype.append = function (key, value) {
    var string = String("&" + key + "=" + value);
    this.url = this.url + string;
};

UrlCreator.prototype.getUrl = function() {
    return this.url;
};


/*
    this function is used to reserve seats on the minibus
 */
function reserveSeats(departureForm, arrivalForm) {

    var page_url = "./model/booking_request.php";

    // var arrivalForm = $("#arrival-form");
    // var departureForm = $("#departure-form");

    var departure_address = getDepartureFormData(departureForm);
    var arrival_address = getArrivalFormData(arrivalForm);
    var departure_first = getDepartureRadio(departureForm);
    var arrival_first = getArrivalRadio(arrivalForm);
    var seats_number = $("#seats-number").val();

    var url = new UrlCreator("dep_address", departure_address);
    url.append("arr_address", arrival_address);
    url.append("dep_exists", departure_first);
    url.append("arr_exists", arrival_first);
    url.append("seats_number", seats_number);

    $.ajax({
        url: page_url,
        type: "post",
        data_type: "string",
        data: url.getUrl(),
        success: function(response, status, xhr) {

            if (!isNaN(response)) {
                window.confirm("booking id: " + response);
                $(".modalclose").trigger("click");
                $("#list-div").load("./home.php #list-div");
                return;
            }

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
                case "err_5":
                    // TODO da sistemare
                    window.confirm("server error");
                    break;
                case "err_6":
                    window.confirm("wrong parameter format");
                    break;
                case "err_7":
                    window.confirm("wrong parameter");
                    break;
                case "err_8":
                    window.confirm("address are in reverse order");
                    break;
                default:
                    window.confirm("error unknown");
                    break;
            }
        },
        error: function(xhr, status, error) {
            window.confirm("Error: there is a network problem "+ error);
        }
    });
};


function getDepartureFormData(departureForm) {
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

function getArrivalFormData(arrivalForm) {
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

function getArrivalRadio(arrivalForm) {
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

function getDepartureRadio(departureForm) {
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

function submitDeletion(booking_id) {

    var delete_page_url = "./model/delete_booking.php";
    var booking_string = "booking_id=" + booking_id;

    var r = confirm("You want to delete?");
    if (r === false) {
        return;
    }

    $.ajax({
        url: delete_page_url,
        type: "post",
        data: booking_string,
        data_type: "string",
        success: function (response, status, xhr) {

            switch (response) {
                case "err_1":
                    window.alert("Error: DB returned an error");
                    break;
                case "err_2":
                    window.alert("Error: the parameter are wrong");
                    break;
                case "err_3":
                    show_box("#delete-form .error-box");
                    break;
                case "err_4":
                    /* trigger the login form */
                    $(".modalclose").trigger("click");
                    $("#login-trigger").trigger("click");
                    break;
                case "err_5":
                    window.alert("Error: session error");
                    break;
                case "err_6":
                    window.alert("Error: non valid delete");
                    break;
                case "ok":
                    window.confirm("Booking deleted");
                    $(".modalclose").trigger("click");
                    $("#list-div").load("../home.php #list-div");
                    break;
                default:
                    window.alert("unknown message returned by the server");
                    break;
            }

        },
        error: function (xhr, status, err) {
            var err_string;

            if (typeof(err) != undefined) {
                err_string = status + " " + err;
            }
            window.alert("impossible to send data " + err_string);
            return;
        }
    })

};

function restoreOldValues2() {
    // TODO DA IMPLEMENTARE
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



