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
                if (isset($_GET['dep-address']) && isset($_GET['arr-address'])
                    && isset($_GET["dep_exists"]) && isset($_GET["arr_exists"])
                    && isset($_GET["seats_number"])) {
                    $departure = $_GET['dep-address'];
                    $arrival = $_GET['arr-address'];
                    $departure_exists = $_GET["dep_exists"];
                    $arrival_exists = $_GET["arr_exists"];
                    $seats_number = $_GET["seats_number"];
                }
                else
                    throw new Exception("parameters passed are not valid", 1);

                break;

            case 'POST':
                if (isset($_POST['dep-address']) && isset($_POST['arr-address'])
                    && isset($_POST["dep_exists"]) && isset($_POST["arr_exists"])
                    && isset($_POST["seats_number"])) {
                    $departure = $_POST['dep-address'];
                    $arrival = $_POST['arr-address'];
                    $departure_exists = $_POST["dep_exists"];
                    $arrival_exists = $_POST["arr_exists"];
                    $seats_number  = $_POST["seats_number"];
                }
                else
                    throw new Exception("the parameters passed are not valid", 1);

                break;

            default:
                break;
        }
    } catch(Exception $e) {
        die($server_response['par_error']);
    }

    $mysql_conn = new mysqli(db_host, db_user, db_pwd, db_name);

    if($mysql_conn->connect_errno)
        die($server_response['db_error']);


    try {

        if (!$mysql_conn->autocommit(false))
            throw new Exception("Impossible to disable the autocommit");

        // strip all the parameter passed by the client and make lower case
        $stripped_departure  = strtolower($conn->real_escape_string($departure));
        $stripped_arrival = strtolower($conn->real_escape_string($arrival));

        $booking = new Booking($mysql_conn, $stripped_departure, $stripped_arrival);

        if ($departure_exists && $arrival_exists) {
            $mysql_conn->start_transaction();
            $booking->addressAlreadyExists($seats_number);
            $mysql_conn->commit();
        } else if ($departure_exists && !$arrival_exists) {
            $booking->departureAddressExists($seats_number);
        } else if (!$departure_exists && $arrival_exists) {
            $booking->arrivalAddressExists($seats_number);
        } else if (!$departure_exists && !$arrival_exists) {
            $booking->addressNotExists($seats_number);
        }


        $mysql_conn->close();

    } catch (Exception $e) {
        $mysql_conn->rollback();
        $mysql_conn->close();
        die($server_response['db_error']);
    } catch (DatabaseExpcetion $dbe) {
        $mysql_conn->rollback();
        $mysql_conn->close();
        die($server_response["db_error"]);
    }



