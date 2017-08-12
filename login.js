/**
 * Created by utente pc on 12/08/2017.
 */


function User(name, surname, password, email) {
    this.name = name;
    this.surname = surname;
    this.password = new password(password);
    this.email  = new email(email);
}


function email(email_addr) {
    this.address = function (email_addr) {
        /* add the part of the email check */
    };
    this.valid = false;
}

function password(password) {
    this.password = password
    this.pass_strenght = function (password) {

    }
}