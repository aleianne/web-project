<?php

/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 18/08/2017
 * Time: 10.52
 */
class login extends user
{
    public function __construct($username, $password){
        parent::__construct($username, $password);
    }

    public function check_login() {
        if (empty($this->password)  || empty($this->username)) {
            throw new Exception("the password or the username are empty");
        }

        $this->password = strip_tags($this->password);
        $this->username = strip_tags($this->username);
    }

    /*public function getUser(){
        return $this->username;
    }

    public function hash_pwd($salt) {

        if (!empty($this->passwd) && !empty($salt)){

            //convert the data passed in string
            if (!is_string($this->passwd)) {
                $string_pwd = (string) $this->passwd;
            } else {
                $string_pwd = $this->passwd;
            }

            if(!is_string($salt)) {
                $string_salt = (string) $salt;
            } else {
                $string_salt = $salt;
            }

            // concatenate the string and the salt to obtain the hash password
            $subject_string = $string_pwd.$string_salt;
            return $hash_passwd = hash(login::hash_alg, $subject_string);

        } else {
            throw new Exception("Password or salt empty", 1);
        }
    }*/
}