<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 21/06/2018
 * Time: 15.15
 */

// TODO DA CAMIBARE IN 4
define("max_seats", 4);

require_once "Exceptions.php";
require_once "RouteDAO.php";
require_once "Route.php";
require_once "UserDAO.php";
require_once "BookingDAO.php";

class Booking
{
    private $connection;
    private $departure_address;
    private $arrival_address;
    private $route_id_array;
    private $user_id;
    private $username;

    public function __construct($connection, $departure_address, $arrival_address, $username){
        $this->connection = $connection;
        $this->departure_address = $departure_address;
        $this->arrival_address = $arrival_address;
        $this->username = $username;
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

        if ($result->count() == 0) {
            throw new InternalServerError("the query return 0 value");
        }

        // check if the seats in all the route are available
        $this->checkSeatsConstraint($result, $seats_number);

        // update the route table
        $route_dao->updateRoute($this->departure_address, $this->arrival_address, $seats_number);

       return $this->createSeatsReservation($result, $seats_number);
    }

    /*
     * this method book a new route only if the departure address is already into the database
     */
    public function departureAddressExists($seats_number) {
       $route_dao = new RouteDAO($this->connection);

       $result = $route_dao->queryRoute($this->departure_address, $this->arrival_address);

       if ($result->count() == 0) {
           throw new InternalServerErrorException();
       }

       $this->checkSeatsConstraint($result, $seats_number);

       // update the seats in all the route between the departure and arrival address
       $route_dao->updateRoute($this->departure_address, $this->arrival_address, $seats_number);

       // get the first route in the array returned by the query
       $last_route = $result->offsetGet($result->count() - 1);

       //update the route row with a new arrival for the end of the route
       $route_dao->updateRoute2($this->arrival_address);

       // create a new route record into the table and than add it to the array
       $route= $route_dao->createRoute($this->arrival_address, $last_route->getArrivalAddress(), $last_route->getBookedSeats() + $seats_number);
       $result->append($route);

       return $this->createSeatsReservation($result, $seats_number);
    }

    /*
     * this method book a new route only if the arrival address is inside the system
     */
    public function arrivalAddressExists($seats_number) {
        $route_dao = new RouteDAO($this->connection);

        $result = $route_dao->queryRoute($this->departure_address, $this->arrival_address);

        if ($result->count() == 0) {
            throw new InternalServerError();
        }

        // check if the seats in all the route are available
        $this->checkSeatsConstraint($result, $seats_number);

        // update only the seats
        $route_dao->updateRoute($this->departure_address, $this->arrival_address, $seats_number);

        // get the first route of the array returned by the query
        $first_route = $result->offsetGet(0);

        //update the route row with a new arrival for the end of the route
        $route_dao->updateRoute2($this->departure_address);

        // create a new route record into the table and than add it to the array
        $route= $route_dao->createRoute($this->departure_address, $first_route->getArrivalAddress(), $first_route->getBookedSeats() + $seats_number);
        $result->append($route);

        return $this->createSeatsReservation($result, $seats_number);
    }

