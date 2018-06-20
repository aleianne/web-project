<?php

/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 18/08/2017
 * Time: 11.07
 */
class registration extends user{

    public function __construct($name, $email, $pwd){
        parent::__construct($email, $pwd);
    }

    public function checkRegistrationData() {
        if (empty($this->username) || empty($this->password))
            throw new Exception("the field are empty");

        $this->username = strip_tags($this->username);
        $this->password = strip_tags($this->password);
    }

    public function getName() {
        return $this->name;
    }

    /*public function getUsername(){
        return $this->email;
    }

    public function getName() {
        return $this->name;
    }

    public function getHash_pwd() {
        if (empty($this->hash_pwd)) {
            throw new Exception("the Password is not hashed", 1);
        } else {
            return $this->hash_pwd;
        }
    }

    public function Hash_pwd($salt) {
        if (!empty($this->pwd) && !empty($salt)){

            // convert the data passed in string
            if (!is_string($this->pwd)) {
                $string_pwd = (string) $this->pwd;
            } else {
                $string_pwd = $this->pwd;
            }

            if(!is_string($salt)) {
                $string_salt = (string) $salt;
            } else {
                $string_salt = $salt;
            }

            // concatenate the string and the salt to obtain the hashed Password
            $subject_string = $string_pwd.$string_salt;
            return $this->hash_pwd = hash(registration::hash_alg, $subject_string);

        } else {
            throw new Exception("Password or salt empty", 1);
        }
    }*/
}