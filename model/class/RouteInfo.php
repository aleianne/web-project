<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 29/06/2018
 * Time: 22.30
 */


class UserInfo {

    private $username;
    private $booked_seats;

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
    public function getBookedSeats()
    {
        return $this->booked_seats;
    }

    /**
     * @param mixed $booked_seats
     */
    public function setBookedSeats($booked_seats)
    {
        $this->booked_seats = $booked_seats;
    }

    /**
     * UserInfo constructor.
     * @param $username
     * @param $booked_seats
     */
    public function __construct($username, $booked_seats)
    {
        $this->username = $username;
        $this->booked_seats = $booked_seats;
    }


}