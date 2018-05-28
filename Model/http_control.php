<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 18/08/2017
 * Time: 17.33
 */

define ("minute_2", 120);

/* use this function to check if the request is with HTTPS or HTTP  and redirect in case of simple HTTP */
function https_check() {
    if (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "off"){

    } else {
        // redirection to https
        $redirect = "https://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
        header("HTTP/1.1 301 Moved permanently");
        header("Location: ".$redirect);
        exit;
    }
};

/* use this function to initialize a session for the server */
function session_setup($username) {
    /* setup the session with the session parameters */
    $_SESSION["user"] = $username;
    $_SESSION["last_activity_time"] = time();

    /* send the cookies to the client */
    $cookie_name = 'user_cookie';
    $cookie_content = $username;

    setcookie($cookie_name, $cookie_content, time() + 1200);
}

/* evaluate the inactivity of the user */
function is_inactive() {

    $last_activity = $_SESSION['last_activity_time'];
    if ($last_activity + minute_2 < time()) {
        return true;
    } else {
        return false;
    }

}

function set_time_session() {
    $_SESSION['last_activity_time'] = time();
}