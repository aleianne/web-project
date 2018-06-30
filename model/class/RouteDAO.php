<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 25/06/2018
 * Time: 17.23
 */


require_once "Exceptions.php";
require_once "Route.php";

class RouteDAO {

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function createRoute($departure_address, $arrival_address, $booked_seats) {
        $query1 = "INSERT INTO route(departure_address, arrival_address, booked_seats)"
                    ."VALUES ('$departure_address', '$arrival_address', '$booked_seats')";

        if ($this->connection->query($query1)) {
            $route_id = $this->connection->insert_id;
            $new_route = new Route($route_id, $departure_address, $arrival_address, $booked_seats);
            return $new_route;
        } else {
            throw new DatabaseException("impossible to insert a new route, database error");
        }
    }

    public function readFirstRoute() {
        $query1 = "SELECT * FROM route ORDER BY route_id LIMIT 1";

        if ($query_result = $this->connection->query($query1)) {

            $departure_address = $query_result->fetch_array(MYSQLI_ASSOC)["departure_address"];
            $query_result->close();
            return $departure_address;
        } else {
            throw new DatabaseException("impossible to read a route, database error");
        }
    }

    public function readLastRoute() {
        $query1 = "SELECT * FROM route ORDER BY route_id DESC LIMIT 1";

        if ($query_result = $this->connection->query($query1)) {

            $arrival_address = $query_result->fetch_array(MYSQLI_ASSOC)["departure_address"];
            $query_result->close();
            return $arrival_address;
        } else {
            throw new DatabaseException("impossible to read a route, database error");
        }
    }

    public function readRoute3($departure_address, $arrival_address) {
        $query1 = "SELECT route.route_id , route.departure_address, route.arrival_address, route.booked_seats FROM route ".
                    "WHERE '$departure_address' > LOWER(departure_address) AND '$arrival_address' < LOWER(arrival_address)";

        if ($query_result = $this->connection->query($query1)) {

            if ($query_result->num_rows == 0) {
                throw new RecordNotFoundException();
            }

            $data = $query_result->fetch_array(MYSQLI_ASSOC);
            $new_route = new Route($data["route_id"], $data["departure_address"], $data["arrival_address"], $data["booked_seats"]);
            $query_result->close();
            return $new_route;

        } else {
            throw new DatabaseException("impossible to read a route, database error");
        }

    }

//    public function  readRoute2($address) {
//        $query1 = "SELECT route_id, departure_address, arrival_address, booked_seats FROM route WHERE '$address' > LOWER(departure_address) AND '$address' < LOWER(arrival_address)";
//
//        if ($query_result = $this->connection->query($query1)) {
//            if ($query_result->num_rows == 0) {
//                $query_result->close();
//                throw new RecordNotFoundException();
//            }
//
//            // fetch the data from the database and then create a new object that wrap the information
//            $data = $query_result->fetch_array(MYSQLI_ASSOC);
//            $new_route = new Route($data["route_id"], $data["departure_address"], $data["arrival_address"], $data["booked_seats"]);
//            $query_result->close();
//
//            // return selected route
//            return $new_route;
//        } else {
//            throw new DatabaseException("impossible to execute the route read, database error");
//        }
//    }

    public function readRoute($route_id) {
        $query1 = "SELECT route_id, departure_address, arrival_address, booked_seats FROM route WHERE (route_id = '$route_id')";

        if ($query_result = $this->connection->query($query1)) {
            if ($query_result->num_rows() == 0) {
                $query_result->close();
                throw new RecordNotFoundException();
            }

            // fetch the data from the database and then create a new object that wrap the information
            $data = $query_result->fetch_array(MYSQLI_ASSOC);
            $new_route = new Route($data["route_id"], $data["departure_address"], $data["arrival_address"], $data["booked_seats"]);
            $query_result->close();

            // return selected route
            return $new_route;
        } else {
            throw new DatabaseException("impossible to execute the route read, database error");
        }
    }

    public function readAllRoute() {
        $query1 = "SELECT route_id, departure_address, arrival_address, booked_seats FROM route ORDER BY departure_address";

        if ($query_result = $this->connection->query($query1)) {

            $route_array = new ArrayObject();

            if ($query_result->num_rows == 0) {
                return $route_array;
            }

            while ($row = $query_result->fetch_array(MYSQLI_ASSOC)) {
                $route = new Route($row["route_id"], $row["departure_address"], $row["arrival_address"], $row["booked_seats"]);
                $route_array->append($route);
            }

            return $route_array;

        } else {
            throw new DatabaseException("impossible to read the data from the database");
        }


    }

    public function updateRoute2($address) {
        $query1 = "UPDATE route SET arrival_address = '$address' WHERE '$address' > LOWER(departure_address) AND '$address' < LOWER(arrival_address)";

        if (!$result_query = $this->connection->query($query1)) {
            throw new DatabaseException("impossible to execute the update in route table, database error");
        }

    }

//    public function updateSingleRoute($departure_address, $new_arrival_address, $num_seats) {
//        $query1 = "UPDATE route SET arrival_address = '$new_arrival_address', booked_seats = booked_seats + '$num_seats' WHERE departure_address = '$departure_address'";
//
//        if (!$this->connection->query($query1)) {
//            throw new DatabaseException("impossible to update the record, database error");
//        }
//    }

    public function updateRoute($departure_route, $arrival_route, $seats_num) {
        $query1 = "UPDATE route SET booked_seats = booked_seats + '$seats_num' "
            ."WHERE ('$departure_route' = LOWER(departure_address)) "
            ."OR ('$departure_route' < LOWER(departure_address) AND '$arrival_route' >= LOWER(arrival_address)) "
            ."OR ('$arrival_route' = LOWER(arrival_address))";

        if (!$query_result = $this->connection->query($query1)) {
            throw new DatabaseException("impossible to update the records, database error");
        }
    }

    public function updateRoute3($departure_route, $arrival_route, $seats_num) {
        $query1 = "UPDATE route SET booked_seats = booked_seats - '$seats_num' "
            ."WHERE ('$departure_route' = LOWER(departure_address)) "
            ."OR ('$departure_route' < LOWER(departure_address) AND '$arrival_route' >= LOWER(arrival_address)) "
            ."OR '$arrival_route' = LOWER(arrival_address)";

        if (!$query_result = $this->connection->query($query1)) {
            throw new DatabaseException("impossible to update the records, database error");
        }
    }

    public function deleteRoute($departure, $arrival) {
    }

    public function queryRoute($departure_route, $arrival_route) {
        $query1 = "SELECT route.route_id, route.departure_address, route.arrival_address, route.booked_seats FROM route "
                    ."WHERE ('$departure_route' >= LOWER(departure_address) AND '$departure_route' < LOWER(arrival_address)) "
                    ."OR ('$departure_route' < LOWER(departure_address) AND '$arrival_route' >= LOWER(arrival_address)) "
                    ."OR ('$arrival_route' > LOWER(departure_address) AND '$arrival_route' < LOWER(arrival_address)) ORDER BY departure_address FOR UPDATE";

        if ($query_result = $this->connection->query($query1)) {
            // populate the array with the value returned by the database
            $route_array = new ArrayObject();

            if ($query_result->num_rows == 0) {
                return $route_array;
            }

            while ($row = $query_result->fetch_array(MYSQLI_ASSOC)) {
                $route = new Route($row["route_id"], $row["departure_address"], $row["arrival_address"], $row["booked_seats"]);
                $route_array->append($route);
            }

            return $route_array;

        } else {
            throw new DatabaseExpcetion("impossible to execute the query, database error");
        }

    }

}