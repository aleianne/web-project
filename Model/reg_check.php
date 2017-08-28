<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 17/08/2017
 * Time: 17.52
 */

    /* php script to check the login info sent by the client */
    include "registration.php";
    include  "http_control.php";
    include "db_request.php";

    /*define ("db_user", "root");
    define ("db_host", "localhost");
    define ("db_port", 3306);
    define ("db_name", "sito_web");
    define ("db_pwd", "");*/

    $server_response = array('db_err'=>'err_1',
                            'user_exits'=>'err_2',
                            'param_err'=>'err_3',
                            'ok'=>'ok'
    );

    /* begin the session */
    session_start();

    /* redirect the client to the https protocol if not */
    https_check();

    /* suppress all the waring generated by the script */
    error_reporting(E_ERROR | E_PARSE);

    try {
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                if (isset($_GET["name"]) && isset($_GET["surname"]) && isset($_GET["email"]) && isset($_GET["1-pwd"]))
                    $reg_info = new registration($_GET["name"], $_GET["surname"], $_GET["email"], $_GET["1-pwd"]);
                else {
                    throw new Exception("parameters passed are not valid", 1);
                }
                break;

            case "POST":
                if (isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["email"]) && isset($_POST["1-pwd"]))
                    $reg_info = new registration($_POST["name"], $_POST["surname"], $_POST["email"], $_POST["1-pwd"]);
                else {
                    throw new Exception("the parameters passed are not valid", 1);
                }
                break;

            default:
                break;
        }
        $reg_info->check_cont();
    } catch(Exception $e) {
        die($server_response['param_err']);
    }

    $mysql_conn =  new mysqli(db_host, db_user, db_pwd, db_name);

    if ($mysql_conn->connect_errno) {
        error_log("DB error: ".$mysql_conn->connect_error,3,"/error_log.txt");
        $mysql_conn->close();
        die($server_response['db_err']);
    }

    try {
        /* define the string to query the database */
        $username_string = $mysql_conn->real_escape_string($reg_info->getUsername());
        $username_query = "SELECT sito_web.web_user.username FROM web_user WHERE sito_web.web_user.username = '$username_string'";
        $user_result = $mysql_conn->query($username_query);

        if (!empty($user_result->fetch_array())) {
            die($server_response['user_exits']);
        }

        /* generate new salt */
        $salt = uniqid(mt_rand(), true);

        /*generate the string to be persisted in the database */
        $name = $mysql_conn->real_escape_string($reg_info->getName());
        $surname = $mysql_conn->real_escape_string($reg_info->getSurname());
        $username = $mysql_conn->real_escape_string($reg_info->getUsername());
        $password = $mysql_conn->real_escape_string($reg_info->Hash_pwd($salt));
        $persisted_salt = $mysql_conn->real_escape_string((string) $salt);

        $insert_query = "INSERT INTO sito_web.web_user(username, password, salt, name, surname) "
            . "VALUES ('$username','$password', '$persisted_salt', '$name', '$surname')";

        if ($mysql_conn->query($insert_query)) {
            session_setup($reg_info->getUsername());
        } else {
            throw new Exception("error during the persistence of the data");
        }

        die($server_response['ok']);

    } catch (Exception $e) {
        $mysql_conn->close();
        die($server_response['db_err']);
    }


