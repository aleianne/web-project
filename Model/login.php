<?php

/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 18/08/2017
 * Time: 10.52
 */
class login
{
    private $username;
    private $passwd;
    private $hash_passwd;
    const hash_alg = "sha256";

    public function __construct($email, $pwd){
        $this->username = $email;
        $this->passwd = $pwd;
    }

    public function check_cont() {
        if (empty($this->passwd)  || empty($this->username)) {
            throw new Exception("the password or the username are empty");
        }

        $this->passwd = strip_tags($this->passwd);
        $this->username = strip_tags($this->username);
    }

    public function getUser(){
        return $this->username;
    }


    public function getHash_pwd() {
        if (empty($this->hash_passwd)) {
                throw new Exception("The password is not hashed", 1);
        }
        return $this->hash_passwd;
    }

    public function hash_pwd($salt) {

        if (!empty($this->passwd) && !empty($salt)){

            /* convert the data passed in string */
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

            /* concatenate the string and the salt to obtain the hash password */
            $subject_string = $string_pwd.$string_salt;
            return $hash_passwd = hash(login::hash_alg, $subject_string);

        } else {
            throw new Exception("Password or salt empty", 1);
        }
    }
}