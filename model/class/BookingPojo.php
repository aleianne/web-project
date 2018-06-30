<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 27/06/2018
 * Time: 19.11
 */

class BookingPojo {
    private $booking_id;
    private $departure_address;
    private $arrival_address;
    private $reserved_seats;
    private $routes;

    /**
     * BookingPojo constructor.
     * @param $departure_address
     * @param $arrival_address
     * @param $reserved_seats
     */
    public function __construct($booking_id, $departure_address, $arrival_address, $reserved_seats)
    {
        $this->departure_address = $departure_address;
        $this->arrival_address = $arrival_address;
        $this->reserved_seats = $reserved_seats;
        $this->booking_id = $booking_id;
    }

    /**
     * @return mixed
     */
    public function getReservedSeats()
    {
        return $this->reserved_seats;
    }

    /**
     * @param mixed $reserved_seats
     */
    public function setReservedSeats($reserved_seats)
    {
        $this->reserved_seats = $reserved_seats;
    }

    /**
     * @return mixed
     */
    public function getBookingId()
    {
        return $this->booking_id;
    }

    /**
     * @param mixed $booking_id
     */
    public function setBookingId($booking_id)
    {
        $this->booking_id = $booking_id;
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
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @param mixed $routes
     */
    public function setRoutes($routes)
    {
        $this->routes = $routes;
    }


}