<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 17/08/2017
 * Time: 17.52
 */

    include "login.php";
    include "http_control.php";
    include "db_request.php";

    /*define ("db_user", "root");
    define ("db_host", "localhost");
    define ("db_port", 3306);
    define ("db_name", "sito_web");
    define ("db_pwd", "");*/

    $server_response = array('login_err'=>'err_1',
        'db_conn_err'=>'err_2',
        'pwd_err'=>'err_3',
        'db_err'=>'err_4',
        'param_err'=>'err_5',
        'ok_login'=>'ok'
        );

    /* begin the session */
    session_start();

    /* redirect the response on https if not */
    https_check();

    /* suppress all the warning generated by the script */
    error_reporting(E_ERROR | E_PARSE);

    try {
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                if (isset($_GET["email"]) && isset($_GET["pwd"])) {
                    $login_info = new login($_GET["email"], $_GET["pwd"]);
                }
                else
                    throw new Exception("Parameter are not complete", 1);
                break;

            case "POST":
                if (isset($_POST["email"]) && isset($_POST["pwd"]))
                    $login_info = new login($_POST["email"], $_POST["pwd"]);
                else
                    throw new Exception("Parameter are not complete", 1);
                break;

            default:
                break;
        }
        $login_info->check_cont();
    } catch (Exception $e) {
        die($server_response['param_err']);
    }

    /* check the user info inside the DB */
    $mysql_conn = new mysqli(db_host, db_user, db_pwd, db_name);

    if ($mysql_conn->connect_errno) {
        error_log("DB error: ".$mysql_conn->connect_error,3,"/error_log.txt");
        die($server_response['db_conn_err']);
    }

    /* create the sql query string */
    $escaped_string = $mysql_conn->real_escape_string($login_info->getUser());
    $query_string = "SELECT web_user.password, web_user.salt FROM sito_web.web_user WHERE web_user.username = '$escaped_string'";

    if ($query_result = $mysql_conn->query($query_string)) {

        $result_array = $query_result->fetch_array(MYSQLI_BOTH);
        $other_result = $query_result->fetch_array(MYSQLI_BOTH);

        if (!empty($other_result)) {
            $mysql_conn->close();
            die($server_response['db_err']);
        }

        if (empty($result_array)) {
            $response = $server_response['login_err'];
        } else {

            try {
                if ($result_array["password"] == $login_info->hash_pwd($result_array["salt"])) {
                    session_setup($login_info->getUser());
                    $response = $server_response['ok_login'];
                } else {
                    $response = $server_response['pwd_err'];
                }
            } catch (Exception $e) {
                $response = $server_response['db_err'];
                $mysql_conn->close();
            }

        }

    } else {
        $response = $server_response['db_err'];
        $mysql_conn->close();
    }

    // close the script and return the parameter to the client
    die($response);