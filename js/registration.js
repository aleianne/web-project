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
    if (this.user.password.pwdStrength())
        return true;

    console.log("the password is not valid");
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
    var userMailElement = registrationForm.find("input[name='email']");
    var password1Element = registrationForm.find("input[name='first-password']");
    var password2Element = registrationForm.find("input[name='second-password']");

    var errorBox = registrationForm.find(".error-box");

    // create a new user object
    var user = new User(new Email(userMailElement.val()), new Password(password1Element.val()));

    var registrationUser = new Registration(user, new Password(password2Element.val()));

    if (!registrationUser.checkRegistrationValidity()) {
        showBox(errorBox);
        errorBox.html("Error: fields empty!");
        return;
    }

    if (!registrationUser.user.email.isValid()) {
        showBox(errorBox);
        errorBox.html("Error: email address is not valid");
        return;
    }

    if (!registrationUser.checkPasswordValidity()) {
        showBox(errorBox);
        errorBox.html("Error: password not valid");
        return;
    }

    if (!registrationUser.checkPasswordEquality()) {
        showBox(errorBox);
        errorBox.html("Error: passwords are different");
        return;
    }

    /* send data to the server */
    var post_data = registrationForm.serialize();
    $.ajax({
        url: registrationPage,
        type: "post",
        data: post_data,
        success: function (response, status, xhr) {
            switch (response) {
                case "err_1":
                    /* generic database error */
                    showBox(errorBox);
                    errorBox.html("Error: DB returned an error");
                    break;
                case "err_2":
                    /* username already exist*/
                    showBox(errorBox);
                    errorBox.html("Error: the username already exist");
                    break;
                case "err_3":
                    /* the field are empty*/
                    showBox(errorBox);
                    errorBox.html("Error: the field are empty");
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
        },
        error: function (xhr, status, err) {
            showBox("#registration-form .error-box");
            var err_string;

            if (typeof(err) !== undefined)
                err_string = status + " " + err;

            errorBox.html("Error: " + err_string );
        }
    });
}

function passwordRealTimeCheck() {
        var pwd = new Password($("#registration-form").find("input[name='first-password']").get(0).value);
        var passwordElement = $("#password-strength-box");
        var passwordString = $("#strength-string").get(0);

        if (pwd.pwdStrength()) {
            passwordString.innerHTML = green;
            passwordString.style.color = "green";
        } else {
            passwordString.innerHTML = red;
            passwordString.style.color = "red";
        }


        if (!passwordElement.is(":visible"))
            passwordElement.show();
}