    public function addressNotExists($seats_number)
    {
        $route_dao = new RouteDAO($this->connection);
        $result = $route_dao->queryRoute($this->departure_address,$this->arrival_address);

        if ($result->count() == 0) {

            /*
             *  TODO i casi possono essere tre:
             *      - l'indirizzo di arrivo e quello di partenza vengono prima del primo indirizzo all'interno  del db
             *      - l'indirizzo di arrivo e di partenza vengono dopo l'ultimo indirizzo all'interno del db
             */

            $first_route = $route_dao->readFirstRoute();

            if (strcmp($this->arrival_address, $first_route == -1)) {
                $route = $route_dao->createRoute($this->departure_address, $this->arrival_address, $seats_number);
                //create a new travel booking
                $booking_table = new BookingDAO($this->connection);
                $booking_has_route = new BookingHasRouteDAO($this->connection);

                $this->getUserId();
                $booking_id = $booking_table->createBooking($this->user_id, $seats_number, $this->departure_address, $this->arrival_address);
                $booking_has_route->createBookingHasRoute($booking_id, $route->getRouteId());

                return $booking_id;
            }

            $last_route = $route_dao->readLastRoute();

            if (strcmp($last_route, $this->departure_address) == -1) {
                $route = $route_dao->createRoute($this->departure_address, $this->arrival_address, $seats_number);
                //create a new travel booking
                $booking_table = new BookingDAO($this->connection);
                $booking_has_route = new BookingHasRouteDAO($this->connection);

                $this->getUserId();
                $booking_id = $booking_table->createBooking($this->user_id, $seats_number, $this->departure_address, $this->arrival_address);
                $booking_has_route->createBookingHasRoute($booking_id, $route->getRouteId());

                return $booking_id;
            }


//            $read_route = $route_dao->readRoute3($this->departure_address, $this->arrival_address);
//
//            if ($read_route->getBookedSeats() + $seats_number > max_seats) {
//                throw new SeatsNotAvailableException("seats not available for the journey");
//            }
//
//            $route_dao->updateRoute2($this->departure_address);
//            $result->append($read_route);
//
//            $route_dao->updateSingleRoute($read_route->getDepartureAddress(), $this->departure_address, $seats_number);
//            $create_route = $route_dao->createRoute($this->arrival_address, $read_route->getArrivalAddress(), $read_route->getBookedSeats() + $seats_number);
//            $result->append($read_route);
//            $result->append($create_route);
//
//            return $this->createSeatsReservation($result, $seats_number);
        }

        if ($result->count() == 1) {
            // check the seat constraints
            $this->checkSeatsConstraint($result, $seats_number);

            $route_dao->updateRoute($this->departure_address, $this->arrival_address, $seats_number);

            // select the route to be updated
            $first_route = $result->offsetGet(0);

            //update the route row with a new arrival for the end of the route
            $route_dao->updateRoute2($this->departure_address);

            $new_route1 =  $route_dao->createRoute($this->departure_address, $this->arrival_address, $first_route->getBookedSeats() + $seats_number);
            $new_route2 = $route_dao->createRoute($this->arrival_address, $first_route->getArrivalAddress(), $first_route->getBookedSeats());
            $result->append($new_route1);

            return $this->createSeatsReservation($result, $seats_number);
        }

        // check the seat constraints
        $this->checkSeatsConstraint($result, $seats_number);

        $route_dao->updateRoute($this->departure_address, $this->arrival_address, $seats_number);

        // select the route to be updated
        $first_route = $result->offsetGet(0);
        $last_route = $result->offsetGet($result->count() - 1);

        //update the route row with a new arrival for the end of the route
        $route_dao->updateRoute2($this->departure_address);
        $route_dao->updateRoute2($this->arrival_address);

        // create a new route record into the table and than add it to the array
        $new_first_route = $route_dao->createRoute($this->departure_address, $first_route->getArrivalAddress(), $first_route->getBookedSeats() + $seats_number);
        $new_last_route =  $route_dao->createRoute($last_route->getArrivalAddress(), $this->arrival_address, $last_route->getBookedSeats() + $seats_number);
        $result->append($new_first_route);
        $result->append($new_last_route);

        return $this->createSeatsReservation($result, $seats_number);
    }

    private function getUserId() {
        if (isset($this->user_id)) {
            return $this->user_id;
        }

        // get the user id from the user table
        $user_dao = new UserDAO($this->connection);
        // TODO da cambiare un volta testato tutto
        $user = $user_dao->readUser($this->username);
        $this->user_id = $user->getUserId();
        return $this->user_id;
    }


    private function createSeatsReservation($route_array, $seats_number) {
        //create a new travel booking
        $booking_table = new BookingDAO($this->connection);
        $booking_has_route = new BookingHasRouteDAO($this->connection);

        $this->getUserId();
        $booking_id = $booking_table->createBooking($this->user_id, $seats_number, $this->departure_address, $this->arrival_address);

        // iterate over all the route id in order to insert a new record into the table
        $j = $route_array->getIterator();
        while($j->valid()) {
            $route = $j->current();
            $booking_has_route->createBookingHasRoute($booking_id, $route->getRouteId());
            $j->next();
        }

        return $booking_id;
    }


    private function checkSeatsConstraint($route_array, $seats_number) {
        $i = $route_array->getIterator();
        while($i->valid()) {
            $route = $i->current();
            if ($route->getBookedSeats() + $seats_number > max_seats)
                throw new SeatsNotAvailableException("seats not available for the journey");
            $i->next();
        }
    }

}