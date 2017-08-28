<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 22/08/2017
 * Time: 19.28
 */

    include "db_request.php";
    include "http_control.php";

    $server_response = [
        'db_error'=>'err_1',
        'par_error'=>'err_2',
        'id_not_exist'=>'err_3',
        'time_error'=>'err_4',
        'session_error'=>'err_5',
        'ok'=>'ok'
    ];

    /* start the session */
    session_start();

    /* redirect the client to https protocol if not*/
    https_check();

    if (isset($_SESSION)) {
        $user = $_SESSION['user'];

        if(is_inactive()) {
            die($server_response['time_error']);
        }

    } else {
        die($server_response['session_error']);
    }

    set_time_session();

    try {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                if (isset($_GET['bookID'])) {
                    $bookID = $_GET['bookID'];
                }
                else {
                    throw new Exception("parameters passed are not valid", 1);
                }
                break;

            case 'POST':
                if (isset($_POST['bookID'])) {
                    $bookID = $_POST['bookID'];
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

    try {

        $mysql_conn = new mysqli(db_host, db_user, db_pwd, db_name);
        $mysql_conn->autocommit(false);
        $result = delete_booking($mysql_conn, $bookID, $user);
        //$result = delete_booking($mysql_conn, 5 , "alessandro");
        $mysql_conn->close();

        if ($result == 1){
            $response = $server_response['ok'];
        } else {
            $response = $server_response['id_not_exist'];
        }
        die($response);

    } catch (Exception $e){
        $mysql_conn->rollback();
        $mysql_conn->close();
        die($server_response['db_error']);
    }
