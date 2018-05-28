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

header('Access-Control-Allow-Origin: *');

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
                if (isset($_GET["name"]) && isset($_GET["email"]) && isset($_GET["1-pwd"]))
                    $reg_info = new registration($_GET["name"], $_GET["surname"], $_GET["email"], $_GET["1-pwd"]);
                else {
                    throw new Exception("parameters passed are not valid", 1);
                }
                break;

            case "POST":
                if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["1-pwd"]))
                    $reg_info = new registration($_POST["name"], $_POST["surname"], $_POST["email"], $_POST["1-pwd"]);
                else {
                    throw new Exception("the parameters passed are not valid", 1);
                }
                break;

            default:
                break;
        }
        $reg_info->check_registration();
    } catch(Exception $e) {
        die($server_response['param_err']);
    }

    $mysql_conn =  new mysqli(db_host, db_user, db_pwd, db_name);

    if ($mysql_conn->connect_errno) {
        error_log("DB error: ".$mysql_conn->connect_error,3,"/error_log.txt");
        $mysql_conn->close();
        die($server_response['db_err']);
    }

    /* sanitize the data received from the login page */
    $name = $mysql_conn->real_escape_string($reg_info->getName());
    $username = $mysql_conn->real_escape_string($reg_info->getUsername());

    /* define the string to query the database */
    $username_query = "SELECT web_user.username FROM web_user WHERE web_user.username = '$username'";
    $user_result = $mysql_conn->query($username_query);

    if (!empty($user_result->fetch_array())) {
        $mysql_conn->close();
        die($server_response['user_exits']);
    }

    /* generate new salt */
    $salt = uniqid(mt_rand(), true);

    /*generate password and the salt to be persisted in the database */
    $password = $mysql_conn->real_escape_string($reg_info->Hash_pwd($salt));
    $persisted_salt = $mysql_conn->real_escape_string((string) $salt);

    $insert_query = "INSERT INTO web_user(username, name, password, salt) "
        . "VALUES ('$username','$password', '$persisted_salt', '$name')";

    if ($mysql_conn->query($insert_query)) {
        session_setup($reg_info->getUsername());
        $response = $server_response["ok"];
    } else {
        $response = $server_response["db_err"];
    }

    $mysql_conn->close();
    die($response);





