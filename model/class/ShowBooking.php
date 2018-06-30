<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 27/06/2018
 * Time: 17.35
 */

require_once "User.php";
require_once "UserDAO.php";
require_once "RouteDAO.php";
require_once "Route.php";
require_once "BookingDAO.php";

class ShowBooking {

    private $connection;

    public function __construct($connection){
        $this->connection = $connection;
    }

    public function showAllRoutes() {
        $route_dao = new RouteDAO($this->connection);
        return $route_dao->readAllRoute();
    }

    // return all the booking that has been made by the user selected
    public function showUserBooking($username) {
        $booking_dao = new BookingDAO($this->connection);
        return $booking_dao->readUserBooking($username);
    }

    // return the routes of the booking
    public function getBookingRoutes($departure_address, $arrival_address) {
        $route_dao = new RouteDAO($this->connection);
        return $route_dao->queryRoute($departure_address, $arrival_address);
    }

    public function getUserPerRoute($departure_address, $arrival_address) {
        $booking_dao = new BookingDAO($this->connection);
        return $booking_dao->readBooking2($departure_address, $arrival_address);
    }

}