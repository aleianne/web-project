<?php

/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 18/08/2017
 * Time: 10.52
 */

require_once "User.php";
require_once "UserDAO.php";
require_once "UserUtil.php";

class Login {

    private $username;
    private $password;

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

    public function checkLoginDataValidity() {
        if (empty($this->password)  || empty($this->username))
            return false;


        $this->password = strip_tags($this->password);
        $this->username = strip_tags($this->username);
        return true;
    }

//    public function getUser(){
//        return $this->username;
//    }

   public function checkLoginInfo($connection) {
       $sanitized_username = $connection->real_escape_string($this->username);

       $user_dao = new UserDAO($connection);
       $user = $user_dao->readUser($sanitized_username);

       $hashed_password = UserUtil::hashPassword($this->password, $user->getSalt());

       if (strcmp($hashed_password, $user->getPassword()) == 0) {
           return true;
       } else {
           return false;
       }

   }
}