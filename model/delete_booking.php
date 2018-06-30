<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 22/08/2017
 * Time: 19.28
 */

    require_once "db_request.php";
    require_once "http_control.php";
    require_once "class/DeleteBooking.php";

    $server_response = [
        'db_error'=>'err_1',
        'par_error'=>'err_2',
        'id_not_exist'=>'err_3',
        'time_error'=>'err_4',
        'session_error'=>'err_5',
        'invalid_delete'=>'err_6',
        'ok'=>'ok'
    ];

    /* start the session */
    session_start();

    if (isset($_SESSION)) {
        $user = $_SESSION['s239846_user'];

        if(is_inactive()) {
            die($server_response['time_error']);
        }

    } else {
        die($server_response['session_error']);
    }

    set_time_session();

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if (isset($_GET['booking_id']))
                $booking_id = $_GET['booking_id'];
            else
                die($server_response['par_error']);
            break;

        case 'POST':
            if (isset($_POST['booking_id']))
                $booking_id = $_POST['booking_id'];
            else
                die($server_response['par_error']);
            break;

        default:
            die($server_response['par_error']);
            break;
    }

    // check if the value passed is a number
    if (is_numeric($booking_id)) {
        if (!is_int($booking_id)) {
            $booking_id = strval($booking_id);
        }
    } else {
        die($server_response["par_for_err"]);
    }

    // create a new mysql connecion
    $mysql_conn = new mysqli(db_host, db_user, db_pwd, db_name);

    if($mysql_conn->connect_errno)
        die($server_response['db_error']);

    // disable the autocommit
    if (!$mysql_conn->autocommit(false))
        die($server_response['db_error']);

    try {
        $mysql_conn->begin_transaction();

        $delete_booking = new DeleteBooking($mysql_conn);
        $delete_booking->deleteBooking($booking_id);

        $mysql_conn->commit();

        $mysql_conn->close();
        die($server_response["ok"]);

    } catch (DatabaseExcpetion $e){
        $mysql_conn->rollback();
        $mysql_conn->close();
        die($server_response['db_error']);
    } catch (InvalidDeleteException $de) {
        $mysql_conn->rollback();
        $mysql_conn->close();
        die($server_response["invalid_delete"]);
    }
