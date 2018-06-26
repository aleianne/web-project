<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 20/06/2018
 * Time: 22.46
 */

class SeatsNotAvailableException extends Exception {

    public function __construct($message = "", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

class DatabaseException extends  Exception {

    public function __construct($message = "", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

class RecordNotFoundException extends Exception {

    public function __construct($message = "", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
