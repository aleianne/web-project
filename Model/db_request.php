<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 20/08/2017
 * Time: 17.40
 **/

    define ("db_user", "s239846");
    define ("db_host", "localhost");
    //define ("db_port", 3306);
    define ("db_name", "s239846");
    define ("db_pwd", "mentived");

    function request_list($conn, $callID)
    {

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

    function insert_purchase($conn, $user) {

        $user_string = $conn->real_escape_string($user);

        $select_query = "SELECT web_user.total_purchased_skipass,  web_user.total_received_skipass FROM web_user WHERE web_user = '$user_string' FOR UPDATE";
        $update_query = "UPDATE  web_user SET web_user.total_purchased_skipass = web_user.total_purchased_skipass + 1 WHERE web_user = '$user_string'";

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
                    $conn->commit();
                    return 1;
                } else {
                    throw new Exception("Database error");
                }
            }

        } else {
            throw new Exception("Database error");
        }
    }

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
