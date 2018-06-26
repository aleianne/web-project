<?php

/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 14/01/2018
 * Time: 18.11
 */
class User
{
    private $username;
    private $password;
    private $salt;
    private $user_id;


    /**
     * user constructor.
     * @param $username
     * @param $password
     * @param $salt
     * @param $user_id
     */
    public function __construct($username, $password, $salt, $user_id)
    {
        $this->username = $username;
        $this->password = $password;
        $this->salt = $salt;
        $this->user_id = $user_id;
    }

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

    /**
     * @return mixed
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param mixed $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }


}