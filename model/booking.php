<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 21/06/2018
 * Time: 15.15
 */

define("max_seats", 4);

class Booking
{
    private $connection;
    private $departure_address;
    private $arrival_address;
    private $route_id_array;

    public function __construct($connection, $departure_address, $arrival_address){
        $this->connection = $connection;
        $this->departure_address = $departure_address;
        $this->arrival_address = $arrival_address;
        $this->route_id_array = new ArrayObject();
    }

    /**
     * @return ArrayObject
     */
    public function getRouteIdArray(): ArrayObject
    {
        return $this->route_id_array;
    }

    /**
     * @param ArrayObject $route_id_array
     */
    public function setRouteIdArray(ArrayObject $route_id_array)
    {
        $this->route_id_array = $route_id_array;
    }

    /**
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param mixed $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
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

    /*
     *  this method book a new route only if the user set address
     *  that are already into the system
     */
    public function addressAlreadyExists($seats_number) {
        $route_dao = new RouteDAO($this->connection);

        $result = $route_dao->readRoute();

        // iterate all over the seats booked in the correpondent route
        $i = $result->getIterator();
        $booked_seats = 0;

        while($i->valid()){
            $booked_seats = $i->current();
            if ($booked_seats + $seats_number > max_seats) {
                throw new SeatsNotAvailableExcpetions("seats not available for the journey");
            }
            $i->next();
        }


        // update the route table
        $result = $route_dao->updateRoute($seats_number);

        if ($result->count() == 0)
            throw new Exception("impossible to update the route table ");


        //TODO update the user_has_booking table


    }

    /*
     * this method book a new route only if the departure address is already into the database
     */
    public function departureAddressExists($seats_number) {
       $route_dao = new RouteDAO($this->connection);

       $result = $route_dao->readRoute();

       $i = $result->getIterator();
       $booked_seats = 0;

       while($i->valid()) {
           $booked_seats = $i->current();
           if ($booked_seats + $seats_number > max_seats)
               throw new SeatsNotAvailableExcpetions("seats not available for the journey");
           $i->next();
       }


    }

    /*
     * this method book a new route only if the arrival address is inside the system
     */
    public function arrivalAddressExists($seats_number) {
        $route_dao = new RouteDAO($this->connection);

        $result = $route_dao->readRoute();

        $i = $result->getIterator();
        $booked_seats = 0;

        while($i->valid()) {
            $booked_seats = $i->current();
            if ($booked_seats + $seats_number > max_seats)
                throw new SeatsNotAvailableExcpetions("seats not available for the journey");
            $i->next();
        }
    }

    public function addressNotExists($seats_number)
    {
        $query_1 = "";

        if ($query_result = $this->connection->query()) {

            if ($query_result->num_rows == 0) {

            } else {
                $booked_seats = 0;
                while ($row = $query_result->fetch_array()) {
                    $booked_seats = $row["booked_seats"];
                    if ($booked_seats + $seats_number > max_seats)
                        throw new SeatsNotAvailableExcpetions("for the route specified the minibus is full");
                }


            }

        } else
            throw new DatabaseExpcetion("database error, impossible to execute the query");


    }

}