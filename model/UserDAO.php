<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 21/06/2018
 * Time: 17.05
 */

require_once "Exceptions.php";

class UserDAO {

    private $connection;

    public function __construct($connection){
        $this->connection = $connection;
    }


    public function createUser($user, $salt) {

        $email = $user->getUsername();
        $pwd = $user->getPassword();

        $query = "INSERT INTO user(email, password, salt) VALUES ('$email', '$pwd', '$salt')";

        if ($this->connection->query($query)) {

            // TODO ritorna l'ultimo valore inserito nel database
            return $this->connection->result_id;

        } else {
            throw new DatabaseException("impossible to create a new user, database exception");
        }
    }

    public function readUser($username) {
        // TODO CERCARE IL PROBLEMA
        $query1 = "SELECT email, password, salt, user_id FROM user WHERE email = '$username'";

        if ($query_result = $this->connection->query($query1)) {

            if ($query_result->num_rows == 0) {
                throw new RecordNotFoundException();
            }

            $record = $query_result->fetch_array(MYSQLI_ASSOC);
            $new_user = new User($record["email"], $record["password"], $record["salt"], $record["user_id"]);
            $query_result->close();
            return $new_user;

        } else {
            throw new DatabaseException("impossible to read record from the user table, database excpetion");
        }
    }

}


//class RouteDAO {
//
//    private $connection;
//
//    public function __construct($connection) {
//        $this->connection = $connection;
//    }
//
//    public function createRoute() {
//
//    }
//
//    public function readRoute() {
//        $query = "";
//
//        if ($query_result = $this->connection->query()) {
//
//            $seats_array = new ArrayObject();
//            if ($query_result->num_rows > 0) {
//
//                while ($row = $query_result->fetch_array()) {
//                    $seats_array->append($row["booked_seats"]);
//                }
//
//                return $seats_array;
//
//            } else {
//                return $seats_array;
//            }
//
//        } else {
//            throw new DatabaseExpcetion("impossible to execute a query into the database");
//        }
//    }
//
//    public function deleteRoute() {
//
//    }
//
//    public function updateRoute($seats_number) {
//        $query = "";
//
//        if ($query_result = $this->connection->query()) {
//
//            $route_id = new ArrayObject();
//
//            if ($query_result->num_rows == 0) {
//                return $route_id;
//            } else {
//
//                while ($row = $this->connection->fetch_array()) {
//                    $route_id->append($row["route_id"]);
//                }
//
//                return $route_id;
//            }
//        } else {
//            throw new DatabaseExpcetion("impossible to execute the query");
//        }
//    }
//
//
//
//}