/*
 * const declaration
 */
const red = "Password: weak";
const yellow = "Password: discrete";
const green = "Password: strong";
const err = "Error!";

const registrationPage = "./model/registration_check.php";
const nextPage = "./user_home_page.php";

function Registration(user, secondPassword) {
    this.user = user;
    this.secondPassword = secondPassword;
}

Registration.prototype.checkRegistrationValidity = function() {
    if (this.user.email.isEmpty()
        || this.user.password.isEmpty()
        || this.secondPassword.isEmpty()) {

        console.log("one element of the registration form is empty");
        return false;
    }

    return true;
}

Registration.prototype.checkPasswordValidity = function() {
    // check if the password are valid
    if (this.user.password.isValid() && this.secondPassword.isValid())
        return true;

    console.log("the password are not valid");
    return false;
}


Registration.prototype.checkPasswordEquality = function() {
    if (this.user.password.eq(this.secondPassword))
        return true;

    console.log("the passwords submitted are not equal");
    return false;
}

/* submit the registration form */
function registrationSubmit() {

    // if (check_form_field("reg-input-box")) {
    //     showBox("#registration-form .error-box");
    //     $("#registration-form .error-box").html("Error: some fields are empty!");
    //     return;
    // }

    var registrationForm = $("#registration-form");

    var userEmail = new Email(registrationForm.find("input[name='email']").get(0).value);
    var pwd1 = new Password(registrationForm.find("input[name='first-password']").get(0).value);

    // create a new user object
    var user = new User(userEmail, pwd1);

    var pwd2 = new Password(registrationForm.find("input[name='second-password']").get(0).value);
    var registrationUser = new Registration(user, pwd2);

    if (!registrationUser.checkRegistrationValidity()) {
        showBox("#registration-form .error-box");
        registrationForm.find("#registration-error-box").html("Error: fields empty!");
        return;
    }

    if (!registrationUser.user.email.isValid()) {
        showBox("#registration-form .error-box");
        registrationForm.find("#registration-error-box").html("Error: email address is not valid");
        return;
    }

    if (!registrationUser.checkPasswordValidity()) {
        showBox("#registration-form .error-box");
        registrationForm.find("#registration-error-box").html("Error: password not valid");
        return;
    }

    if (!registrationUser.checkPasswordEquality()) {
        showBox("#registration-form .error-box");
        registrationForm.find("#registration-error-box").html("Error: passwords are different");
        return;
    }

    /* send data to the server */
    var post_data = registrationForm.serialize();
    $.ajax({
        url: registrationPage,
        type: "post",
        data: post_data,
        success: successFunction(response, status, xhr),
        error: errorFunction(xhr, status, err)
    });
}

function passwordRealTimeCheck() {
        var pwd = new Password($("#registration-form").find("input[name='first-password']").get(0).value);
        var pwdElement = $("#strength-str")
        var pwdString = pwdElement.get(0);

        if (pwd.pwdStrength()) {
            pwdString.innerHTML = green;
            pwdString.style.color = "green";
        } else {
            pwdString.innerHTML = red;
            pwdString.style.color = "red";
        }


        if (!pwdElement.is(":visible"))
            pwdElement.show();
}

function errorFunction(xhr, status, err) {
    showBox("#registration-form .error-box");
    var err_string;

    if (typeof(err) !== undefined)
        err_string = status + " " + err;

    $("#registration-form").find("#registration-error-box").html("Error: " + err_string );
}

function successFunction(response, status, xhr) {
    switch (response) {
        case "err_1":
            /* generic database error */
            showBox(".error-box");
            $("#registration-form").find("#registration-error-box").html("Error: DB returned an error");
            break;
        case "err_2":
            /* username already exist*/
            showBox(".error-box");
            $("#registration-form").find("#registration-error-box").html("Error: the username already exist");
            break;
        case "err_3":
            /* the field are empty*/
            showBox(".error-box");
            $("#registration-form").find("#registration-error-box").html("Error: the field are empty");
            break;
        case "ok":
            window.location.href = nextPage;
            restoreOldValues();
            break;
        case "redirect":
            window.confirm("redirection");
            break;
        default:
            console.log("is not possible to decode the value returned by the server");
            break;
    }
}