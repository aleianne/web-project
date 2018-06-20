<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 20/06/2018
 * Time: 22.46
 */

class SeatsNotAvailableExcpetions extends Exception {

    public function __construct($message = "", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

class DatabaseExpcetion extends  Exception {

    public function __construct($message = "", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}