<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 21/06/2018
 * Time: 16.59
 */

class UserRequest {

    private $departure_address;
    private $arrival_address;
    private $seats_number;

    /**
     * UserRequest constructor.
     * @param $departure_address
     * @param $arrival_address
     * @param $seats_number
     */
    public function __construct($departure_address, $arrival_address, $seats_number)
    {
        $this->departure_address = $departure_address;
        $this->arrival_address = $arrival_address;
        $this->seats_number = $seats_number;
    }


    /**
     * @return mixed
     */
    public function getDepartureAddress()
    {
        return $this->departure_address;
    }

    /**
     * @param mixed $departure_address
     */
    public function setDepartureAddress($departure_address)
    {
        $this->departure_address = $departure_address;
    }

    /**
     * @return mixed
     */
    public function getArrivalAddress()
    {
        return $this->arrival_address;
    }

    /**
     * @param mixed $arrival_address
     */
    public function setArrivalAddress($arrival_address)
    {
        $this->arrival_address = $arrival_address;
    }

    /**
     * @return mixed
     */
    public function getSeatsNumber()
    {
        return $this->seats_number;
    }

    /**
     * @param mixed $seats_number
     */
    public function setSeatsNumber($seats_number)
    {
        $this->seats_number = $seats_number;
    }



    public function sanitizeInputData() {
        $departure_address = strtolower($this->departure_address);

    }
}