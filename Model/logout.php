<?php
/**
 * Created by PhpStorm.
 * User: utente pc
 * Date: 23/08/2017
 * Time: 17.52
 */


/*
 * logout the user
 */

session_start();

session_destroy();

echo "ok";
