<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 21/08/2017
 * Time: 18.35
 */

    include "db_request.php";
    include "http_control.php";

    $server_response = [
      'db_error'=>'err_1',
      'forbidden'=>'err_2',
      'time_err'=>'err_3',
      'session_error'=>'err_4',
      'purchased'=>'ok'
    ];

    /* start a session */
    session_start();

    if (isset($_SESSION)) {
        $user = $_SESSION['user'];

        if(is_inactive()) {
            die($server_response['time_err']);
        }

    } else {
        die($server_response['session_error']);
    }

    set_time_session();

   try {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                if (isset($_GET['dep-address']) && isset($_GET['arr-address'])) {
                    $departure = $_GET['dep-address'];
                    $arrival = $_GET['arr-address'];
                }
                else {
                    throw new Exception("parameters passed are not valid", 1);
                }
                break;

            case 'POST':
                if (isset($_POST['dep-address']) && isset($_POST['arr-address'])) {
                    $departure = $_POST['dep-address'];
                    $arrival = $_POST['arr-address'];
                }
                else {
                    throw new Exception("the parameters passed are not valid", 1);
                }
                break;

            default:
                break;
        }
    } catch(Exception $e) {
        die($server_response['par_error']);
    }

    $mysql_conn = new mysqli(db_host, db_user, db_pwd, db_name);
    if($mysql_conn->connect_errno) {
        die($server_response['db_error']);
    }

    try {

        $result_array= "";
        if (!$mysql_conn->autocommit(false))
            throw new Exception("Impossible to disable the autocommit");

        $result_code = insert_purchase($mysql_conn, $user, $first_choice, $second_choice, $result_array);
        //$result_code = insert_booking($mysql_conn, "a@p.it", 1, 3, $result_array);
        $mysql_conn->close();

        // strip all the parameter passed by the client and make lower case
        $stripped_departure  = strtolower($conn->real_escape_string($departure));
        $stripped_arrival = strtolower($conn->real_escape_string($arrival));

        if ($result_code == 1) {
            /*$bookingID = $result_array['bookingID'];
            if ($result_array['first'] == true && $result_array['second'] == true) {
                $response_string = "Seats booked, the booking ID is : $bookingID";
            }
            if ($result_array['first'] == true && $result_array['second'] == false){
                $response_string = "Only the first choice is booked, the booking ID is: $bookingID";
            }
            if ($result_array['first'] == false && $result_array['second'] == true) {
                $response_string = "The first choice is not available, the booking ID is: $bookingID";
            } */
            die($server_response['purchased']);
        } else {
            die($server_response['forbidden']);
        }

        $mysql_conn->close();

    } catch (Exception $e) {
        $mysql_conn->rollback();
        $mysql_conn->close();
        die($server_response['db_error']);
    }



