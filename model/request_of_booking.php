<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 21/08/2017
 * Time: 18.35
 */

    require_once "db_request.php";
    require_once "http_control.php";
    require_once "Exceptions.php";

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
                die($server_response['par_error']);
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
                die($server_response['par_error']);
            break;

        default:
            die($server_response['par_error']);
            break;
    }

    // create a new mysql connecion
    $mysql_conn = new mysqli(db_host, db_user, db_pwd, db_name);

    if($mysql_conn->connect_errno)
        die($server_response['db_error']);

    // disable the autocommit
    if (!$mysql_conn->autocommit(false))
        die($server_response['db_error']);

    try {
        // strip all the parameter passed by the client and make lower case
        $stripped_departure = strtolower($mysql_conn->real_escape_string($departure));
        $stripped_arrival = strtolower($mysql_conn->real_escape_string($arrival));

        $booking = new Booking($mysql_conn, $stripped_departure, $stripped_arrival);

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

    } catch (DatabaseException $dbe) {
        $mysql_conn->rollback();
        $mysql_conn->close();
        die($server_response["db_error"]);
    } catch (SeatsNotAvailableException $sne) {
        $mysql_conn->rollback();
        $mysql_conn->close();
    } catch (Exception $e) {
        $mysql_conn->rollback();
        $mysql_conn->close();
        die($server_response['db_error']);
    }
//    catch(RecordNotFoundException $rne) {
//        $mysql_conn->rollback();
//        $mysql_conn->close();
//        die($server_response['db_error']);
//    }



