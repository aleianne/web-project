<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 25/06/2018
 * Time: 18.34
 */

require_once "Exceptions.php";

class BookingDAO {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function createBooking($user, $seats_number) {
        $query1 = "INSERT INTO booking(user_id, seats_number) VALUES ('$user', '$seats_number')";

        if ($query_result = $this->connection->query($query1)) {
            return $this->connection->insert_id;
        } else {
            throw new DatabaseException("impossible to create a new booking record, database error");
        }
    }

    public function readBooking() {

    }

    public function updateBooking() {

    }

    public function deleteBooking($booking_id) {
        $query1 = "DELETE FROM user WHERE booking_id = '$booking_id'";

        if (!$this->connection->query()) {
            throw new DatabaseException("impossible to delete the specified row in the Booking table, database error");
        }
    }
}


class BookingHasRouteDAO {

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function createBookingHasRoute($booking_id, $route_id) {
        $query1 = "INSERT INTO booking_has_root(booking_id, route_id) VALUES ('$booking_id', '$route_id')";

        if (!$this->connection->query($query1)) {
            throw new DatabaseException("impossible to insert a new record into booking_has_route_table, database_error");
        }
    }

    public function readBookingHasRoute() {

    }

    public function updateBookingHasRoute() {

    }

    public function deleteBookingRoute() {

    }
}