<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 25/06/2018
 * Time: 18.08
 */

/*
 * this class is a POJO class that represent a row of the route table in the database
 */
class Route {

    private $routeId;
    private $departure_adddress;
    private $arrival_address;
    private $booked_seats;

    /**
     * Route constructor.
     * @param $routeId
     * @param $departure_adddress
     * @param $arrival_address
     * @param $booked_seats
     */
    public function __construct($routeId, $departure_adddress, $arrival_address, $booked_seats)
    {
        $this->routeId = $routeId;
        $this->departure_adddress = $departure_adddress;
        $this->arrival_address = $arrival_address;
        $this->booked_seats = $booked_seats;
    }

    /**
     * @return mixed
     */
    public function getRouteId()
    {
        return $this->routeId;
    }

    /**
     * @param mixed $routeId
     */
    public function setRouteId($routeId)
    {
        $this->routeId = $routeId;
    }

    /**
     * @return mixed
     */
    public function getDepartureAdddress()
    {
        return $this->departure_adddress;
    }

    /**
     * @param mixed $departure_adddress
     */
    public function setDepartureAdddress($departure_adddress)
    {
        $this->departure_adddress = $departure_adddress;
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


}