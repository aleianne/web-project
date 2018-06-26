<?php

/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 18/08/2017
 * Time: 11.07
 */

include "UserDAO.php";
include "UserUtil.php";
include "User.php";

class Registration {

    private $username;
    private $password;
    private $emailPattern = "";

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function __construct($username, $password){
        $this->username = $username;
        $this->password = $password;
    }

    public function checkRegistrationData() {
        if (empty($this->username) || empty($this->password))
            throw new Exception("the field are empty");

        $this->username = strip_tags($this->username);
        $this->password = strip_tags($this->password);
    }

    public function registerUser($connection)
    {
        $user_dao = new UserDAO($connection);

        $escaped_username = $connection->real_escape_string($this->username);
        $escaped_password = $connection->real_escape_string($this->password);

        // check if the email is valid
        // TODO fare il check della mail
        /*if (preg_match($this->emailPattern, $escaped_username) == 0) {
            return false;
        }*/

        /* generate new salt */
        $salt = uniqid(mt_rand(), true);
        // TODO METTERE IL controllo sul valore di ritorno
        $hashed_password = UserUtil::hashPassword($escaped_password, $salt);

        $new_user = new User();
        $new_user->setUsername($escaped_username);
        $new_user->setPassword($hashed_password);

        $user_dao->createUser($new_user, $salt);
        return true;
    }

    public function checkUserIntoDatabase($connection) {
        $user_dao = new userDAO($connection);

        $escaped_username = $connection->real_escape_string($this->username);

        return $user_dao->readUser($escaped_username);
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