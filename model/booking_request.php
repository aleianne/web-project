<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 21/08/2017
 * Time: 18.35
 */

    require_once "./db_request.php";
    require_once "./http_control.php";
    require_once "./class/Exceptions.php";
    require_once "./class/Booking.php";

    $server_response = [
        'db_error'=>'err_1',
        'forbidden'=>'err_2',
        'time_err'=>'err_3',
        'session_error'=>'err_4',
        'server_error'=>'err_5',
        'par_for_err'=>'err_6',
        'par_err'=>'err_7',
        'address_err'=>'err_8',
        'purchased'=>'ok'
    ];


    /* start a session */
    session_start();

    if (isset($_SESSION)) {
        $user = $_SESSION['s239846_user'];

        if(is_inactive()) {
            die($server_response['time_err']);
        }

    } else {
        die($server_response['session_error']);
    }

    set_time_session();

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if (isset($_GET['dep_address']) && isset($_GET['arr_address'])
                && isset($_GET["dep_exists"]) && isset($_GET["arr_exists"])
                && isset($_GET["seats_number"])) {
                $departure = $_GET['dep_address'];
                $arrival = $_GET['arr_address'];
                $departure_exists = $_GET["dep_exists"];
                $arrival_exists = $_GET["arr_exists"];
                $seats_number = $_GET["seats_number"];
            }
            else
                die($server_response['par_error']);
            break;

        case 'POST':
            if (isset($_POST['dep_address']) && isset($_POST['arr_address'])
                && isset($_POST["dep_exists"]) && isset($_POST["arr_exists"])
                && isset($_POST["seats_number"])) {
                $departure = $_POST['dep_address'];
                $arrival = $_POST['arr_address'];
                $departure_exists = $_POST["dep_exists"];
                $arrival_exists = $_POST["arr_exists"];
                $seats_number  = $_POST["seats_number"];
            }
            else
                die($server_response['par_error']);
            break;

        default:
            die($server_response['par_error']);
            break;
    }

    // sanitize the input value
    $departure = strtolower(strip_tags($departure));
    $arrival = strtolower(strip_tags($arrival));
    $seats_number = strip_tags($seats_number);

    if (strcmp($departure, $arrival) == 1) {
        die($server_response["address_err"]);
    }

    if ($arrival_exists === "true") {
        $arrival_exists = true;
    } else if ($arrival_exists === "false") {
        $arrival_exists = false;
    } else {
        die($server_response["par_for_err"]);
    }

    if ($departure_exists === "true") {
        $departure_exists = true;
    } else if ($departure_exists === "false") {
        $departure_exists = false;
    } else {
        die($server_response["par_for_err"]);
    }

    // check if the value passed is a number
    if (is_numeric($seats_number)) {
        if (!is_int($seats_number)) {
            $seats_number = strval($seats_number);
        }
    } else {
        die($server_response["par_for_err"]);
    }

    // check the seats
    if ($seats_number > max_seats)
        die($server_response["forbidden"]);

    // create a new mysql connecion
    $mysql_conn = new mysqli(db_host, db_user, db_pwd, db_name);

    if($mysql_conn->connect_errno)
        die($server_response['db_error']);

    // disable the autocommit
    if (!$mysql_conn->autocommit(false))
        die($server_response['db_error']);

    try {
        // strip all the parameter passed by the client and make lower case
        $stripped_departure = $mysql_conn->real_escape_string($departure);
        $stripped_arrival = $mysql_conn->real_escape_string($arrival);

        $booking = new Booking($mysql_conn, $stripped_departure, $stripped_arrival, $user);

        // start a new transaction
        $mysql_conn->begin_transaction();

        $booking_id = 0;

        if ($departure_exists && $arrival_exists) {
            $booking_id = $booking->addressAlreadyExists($seats_number);
        } else if ($departure_exists && !$arrival_exists) {
            $booking_id = $booking->departureAddressExists($seats_number);
        } else if (!$departure_exists && $arrival_exists) {
            $booking_id = $booking->arrivalAddressExists($seats_number);
        } else if (!$departure_exists && !$arrival_exists) {
            $booking_id = $booking->addressNotExists($seats_number);
        }

        // commit the transaction
        $mysql_conn->commit();
        $mysql_conn->close();

        die(strval($booking_id));

    } catch (DatabaseException $dbe) {
        $mysql_conn->rollback();
        $mysql_conn->close();
        die($server_response["db_error"]);
    } catch (SeatsNotAvailableException $sne) {
        $mysql_conn->rollback();
        $mysql_conn->close();
        die($server_response["forbidden"]);
    } catch (InternalServerError $ise) {
        $mysql_conn->rollback();
        $mysql_conn->close();
        die($server_response["server_error"]);
    } catch (RecordNotFoundException $rnf) {
        $mysql_conn->rollback();
        $mysql_conn->close();
        die($server_response["server_error"]);
    }
//    catch(RecordNotFoundException $rne) {
//        $mysql_conn->rollback();
//        $mysql_conn->close();
//        die($server_response['db_error']);
//    }



