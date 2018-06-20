<?php

/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 14/01/2018
 * Time: 18.11
 */
class user
{
    protected $username;
    protected $password;
    //protected $hash_pwd;


    public function __construct($name, $username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

//    public function getHash_pwd() {
//        if (empty($this->hash_passwd)) {
//            throw new Exception("The password is not hashed", 1);
//        }
//        return $this->hash_passwd;
//    }

//    public function hashPassword($salt) {
//        if (!empty($this->pwd) && !empty($salt)){
//
//            /* convert the data passed in string */
//            if (!is_string($this->pwd)) {
//                $string_pwd = (string) $this->pwd;
//            } else {
//                $string_pwd = $this->pwd;
//            }
//
//            if(!is_string($salt)) {
//                $string_salt = (string) $salt;
//            } else {
//                $string_salt = $salt;
//            }
//
//            /* concatenate the string and the salt to obtain the hashed password */
//            $subject_string = $string_pwd.$string_salt;
//            return $this->hash_pwd = hash(registration::hash_alg, $subject_string);
//
//        } else {
//            throw new Exception("Password or salt empty", 1);
//        }
//    }
}