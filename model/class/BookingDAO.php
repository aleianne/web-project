<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 25/06/2018
 * Time: 18.34
 */

require_once "Exceptions.php";
require_once "Route.php";
require_once "BookingPojo.php";
require_once "RouteInfo.php";

class BookingDAO {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function createBooking($user, $seats_number, $departure_adrres, $arrival_address) {
        $query1 = "INSERT INTO booking(user_id, seats_number, departure_address, arrival_address) VALUES ('$user', '$seats_number', '$departure_adrres', '$arrival_address')";

        if ($query_result = $this->connection->query($query1)) {
            return $this->connection->insert_id;
        } else {
            throw new DatabaseException("impossible to create a new booking record, database error");
        }
    }

    public function readBooking($booking_id) {
        $query1 = "SELECT departure_address, arrival_address, booking_id, seats_number FROM booking WHERE booking_id = '$booking_id'";

        if ($query_result = $this->connection->query($query1)) {
            // create a new BookignPojo Object
            $row = $query_result->fetch_array(MYSQLI_ASSOC);
            $booking = new BookingPojo($row["booking_id"], $row["departure_address"],$row["arrival_address"], $row["seats_number"]);
            $query_result->close();
            return $booking;
        } else {
            throw new DatabaseExcpetion("impossible to read from the booking table, database error");
        }

    }

    public function readBooking2($departure_address, $arrival_address) {
        $query1 = "SELECT web_user.email, booking.seats_number FROM booking INNER JOIN web_user ON booking.user_id = web_user.user_id ".
                    "WHERE (LOWER(booking.departure_address) <= '$departure_address') AND (LOWER(booking.arrival_address) >= '$arrival_address')";

        if ($query_result = $this->connection->query($query1)) {

            $array = new ArrayObject();

            while($row = $query_result->fetch_array(MYSQLI_ASSOC)) {
                $new_route_info = new UserInfo($row["email"], $row["seats_number"]);
                $array->append($new_route_info);
            }
            $query_result->close();
            return $array;
        } else {
            throw new DatabaseException("impossible to read from the booking table, database error");
        }
    }

    public function readUserBooking($username) {
        $query1 = "SELECT * FROM booking INNER JOIN web_user ON booking.user_id = web_user.user_id WHERE web_user.email = '$username'";

        if ($query_result = $this->connection->query($query1)) {

            $array = new ArrayObject();

            while ($row = $query_result->fetch_array(MYSQLI_ASSOC)) {
                $new_booking = new BookingPojo($row["booking_id"], $row["departure_address"], $row["arrival_address"], $row["seats_number"]);
                $array->append($new_booking);
            }

            $query_result->close();
            return $array;

        } else {
            throw new DatabaseException();
        }
    }

    public function updateBooking() {

    }

    public function deleteBooking($booking_id) {
        $query1 = "DELETE FROM booking WHERE booking_id = '$booking_id'";

        if (!$this->connection->query($query1)) {
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