<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 21/06/2018
 * Time: 17.05
 */


class UserDAO {

    private $connection;

    public function __construct($connection){
        $this->connection = $connection;
    }


    public function createUser($user) {
        $query = "";

        if ($query_result = $this->connection->query($query)) {

            // TODO ritorna l'ultimo valore inserito nel database

        } else {
            throw new DatabaseExpcetion("impossible to execute query into the database");
        }
    }




}


class RouteDAO {

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function createRoute() {

    }

    public function readRoute() {
        $query = "";

        if ($query_result = $this->connection->query()) {

            $seats_array = new ArrayObject();
            if ($query_result->num_rows > 0) {

                while ($row = $query_result->fetch_array()) {
                    $seats_array->append($row["booked_seats"]);
                }

                return $seats_array;

            } else {
                return $seats_array;
            }

        } else {
            throw new DatabaseExpcetion("impossible to execute a query into the database");
        }
    }

    public function deleteRoute() {

    }

    public function updateRoute($seats_number) {
        $query = "";

        if ($query_result = $this->connection->query()) {

            $route_id = new ArrayObject();

            if ($query_result->rows_num == 0) {
                return $route_id;
            } else {

                while ($row = $this->connection->fetch_array()) {
                    $route_id->append($row["route_id"]);
                }

                return $route_id;
            }
        } else {
            throw new DatabaseExpcetion("impossible to execute the query");
        }
    }



}