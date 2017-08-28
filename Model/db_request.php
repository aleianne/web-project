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
        $db_query = "SELECT sito_web.user_book_call.username, booking.booking_date FROM sito_web.user_book_call INNER JOIN sito_web.booking ON user_book_call.book_id = booking.booking_id ".
                    "WHERE user_book_call.callN = $query_string ".
                    "ORDER BY booking_date";
        if ($query_result = $conn->query($db_query)) {

            while (!empty($db_value = $query_result->fetch_array())) {
                array_push($result_array, $db_value["username"]);
            }

            return $result_array;

        } else {
            throw new Exception("database problem...");
        }
    }

    function insert_booking($conn, $user, $first_choice, $second_choice, &$db_response) {

        $user_string = $conn->real_escape_string($user);


        $check_user_booking = "SELECT web_user.id FROM sito_web.web_user INNER JOIN sito_web.booking ON web_user.id = booking.book_user_id WHERE username = '$user_string'";
        $user_id_query = "SELECT web_user.id FROM sito_web.web_user WHERE username = '$user_string'";

        /*
         * check the user booking
         */
        if ($query_result = $conn->query($check_user_booking)) {

            if ($query_result->num_rows > 0) {
                return 0;
            } else {

                if ($query_result = $conn->query($user_id_query)) {
                    $user_id = $query_result->fetch_array()['id'];
                } else {
                    throw new Exception("Database error");
                }
            }

        } else {
            throw new Exception("Database error");
        }

        $string_call = $conn->real_escape_string($first_choice);
        $insert_call_query = "SELECT exam_call.booked_seats, exam_call.max_seats FROM sito_web.exam_call WHERE exam_call.callN = $string_call FOR UPDATE ";
        $update_call_query  = "UPDATE sito_web.exam_call SET exam_call.booked_seats = exam_call.booked_seats + 1 WHERE exam_call.callN = $string_call AND exam_call.booked_seats < exam_call.max_seats";

        /*
         * insert the first call
         */
        if ($query_result = $conn->query($insert_call_query) && $conn->query($update_call_query)) {
            preg_match_all ('/(\S[^:]+): (\d+)/', $conn->info, $matches);
            $info = array_combine ($matches[1], $matches[2]);
            $conn->commit();

            if ($info['Changed'] < 0) {
                throw new Exception("DB error, the data are not insert", 1);
            } elseif ($info['Changed'] == 0) {
                $first_booked = false;
            } else {
                $first_booked = true;
            }


        } else {
            throw new Exception("DB error, the data are not insert", 1);
        }


        $string_call = $conn->real_escape_string($second_choice);
        $insert_call_query = "SELECT exam_call.booked_seats, exam_call.max_seats FROM sito_web.exam_call WHERE exam_call.callN = $string_call FOR UPDATE; ";
        $update_call_query  = "UPDATE sito_web.exam_call SET booked_seats = exam_call.booked_seats + 1 WHERE exam_call.callN = $string_call AND exam_call.booked_seats < exam_call.max_seats";

        /*
         * insert the second call
         */
        if ($conn->query($insert_call_query) && ($query_result = $conn->query($update_call_query))) {
            preg_match_all ('/(\S[^:]+): (\d+)/', $conn->info, $matches);
            $info = array_combine ($matches[1], $matches[2]);
            $conn->commit();

           if ($info['Changed'] < 0) {
               throw new Exception("DB error, the data are not insert", 1);
           } elseif ($info['Changed'] == 0) {
                $second_booked = false;
           } else {
                $second_booked = true;
           }

        } else {
            throw new Exception("DB error, the data are not insert", 1);
        }


        /*
         * insert new record in booking table
         */
        if ($first_booked == true || $second_booked == true) {

            $book_insert_query = "INSERT INTO sito_web.booking(booking_id, booking_date, book_user_id) VALUES(DEFAULT, now(), $user_id)";

            if ($conn->query($book_insert_query)) {
                $book_ID = $conn->insert_id;
            } else {
                throw new Exception("Query not executed");
            }


            if ($first_booked == true) {
                $string_call = $conn->real_escape_string($first_choice);
                $book_insert_query = "INSERT INTO sito_web.user_book_call(username, callN, book_id, user_book_call_id) VALUES ('$user_string', $string_call, $book_ID, DEFAULT)";
                if (!$conn->query($book_insert_query)) {
                    throw new Exception("Data not insert in the database");
                }
            }

            if ($second_booked == true ) {
                $string_call = $conn->real_escape_string($second_choice);
                $book_insert_query = "INSERT INTO sito_web.user_book_call(username, callN, book_id, user_book_call_id) VALUES ('$user_string', $string_call, $book_ID, DEFAULT)";
                if (!$conn->query($book_insert_query)) {
                    throw new Exception("Data not insert in the database");
                }
            }

            $conn->commit();

        } else {
            return 2;
        }


        $db_response = ['first'=>$first_booked,
                        'second'=>$second_booked,
                        'bookingID'=>$book_ID];
        return 1;
    }

    function insert_new_user(){

    }

    function delete_booking($conn, $bookID, $user) {

        $string_bookID = $conn->real_escape_string($bookID);
        $string_user = $conn->real_escape_string($user);

        $delete_booking_query = "DELETE FROM sito_web.booking  WHERE booking_id = $string_bookID";
        $delete_call_query = "DELETE FROM sito_web.user_book_call WHERE book_id = $string_bookID";
        $select_callN_query = "SELECT callN FROM sito_web.user_book_call WHERE  book_id = $string_bookID AND username = '$string_user'";

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

            $insert_call_query = "SELECT exam_call.booked_seats FROM sito_web.exam_call WHERE exam_call.callN = $callN FOR UPDATE";
            $update_call_query  = "UPDATE sito_web.exam_call SET exam_call.booked_seats = exam_call.booked_seats - 1 WHERE exam_call.callN = $callN";

            if (!($query_result = $conn->query($insert_call_query) && $conn->query($update_call_query))) {
                throw new Exception("DB error, the data are not insert", 1);
            } else {
                $conn->commit();
            }

        }

        return 1;
    }
