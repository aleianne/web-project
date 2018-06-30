<?php
    if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $redirect);
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Minibus reservation system</title>

<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"-->
<!--          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->

    <!-- Bootstrap Ccss CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Cuscss CSS -->
    <link href="./css/simple-sidebar.css" rel="stylesheet">

    <link href="./css/modal-window-style.css" rel="stylesheet">
    <link href="./css/page-main-container-style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery -->
    <script type="text/javascript" src="js-library/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="js-library/bootstrap.min.js"></script>

    <!--leanModal library -->
    <script type="text/javascript" src="js-library/jquery.leanModal.min.js"></script>

</head>

<body>
<div id="wrapper">

    <!-- login form -->
    <div id="login-container" class="popup-container" style="display: none;">
        <header>
            <div id="header-div">
                <div></div>
                <div class="popup-title">
                    Login
                </div>
                <div>
                    <a class="modalclose" href="#"></a>
                </div>
            </div>
        </header>
        <section>
            <form id="login-form">
                <div id="login-error-box" class="error-box"></div>
                <div id="login-input-box">
                    <input title="" type="text" name="email" placeholder="Email address"><br>
                    <input title="" type="password" name="password" placeholder="Password"><br>
                </div>
                <div class="action-box">
                    <div id="login-btn" class="submit-btn">
                        <a href="#">Login</a>
                    </div>
                </div>
            </form>
        </section>
    </div>
    <!-- end login form -->

    <!-- register form -->
    <div id="registration-container" class="popup-container" style="display: none;">
        <header>
            <div id="header-div">
                <div>
                </div>
                <div class="popup-title">
                    Registration
                </div>
                <div>
                    <a class="modalclose" href="#"></a>
                </div>
            </div>
        </header>
        <section>
            <form id="registration-form">
                <div id="registration-error-box" class="error-box">
                </div>
                <div id="registration-input-box">
                    <!--<input title="" type="text" name="name" placeholder="Name"><br>-->
                    <!--<input title="form-label" type="text" name="surname" placeholder="Surname"><br>-->
                    <input title="" type="text" name="email" placeholder="Email address"><br>
                    <input title="" type="password" name="first-password" placeholder="Password"><br>
                    <div id="password-strength-box" style="display: none;">
                        <p id="strength-string"></p>
                    </div>
                    <input title="" type="password" name="second-password" placeholder="Repeat password"><br>
                </div>
                <div class="action-box" style="clear: both">
                    <div id="register-btn" class="submit-btn">
                        <a href="#">Sign-up</a>
                    </div>
                </div>
            </form>
        </section>
    </div>
    <!-- end register form -->

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="#">
                    MENU
                </a>
            </li>
            <li>
                <a href="#login-container" id="login-form" rel="leanModal">
                    Login
                    <img src="./images/icons8-Forward-48.png" id="arrow">
                </a>
            </li>
            <li>
                <a href="#registration-container" id="registration-form" rel="leanModal">
                    Registration
                    <img src="./images/icons8-Forward-48.png" id="arrow">
                </a>
            </li>
            <li>
                <a href="#">
                    Contacts
                    <img src="./images/icons8-Forward-48.png" id="arrow">
                </a>
            </li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

<!--        <!-- #toolbar -->
<!--        <div id="titlebar">-->
<!--            <div id="first-col"><img src="./images/icons8-Menu-48.png" id="sidebar-icon"></div>-->
<!--            <div id="title">Exam call booking</div>-->
<!--            <div id="third-col"></div>-->
<!--        </div>-->
<!--        <!-- #toolbar-wrapper -->

<!---->
<!--        <nav class="navbar navbar-default titlebar">-->
<!--            <div class="container-fluid">-->
<!--                <div class="navbar-header">-->
<!--                    <a class="glyphicon glyphicon-menu-hamburger" id="menu-link"></a>-->
<!--                </div>-->
<!--            </div>-->
<!--        </nav>-->

       <nav class="navbar navbar-default titlebar" style="border: none">
        <div class="container-fluid">
            <div class="navbar-header">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <button type="button" class="btn btn-default btn-lg" id="menu-link">
                        <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Menu
                    </button>
                </div>
            </div>
        </div>
        </nav>

