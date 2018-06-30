<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 26/06/2018
 * Time: 14.09
 */

class UserUtil {

    public function __construct(){
    }

    // this method hash a password given a salt
    public static function hashPassword($password, $salt) {

        if (!empty($password) && !empty($salt)) {
            $string_pwd = "";
            //convert the data passed in string
            if (!is_string($password))
                $string_pwd = (string)$password;
            else
                $string_pwd = $password;

            if (!is_string($salt))
                $string_salt = (string)$salt;
            else
                $string_salt = $salt;

            // concatenate the string and the salt to obtain the hash password
            $subject_string = $string_pwd . $string_salt;
            return hash("sha256", $subject_string);

        } else {
            return false;
        }
    }
}