<?php

//    // define the main constant variable for accessing the database
//    define ("db_user", "s239846");
//    define ("db_host", "localhost");
//    //define ("db_port", 3306);
//    define ("db_name", "s239846");
//    define ("db_pwd", "lemlogys");
//
//    // define the max number of seats into the minibus
//    define ("max_seats", 4);

//    private function searchRouteExistence($seats_number) {
//    // search if exist someo  other route with the same and and begin address
//
//    $query_1= "SELECT address.begin_address, address.end_address, address.booked_seats FROM address " .
//        "WHERE begin_addrress = '$this->begin_address' && end_address = '$this->end_address' FOR UPDATE";
//
//    if ($query_result = $this->connection->query($query_1)) {
//
//        if ($query_result->num_rows() < 0)
//            return false;
//
//        $booked_seats = $query_result->fetch_array()["booked_seats"];
//        $begin_address = $query_result->fetch_array()["begin_address"];
//        $end_address = $query_result->fetch_array()["end_address"];
//
//        $this->route_id->push($query_result->fetch_array()["route_id"]);
//
//        if ($booked_seats + $seats_number > max_seats) {
//            unset($this->route_id);
//            throw new SeatsNotAvailableExcpetions("the seats are not available for the route from "
//                . $begin_address . " to " . $end_address);
//        }
//
//        return true;
//
//    } else {
//        throw new Exception("Impossible to execute a query into the database");
//    }
//
//}
//
//
//    private function updateSingleRoute($seats_number) {
//
//    if (empty($this->route_id) || $this->route_id[0] == null )
//        throw new Exception();
//
//    $id = $this->route_id[0];
//
//    $query_1 = "UPDATE route VALUES(route.booked_seats = route.booked_seats + '$seats_number') WHERE route.route_id = '$id'";
//
//    if ($this->connection->query($query_1)) {
//
//    } else {
//        throw new Exception("impossible to execute the query");
//    }
//}


    function bookRoute( $seats_number ) {

        if (searchRoutesExistence($seats_number)) {
        creatBooking();
        return ;
        }

        if (searchIntermediateRoutes($seats_number)) {
            return;
        }

    }

    function request_list($conn, $callID) {
        $result_array = [];
        $query_string = $conn->real_escape_string($callID);
        $db_query = "SELECT user_book_call.username, booking.booking_date FROM user_book_call INNER JOIN booking ON user_book_call.book_id = booking.booking_id ".
                    "WHERE user_book_call.callN = $query_string ".
                    "ORDER BY booking_date";

        if ($query_result = $conn->query($db_query)) {

            while (!empty($db_value = $query_result->fetch_array())) {
                array_push($result_array, $db_value["username"]);
            }

            return $result_array;

        } else {
            throw new Exception($conn->error);
        }
    }



    function updateRoutes($begin_address, $end_address, $conn) {

    }

//    function insert_purchase($conn, $begin_address,$end_address) {
//
//    // strip the value received by the server
//    $stripped_begin_address = $conn->real_escape_string($begin_address);
//    $stripped_end_address = $conn->real_escape_string($end_address);
//
//    // begin a new transaction
//    $conn->begin_transaction();
//
//
//    $select_query = "SELECT web_user.total_purchased_skipass,  web_user.total_received_skipass FROM web_user WHERE web_user = '$user_string' FOR UPDATE";
//    $update_query = "UPDATE  web_user SET web_user.total_purchased_skipass = web_user.total_purchased_skipass + 1 WHERE web_user = '$user_string'";
//
//    /*
//     * purchase one skipass
//     */
//    if ($query_result = $conn->query($select_query)) {
//
//        // retrieve the data from the query
//        $purchased_skipass = $query_result->fetch_array()['total_purchased_skipass'];
//        $received_skipass = $query_result->fetch_array()['total_received_skipass'];
//
//        if ($purchased_skipass + $received_skipass > 10) {
//            // if the skipass associated to the user are more than 10 return an error
//            $conn->commit();
//            return 0;
//        } else {
//            if ($query_result = $conn->query($update_query)) {
//                $conn->commit();
//                return 1;
//            } else {
//                throw new Exception("Database error");
//            }
//        }
//
//    } else {
//        throw new Exception("Database error");
//    }
//}

    function insert_new_user(){

    }

    function insert_gift($conn, $purchaser_user, $receiver_user) {
        $user1_string = $conn->real_escape_string($purchaser_user);
        $user2_string = $conn->real_escape_string($receiver_user);

        $select_query = "SELECT web_user.total_purchased_skipass,  web_user.total_received_skipass FROM web_user WHERE web_user = '$user2_string' FOR UPDATE";
        $update_query = "UPDATE  web_user SET web_user.total_purchased_skipass = web_user.total_purchased_skipass + 1 WHERE web_user = '$user2_string'";
        $insert_gift = "INSERT  gift(giftID, skipass_purchaser_id, skipass_receiver_id)  VALUES(null, '$user1_string', '$user2_string') ";

        /*
         * purchase one skipass
         */
        if ($query_result = $conn->query($select_query)) {

            // retrieve the data from the query
            $purchased_skipass = $query_result->fetch_array()['total_purchased_skipass'];
            $received_skipass = $query_result->fetch_array()['total_received_skipass'];

            if ($purchased_skipass + $received_skipass > 10) {
                // if the skipass associated to the user are more than 10 return an error
                $conn->commit();
                return 0;
            } else {
                if ($query_result = $conn->query($update_query)) {
                    if($query_result = $conn->query($insert_gift)) {
                        $conn->commit();
                        return 1;
                    }
                } else {
                    throw new Exception("Database error");
                }
            }

        } else {
            throw new Exception("Database error");
        }
    }

   /* function delete_booking($conn, $bookID, $user) {

        $string_bookID = $conn->real_escape_string($bookID);
        $string_user = $conn->real_escape_string($user);

        $delete_booking_query = "DELETE FROM booking  WHERE booking_id = $string_bookID";
        $delete_call_query = "DELETE FROM user_book_call WHERE book_id = $string_bookID";
        $select_callN_query = "SELECT callN FROM user_book_call WHERE  book_id = $string_bookID AND username = '$string_user'";

        $callN_array = [];

        if ($query_result = $conn->query($select_callN_query)) {

            $total_row = $query_result->num_rows;
            if ($total_row == 0) {
              return 0;
            } else {
                while(!empty($db_value = $query_result->fetch_array())) {
                    array_push($callN_array, $db_value["callN"]);
                }
            }

        } else {
            throw new Exception("database error");
        }


        if (!$conn->query($delete_call_query)) {
            throw new Exception("Impossible to delete the call");
        }

        if (!$conn->query($delete_booking_query)) {
            throw new Exception("Impossible to delete the booking");
        }

        foreach ($callN_array as $callN) {

            $insert_call_query = "SELECT exam_call.booked_seats FROM exam_call WHERE exam_call.callN = $callN FOR UPDATE";
            $update_call_query  = "UPDATE exam_call SET exam_call.booked_seats = exam_call.booked_seats - 1 WHERE exam_call.callN = $callN";

            if (!($query_result = $conn->query($insert_call_query) && $conn->query($update_call_query))) {
                throw new Exception("DB error, the data are not insert", 1);
            } else {
                $conn->commit();
            }

        }

        return 1;
    }*/
