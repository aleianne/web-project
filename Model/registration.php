<?php

/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 18/08/2017
 * Time: 11.07
 */
class registration
{
    private $name;
    private $surname;
    private $email;
    private $pwd;
    private $hash_pwd;
    const hash_alg = "sha256";

    public function __construct($name, $surname, $email, $pwd)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->pwd = $pwd;
    }

    public function check_cont() {
        if (empty($this->email) || empty($this->surname) || empty($this->pwd) || empty($this->email)) {
            throw new Exception("the field are empty");
        }

        $this->name = strip_tags($this->name);
        $this->surname = strip_tags($this->surname);
        $this->pwd = strip_tags($this->pwd);
        $this->email = strip_tags($this->email);
    }

    public function getUsername(){
        return $this->email;
    }

    public function getName() {
        return $this->name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function getHash_pwd() {
        if (empty($this->hash_pwd)) {
            throw new Exception("the password is not hashed", 1);
        } else {
            return $this->hash_pwd;
        }
    }

    public function Hash_pwd($salt) {
        if (!empty($this->pwd) && !empty($salt)){

            /* convert the data passed in string */
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

            /* concatenate the string and the salt to obtain the hash password */
            $subject_string = $string_pwd.$string_salt;
            return $this->hash_pwd = hash(registration::hash_alg, $subject_string);

        } else {
            throw new Exception("Password or salt empty", 1);
        }
    }

}