<?php

/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 18/08/2017
 * Time: 11.07
 */

require_once "UserDAO.php";
require_once "UserUtil.php";
require_once "User.php";
require_once "Exceptions.php";

class Registration {

    private $username;
    private $password;
    private $emailPattern = "/^(([^<>()\[\]\\.,;:\s@\"]+(\.[^<>()\[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/";

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
           return false;

        $this->username = strip_tags($this->username);
        $this->password = strip_tags($this->password);
        return true;
    }

    public function registerUser($connection)
    {
        $user_dao = new UserDAO($connection);

        $escaped_username = $connection->real_escape_string($this->username);
        $escaped_password = $connection->real_escape_string($this->password);

        // check if the email is valid
        // TODO fare il check della mail
        if (preg_match($this->emailPattern, $escaped_username) == 0) {
            return false;
        }

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
        try {
            $escaped_username = $connection->real_escape_string($this->username);
            $user_dao->readUser($escaped_username);
        } catch (RecordNotFoundException $rne) {
            return false;
        }
        return true;
    }
}