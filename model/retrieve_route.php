<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 30/06/2018
 * Time: 10.40
 */

require_once "class/RouteDAO.php";
require_once "db_request.php";


// create a new mysql connecion
$mysql_conn = new mysqli(db_host, db_user, db_pwd, db_name);

if($mysql_conn->connect_errno)
    die("err_1");

try {

    $route_dao = new RouteDAO($mysql_conn);
    $retrieved_array = $route_dao->readAllRoute();

    $new_array = array();
    $i = $retrieved_array->getIterator();

    while($i->valid()) {
        array_push($new_array, $i->current()->getDepartureAddress());
        array_push($new_array, $i->current()->getArrivalAddress());
        $i->next();
    }

    // sort and delete replicated value in the retrieved array;
    $array1 = array_unique($new_array);
    asort($array1);

    $json = json_encode($array1);
    die($json);

} catch (DatabaseException $de) {
    $mysql_conn->close();
    die("err_1");
}