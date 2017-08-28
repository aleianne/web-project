/**
 * Created by utente pc on 12/08/2017.
 */

/*
 * const declaration
 */
const red = "Password: weak";
const yellow = "Password: discrete";
const green = "Password: strong";
const err = "Error!";

var server_page = "http://localhost/Model/";

/* part used to store the main object used during the login phase */
function User(name, surname, password, email) {
    this.name = name;
    this.surname = surname;
    this.password = password;
    this.email  = email;
}

function email(email_add) {
    this.address = email_add;
    this.isValid  = function (){
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(this.address);
    };
}

function password(password) {
    this.password = password;
    this.pass_strenght = function () {
        var length;
        var regexp = /([=<>()\\\[\].:;,-_"'@#+-]+|[\s\t\r]+|[0-9]+)/g;
        var regexp_result;

        pass_string = String(this.password);
        length = pass_string.length;
        regexp_result = regexp.test(pass_string);

        if (length <= 2) {
            /* weak password: red */
            return 1;
        } else if (regexp_result) {
            /* strong password: green*/
            return 3;
        } else {
            /* discrete password: yellow*/
            return 2;
        }

    };

    this.eq = function (pwd) {
        if (this.password == pwd.password) {
            return true;
        } else {
            return false;
        }
    };

}


/* submit the login form */
function login_submit() {

    /* submit the login form */
    if (check_form_field("log-input-box")){
        show_box("#login-form .error-box");
        $("#login-form .error-box").html("Error: the field are empty");
        return;
    }

    var user_email = new email($("#login-form input[name=email]").get(0).value);

    if (!user_email.isValid()) {
        show_box("#login-form .error-box");
        $("#login-form .error-box").html("Error: the email address is not valid");
        return;
    }

    var post_data = $("#login-form").serialize();

    $.ajax({
        url: server_page + "login_check.php",
        type: "post",
        data_type: "string",
        data: post_data,
        success: function (response, status, xhr) {

            switch (response){
                case "err_1":
                    show_box("#login-form .error-box");
                    $(".error-box").html("Error: username doesn't exist");
                    break;
                case "err_2":
                    /* database connection error */
                    show_box("#login-form.error-box");
                    $(".error-box").html("Error: Database connection error");
                    break;
                case "err_3":
                    show_box("#login-form .error-box");
                    $(".error-box").html("Error: the password is no correct");
                    break;
                case "err_4":
                    /* generic database error */
                    show_box("#login-form .error-box");
                    $(".error-box").html("Error:  DB returned an error");
                    break;
                case "err_5":
                    /*field are empty */
                    show_box("#login-form .error-box");
                    $(".error-box").html("Error: The field are empty");
                    break;
                case "ok":
                    window.location.href = "http://localhost/Model/user_home_page.php";
                    restore_old_value();
                    break;
                default:
                    break;
            }

        },
        error: function (xhr, status, err) {
            show_box("#login-form .error-box");
            var err_string;

            if (typeof(err) != undefined) {
                err_string = status + " " + err;
            }
            $("#login-form .error-box").html("Error: " + err_string );
            return;
        }
    });
}

$("#login-btn").click(function () {
    login_submit();
});

$("#login-form").keydown(function(e) {
    if (e.keyCode == 13) {
        login_submit();
    }
})

/* submit the registration form */
function registration_submit() {
    if (check_form_field("reg-input-box")) {
        show_box("#registration-form .error-box");
        $("#registration-form .error-box").html("Error: the field are empty");
        return;
    }

    var user_email = new email($("#registration-form input[name=email]").get(0).value);

    var pwd1 = new password($("#registration-form input[name=1-pwd]").get(0).value);
    var pwd2 = new password($("#registration-form input[name=2-pwd]").get(0).value);

    if (!user_email.isValid()) {
        show_box("#registration-form .error-box");
        $("#registration-form .error-box").html("Error: the email address is not valid");
        return;
    }

    if (!pwd1.eq(pwd2)) {
        show_box("#registration-form .error-box");
        $("#registration-form .error-box").html("Error: the password are different");
        return;
    }

    /* send data to the server */
    var post_data = $("#registration-form").serialize();
    $.ajax({
        url: server_page + "reg_check.php",
        type: "post",
        data: post_data,
        data_type: "string",
        success: function(response, status, xhr) {

            switch (response){
                case "err_1":
                    /* generic database error */
                    show_box(".error-box");
                    $("#registration-form .error-box").html("Error: DB returned an error");
                    break;
                case "err_2":
                    /* username already exist*/
                    show_box(".error-box");
                    $("#registration-form .error-box").html("Error: the username already exist");
                    break;
                case "err_3":
                    /* the field are empty*/
                    show_box(".error-box");
                    $("#registration-form .error-box").html("Error: the field are empty");
                    break;
                case "ok":
                    window.location.href = "http://localhost/Model/user_home_page.php";
                    restore_old_value();
                    break;
                default:
                    break;
            }

        },
        error: function (xhr, status, err) {
            show_box("#registration-form .error-box");
            var err_string;

            if (typeof(err) != undefined) {
                err_string = status + " " + err;
            }
            $("#registration-form .error-box").html("Error: " + err_string );
            return;
        }
    });
}

$("#register-btn").click(function () {
    registration_submit();
});

$("#registration-form").keydown(function (e) {

    if (e.keyCode == 13) {
        registration_submit();
    }

});

/* check if the form field are empty or not */
function check_form_field(form_name) {
    var dom_obj = [];
    var index;

    dom_obj = document.getElementById(form_name).getElementsByTagName("Input");
    for (index in dom_obj) {
        if (dom_obj[index].value == "") {
            return true;
        }
    }
    return false;
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