<!--        <nav class="navbar navbar-default">-->
<!--            <div class="container-fluid">-->
<!--                <div class="navbar-header">-->
<!--                    <a class="navbar-brand" href="#">-->
<!--                        <img src="./images/icons8-Menu-48.png" id="sidebar-icon">-->
<!--                    </a>-->
<!--                </div>-->
<!--            </div>-->
<!--        </nav>-->

        <div class="container-fluid">
            <!-- #first row: brief explanation  -->
            <div class="row">
                <div class="col-lg-12">
                    <h1>Welcome!</h1>
                    <p>This web side is developed for "Programmazione distribuita I" course of Politecnico di Torino.
                        <br>
                        The system can book the exam call of a generic IT course</p>
                    <!--<p>This template has a responsive menu toggling system. The menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will appear/disappear. On small screens, the page content will be pushed off canvas.</p>
                    <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>.</p>-->
                </div>
            </div>
            <!-- #sencond row: list the data retrieved from the server -->
            <div class="row">
                <div class="col-lg-12">
                    <!-- TODO AGGIUNGERE spazion nello span-->
                    <span></span>
                    <div id="table-div">

                    <?php
                        require_once "model/db_request.php";
                        require_once "model/class/Exceptions.php";
                        require_once "model/class/Route.php";
                        require_once "model/class/ShowBooking.php";
                        require_once "model/http_control.php";

                    //  ini_set('display_errors', 'On');
                    //  error_reporting(E_ALL);
                        error_reporting(E_ERROR | E_PARSE);

                        session_start();

                        $mysql_conn = new mysqli(db_host,db_user, db_pwd, db_name);

                        if ($mysql_conn->connect_errno) {
                            echo "<div class='panel panel-default'>";
                            echo "<div class='panel-heading'><h3>Database error</h3></div>";
                            echo "<div class='panel-body'><p> database error: ".$mysql_conn->connect_errno."</p></div>";
                            echo "</div>";
                        } else {
                            /* query the database to retrive the list of username*/
                            try {

                                $show_booking = new ShowBooking($mysql_conn);
                                $result_array = $show_booking->showAllRoutes();

                                if ($result_array->count() == 0) {
                                    /* div with no data */
                                    echo "<div class='panel panel-default'>";
                                    echo "<div class='panel-heading'><h3>Minibus Routes</h3></div>";
                                    echo "<div class='panel-body'><p>Minibus has no routes booked</p></div>";
                                    echo "</div>";
                                } else {
                                    $i = $result_array->getIterator();
                                    $counter = 0;

//                                echo "<div class='panel panel-default' style='margin 10px;'>";
//                                echo "<div class='panel-heading'><h3>Minibus routes</h3></div>";
//                                echo "<div class='panel-body'>";

                                    echo "<div class='panel panel-default'>";
                                    echo "<div class='panel-heading'><b>Minibus routes<b><span class='pull-right glyphicon glyphicon-repeat' aria-hidden='true'></span></div>";
                                    echo "<table class='table'>";

                                    echo "<tr class='row-style'>";
                                    echo "<td>#</td>";
                                    echo "<td>Departure address</td>";
                                    echo "<td>Arrival address</td>";
                                    echo "<td>Booked seats</td>";
                                    echo "</tr>";

                                    while ($i->valid()) {
                                        $counter++;
                                        $begin_address = $i->current()->getDepartureAddress();
                                        $end_address = $i->current()->getArrivalAddress();
                                        $booked_seats = $i->current()->getBookedSeats();

                                        // print the table row into the screen
                                        echo "<tr>";
                                        echo "<td>".$counter."</td>";
                                        echo "<td>".$begin_address."</td>";
                                        echo "<td>".$end_address."</td>";
                                        echo "<td>".$booked_seats."</td>";
                                        echo "</tr>";

                                        $i->next();
                                    }

                                    echo "</table>";
                                    echo "</div>";
                                    echo "</div>";
                                }



                            } catch (DatabaseException $dbe) {
                                echo "<div class='panel panel-default'>";
                                echo "<div class='panel-heading'><h3>Database error</h3></div>";
                                echo "<div class='panel-body'></p></div>";
                                echo "</div>";
                            }

                            // close the connection
                            $mysql_conn->close();
                        }

                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->


    <noscript>
        <p style="margin-left: 10px">JavaScript is not enabled.</p>
    </noscript>

</div>
<!-- /#wrapper -->


<!-- use the jquery, bootstrap and ajax library -->

<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"-->
<!--        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"-->
<!--        crossorigin="anonymous"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"-->
<!--        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"-->
<!--        crossorigin="anonymous"></script>-->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"-->
<!--        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"-->
<!--        crossorigin="anonymous"></script>-->

<!-- DOM object controller -->
<script type="text/javascript" src="js/dom_controller.js"></script>

<!-- login controller script  -->
<script type="text/javascript" src="./js/login.js"></script>

<!-- registration script -->
<script type="text/javascript" src="./js/registration.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        var registrationFormElement = $("#registration-form");
        var loginFormElement = $("#login-form");

        $("#register-btn").click(function () {
            registrationSubmit();
        });

        registrationFormElement.keydown(function(e) {
            if (e.keyCode === 13)
                registrationSubmit();
        });

        /* check the password strength  */
        registrationFormElement.find("input[name='first-password']").keyup(passwordRealTimeCheck);

        registrationFormElement.find("input[name='first-password']").on("paste", function(e) {
            console.log("pasted a password into the input box");
            passwordRealTimeCheck();
        });

        $("#login-btn").click(function () {
            loginSubmit();
        });

        loginFormElement.keydown(function(e) {
            if (e.keyCode === 13)
                loginSubmit();
        });

        loginFormElement.find("input[name='email']").on("paste", function(e) {
            console.log("pasted");
        });


        $(".modalclose").click( function() {
            restoreOldValues();
        });

        /* button for toggling the sidebar*/
        $("#menu-link").click(function (e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });

        /* The leanModal library is used to show a popup login or reg form */
        $("a[rel*=leanModal]").leanModal({top : 150, overlay : 0.6, closeButton: ".modalclose" });
    });
</script>


<script type="text/javascript">

    var x = navigator.cookieEnabled;
    var disable_page = "<div style='position: fixed; top: 0px; left: 0px; z-index: 3000; " +
        "height: 100%; width: 100%; background-color: #FFFFFF'>" +
        "<p style='margin-left: 10px'>Cookies are not enabled. To continue to use the page enable the cookies</p>" +
        "</div>";

    if (x === false)
        document.body.innerHTML = disable_page;


</script>

</body>

</html>
