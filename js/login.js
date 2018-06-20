
/* part used to store the main object used during the login phase */
function User(email, password) {
    this.email = email;
    this.password = password;
    this.isLogged = false;
}

User.prototype.loginWithCredential = function() {

}

function Email(email_address) {
    this.address = String(email_address);
}

Email.prototype.isValid  = function (){
    // this is the regexp pattern for the Email check
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(this.address);
};

Email.prototype.isEmpty = function() {
    if (this.address === null || this.address.length === 0)
        return true;

    return false;
};

function Password(password) {
    this.password = String(password);
}

Password.prototype.pwdStrength = function () {
    // pass_string = String(this.password);
    if (this.password.length < 2)
        return false;

    // regexp pattern to verify if the string contain at least one capital letter
    var regexp = /[a-z]([A-Z]|[0-9])|([A-Z]|[0-9])[a-z]|([A-Z]|[0-9])([A-Z]|[0-9])/g;

    // return true di the password is strong, false if the password is weak
    return regexp.test(this.password);

};

Password.prototype.isEmpty = function() {
    if (this.password === null || this.password.length === 0 )
        return true;

    return false;
};

Password.prototype.eq =  function (pwd) {
    // check if the two Password correspond
    if (!(pwd instanceof Password))
        return false;

    if (pwd.isEmpty()) {
        console.log("the password passed as argument is empty...");
        return false;
    }

    if (this.password != pwd.password)
        return false;

    return true;
};

/* submit the login form */
function loginSubmit() {

    const loginCheckPageUrl = "./model/login_check.php";
    const nextPageUrl = "./user_home_page.php";
    const errorClassName = "error-effect";

    var loginFormElement = $("#login-form");
    var loginFormErrorBox = loginFormElement.find(".error-box");
    var emailInputElement = loginFormElement.find("input[name='email']");
    var passwordInputElement = loginFormElement.find("input[name='password']");

    var loginUser = new User(new Email(emailInputElement.val()), new Password(passwordInputElement.val()));

    if (loginUser.email.isEmpty() || loginUser.password.isEmpty()){
        // show the error box
        showBox(loginFormErrorBox);
        loginFormErrorBox.html("Error: field are empty");

        // add an aminamtion to the input box
        if (loginUser.email.isEmpty() &&  loginUser.password.isEmpty()) {
            emailInputElement.addClass(errorClassName);
            passwordInputElement.addClass(errorClassName);
            setTimeout(function() {
                emailInputElement.removeClass(errorClassName);
                passwordInputElement.removeClass(errorClassName)
            }, 300);
        }

        if(loginUser.email.isEmpty()) {
            emailInputElement.addClass(errorClassName);
            setTimeout(function() {
                emailInputElement.removeClass(errorClassName);
            }, 300);
        } else {
            passwordInputElement.addClass(errorClassName);
            setTimeout(function () {
                passwordInputElement.removeClass(errorClassName);
            }, 300);
        }

        return;
    }

    if (!loginUser.email.isValid()) {
        showBox(loginFormErrorBox);
        loginFormErrorBox.html("Error: email address is not valid");
        return;
    }

    var post_data = loginFormElement.serialize();

    $.ajax({
        url: loginCheckPageUrl,
        type: "post",
        // crossOrigin: true,
        // header: {'Content-Type':'application/x-www-form-urlencoded'},
        dataType: "text",
        data: post_data,
        success: function (response, status, xhr) {

            switch (response){
                case "err_1":
                    showBox(loginFormErrorBox);
                    loginFormErrorBox.html("Error: username doesn't exist");
                    break;
                case "err_2":
                    /* database connection error */
                    showBox(loginFormErrorBox);
                    loginFormErrorBox.html("Error: Database connection error");
                    break;
                case "err_3":
                    showBox(loginFormErrorBox);
                    loginFormErrorBox.html("Error: the Password is no correct");
                    break;
                case "err_4":
                    /* generic database error */
                    showBox(loginFormErrorBox);
                    loginFormErrorBox.html("Error:  DB returned an error");
                    break;
                case "err_5":
                    /*field are empty */
                    showBox(loginFormErrorBox);
                    loginFormErrorBox.html("Error: The field are empty");
                    break;
                case "ok":
                    window.location.href = nextPageUrl;
                    restoreOldValues();
                    break;
                default:
                    break;
            }

        },
        error: function (xhr, status, err) {
            showBox(errorBoxElement);
            var err_string;

            if (typeof(err) != undefined)
                err_string = status + " " + err;

            loginFormElement.find(".error-box").html("Error: " + err_string );
        }
    });
}

// /* check if the form field are empty or not */
// function check_form_field(form_name) {
//     var dom_obj = [];
//     var index;
//
//     dom_obj = document.getElementById(form_name).getElementsByTagName("Input");
//     for (index in dom_obj) {
//         if (dom_obj[index].value === "") {
//             return true;
//         }
//     }
//     return false;
// }






