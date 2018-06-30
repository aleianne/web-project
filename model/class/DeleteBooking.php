<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 29/06/2018
 * Time: 18.45
 */

require_once "BookingDAO.php";
require_once "RouteDAO.php";


class DeleteBooking {

    private $connection;

    public function __construct($connection){
        $this->connection = $connection;
    }

    public function deleteBooking($booking_id) {
        //  TODO controllare meglio e aggiungere un'eccezione in non possa essere tolto il dato
        $booking_has_route_dao = new BookingHasRouteDAO($this->connection);
        $booking_dao = new BookingDAO($this->connection);
        $route_dao = new RouteDAO($this->connection);

        $retrieved_booking = $booking_dao->readBooking($booking_id);

        // check if the seats are greater than zero
        $result_array = $route_dao->queryRoute($retrieved_booking->getDepartureAddress(), $retrieved_booking->getArrivalAddress());

        $i = $result_array->getIterator();
        while($i->valid()) {
            if ($i->current()->getBookedSeats() - $retrieved_booking->getReservedSeats() < 0) {
                throw new InvalidDeleteException();
            }
            $i->next();
        }

        $route_dao->updateRoute3($retrieved_booking->getDepartureAddress(), $retrieved_booking->getArrivalAddress(), $retrieved_booking->getReservedSeats());
        $booking_dao->deleteBooking($booking_id);
    }
}