<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 21/06/2018
 * Time: 15.15
 */

define("max_seats", 4);

require_once "Exceptions.php";
require_once "RouteDAO.php";
require_once "Route.php";
include "BookingDAO.php";

class Booking
{
    private $connection;
    private $departure_address;
    private $arrival_address;
    private $route_id_array;
    private $user_id;

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

        $result = $route_dao->queryRoute($this->departure_address, $this->arrival_address);

        // iterate all over the seats booked in the correspondent route
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
        $result = $route_dao->updateRoute($this->departure_address, $this->arrival_address, $seats_number);

        if ($result->count() == 0)
            throw new Exception("impossible to update the route table ");


        //TODO update the user_has_booking table

        // create a new booking row
        $booking_dao = new BookingDAO($this->connection);
        $booking_has_route = new BookingHasRouteDAO($this->connection);

        $this->getUserId();
        $booking_id = $booking_dao->createBooking($this->user_id);

        // iterate over all the route id in order to insert a new record into the
        $i = $result->getIterator();
        while($i->valid()) {
            $booking_has_route->createBookingHasRoute($booking_id, $i->current());
            $i->next();
        }

        return $booking_id;
    }

    /*
     * this method book a new route only if the departure address is already into the database
     */
    public function departureAddressExists($seats_number) {
       $route_dao = new RouteDAO($this->connection);

       $result = $route_dao->queryRoute($this->departure_address, $this->arrival_address);

       $i = $result->getIterator();
       $booked_seats = 0;

       while($i->valid()) {
           $booked_seats = $i->current();
           if ($booked_seats + $seats_number > max_seats)
               throw new SeatsNotAvailableExcpetions("seats not available for the journey");
           $i->next();
       }

       $result = $route_dao->updateRoute($this->departure_address, $this->arrival_address, $seats_number);

       // TODO insert a new route into the table

       if ($result->count() == 0) {
           throw new Exception();
       }

        // select the route to be updated and retourne the route objecr
        //$route_object = $route_dao->readRoute2($this->arrival_address);

       //update the route row with a new arrival for the end of the route
       $route_dao->updateRoute2($this->arrival_address);

       // create a new route record into the table and than add it to the array
       $route_id = $route_dao->createRoute($this->arrival_address, $route_object->getArrivalAddress(), $route_object->getBookedSeats() + $seats_number);
       $result->append($route_id);

       //create a new travel booking
       $booking_table = new BookingDAO($this->connection);
       $booking_has_route = new BookingHasRouteDAO($this->connection);

       $this->getUserId();
       $booking_id = $booking_table->createBooking($this->user_id);

        // iterate over all the route id in order to insert a new record into the
        $i = $result->getIterator();
        while($i->valid()) {
            $booking_has_route->createBookingHasRoute($booking_id, $i->current());
            $i->next();
        }

        return $booking_id;
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

        $result = $route_dao->updateRoute($this->departure_address, $this->arrival_address, $seats_number);

        if ($result->count() == 0) {
            throw new Exception();
        }

        // select the route to be updated and retourne the route objecr
        $route_object = $route_dao->readRoute2($this->departure_address);

        //update the route row with a new arrival for the end of the route
        $route_dao->updateRoute2($this->departure_address);

        // create a new route record into the table and than add it to the array
        $route_id = $route_dao->createRoute($this->departure_address, $route_object->getArrivalAddress(), $route_object->getBookedSeats() + $seats_number);
        $result.append($route_id);

        //create a new travel booking
        $booking_table = new BookingDAO($this->connection);
        $booking_has_route = new BookingHasRouteDAO($this->connection);

        $this->getUserId();
        $booking_id = $booking_table->createBooking($this->user_id);

        // iterate over all the route id in order to insert a new record into the
        $i = $result->getIterator();
        while($i->valid()) {
            $booking_has_route->createBookingHasRoute($booking_id, $i->current());
            $i->next();
        }

        return $booking_id;
    }

    public function addressNotExists($seats_number)
    {
        $query_1 = "";

        if ($query_result = $this->connection->query()) {

            if ($query_result->num_rows == 0) {

                /*
                 *  TODO i casi possono essere tre:
                 *      - l'indirizzo di arrivo e quello di partenza vengono prima del primo indirizzo all'interno  del db
                 *      - l'indirizzo di arrivo e di partenza vengono dopo l'ultimo indirizzo all'interno del db
                 *      - l'indirizzo di partenza e di arrivo sono compresi all'interno di un singolo record
                 */

            } else {
                $booked_seats = 0;
                while ($row = $query_result->fetch_array()) {
                    $booked_seats = $row["booked_seats"];
                    if ($booked_seats + $seats_number > max_seats)
                        throw new SeatsNotAvailableExcpetions("for the route specified the minibus is full");
                }

            }

        } else
            throw new DatabaseException("database error, impossible to execute the query");


    }

    private function getUserId() {
        if (isset($this->user_id)) {
            return $this->user_id;
        }

        // get the user id from the user table
        $user_dao = new UserDAO($this->connection);
        $this->user_id = $user_dao->readUser($this->suern);
        return $this->user_id;
    }

    private function createNewRoute($route_dao, $address) {

    }

}