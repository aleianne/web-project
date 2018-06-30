<?php
    if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $redirect);
        exit();
    }
?>

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Minibus reservation system</title>

    <!-- Bootstrap Core CSS -->
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
    <script type="text/javascript" src="./js-library/jquery.js"></script>

    <!--leanModal library -->
    <script type="text/javascript" src="./js-library/jquery.leanModal.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="./js-library/bootstrap.min.js"></script>
</head>

<body>

<div id="wrapper">
    <!-- shadow anchor to activate the leanModal -->
    <a href="#login-container" rel="leanModal" style="display: none" id="login-trigger"></a>

    <!-- login form -->
    <div id="login-container" class="popup-container" style="display: none;">
        <header>
            <div id="header-div">
                <div></div>
                <div class="popup-title">
                    Login
                </div>
                <div>
                    <a id="close-login" class="modalclose" href="#"></a>
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

    <!-- purchase Skipass -->
<!--    <div id="booking-container" class="popup-container" style="display: none;">-->
<!--        <header>-->
<!--            <div id="header-div">-->
<!--                <div>-->
<!--                </div>-->
<!--                <div class="popup-title">-->
<!--                    Booking seats-->
<!--                </div>-->
<!--                <div>-->
<!--                    <a id="close-booking" class="modalclose" href="#"></a>-->
<!--                </div>-->
<!--        </header>-->
<!--        <section>-->
<!--            <form id="booking-form" class="form-inline">-->
<!--                <span class="label label-info">Departure</span>-->
<!--                <div id="departure-form" >-->
<!--                    <div class="input-group input-group-purchase departure-group elements-group">-->
<!--                        <span class="input-group-addon">-->
<!--                            <input id="departure-1" type="radio" aria-label="...">-->
<!--                        </span>-->
<!--                        <select id="departure-select" class="form-control" style="width: 239px">-->
<!--                        </select>-->
<!--                    </div>-->
<!--                    <div class="input-group input-group-purchase elements-group">-->
<!--                        <span class="input-group-addon">-->
<!--                            <input id="departure-2" type="radio" aria-label="...">-->
<!--                        </span>-->
<!--                        <input id="departure-box" type="text" class="form-control" aria-label="...">-->
<!--                    </div>-->
<!--                </div>-->
<!--                <span class="label label-info">Arrival</span>-->
<!--                <div id="arrival-form">-->
<!--                    <div class="input-group input-group-purchase">-->
<!--                        <span class="input-group-addon">-->
<!--                            <input id="arrival-1" type="radio" aria-label="...">-->
<!--                        </span>-->
<!--                       <select id="arrival-select" class="form-control" style="width: 239">-->
<!--                       </select>-->
<!--                    </div>-->
<!--                    <div class="input-group input-group-purchase">-->
<!--                        <span class="input-group-addon">-->
<!--                            <input id="arrival-2" type="radio" aria-label="...">-->
<!--                        </span>-->
<!--                        <input id="arrival-box" type="text" class="form-control" aria-label="...">-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div>-->
<!--                    <input id="seats-number" type="text" class="form-control" placeholder="seats number" aria-label="...">-->
<!--                </div>-->
<!--                <div class='action-box'>-->
<!--                    <div id="reservation-button" class="submit-btn">-->
<!--                        <a href="#">Purchase!</a>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </form>-->
<!--        </section>-->
<!--    </div>-->
<!--    <!-- end booking form -->

<!--    <!-- Sidebar -->
<!--    <div id="sidebar-wrapper">-->
<!--        <ul class="sidebar-nav">-->
<!--            <li class="sidebar-brand">-->
<!--                <a href="#">-->
<!--                    MENU-->
<!--                </a>-->
<!--            </li>-->
<!--            <li>-->
<!--                <a href="#" id="logout">Logout<img src="./images/icons8-Forward-48.png" id="arrow2"></a>-->
<!--            </li>-->
<!--            <li>-->
<!--                <a href="#booking-container" id="seats-booking" rel="leanModal">Booking Seats<img src="./images/icons8-Forward-48.png" id="arrow2"></a>-->
<!--            </li>-->
<!--            <li style="display: none;">-->
<!--                <a href="#login-container" id="login-form" rel="leanModal">-->
<!--                    Login-->
<!--                    <img src="./images/icons8-Forward-48.png" id="arrow">-->
<!--                </a>-->
<!--            </li>-->
<!--        </ul>-->
<!--    </div>-->
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <a href="#login-container" id="login-form" style="display: none" rel="leanModal"></a>
<!--        <!-- #toolbar -->
<!--        <div id="titlebar">-->
<!--            <div id="first-col"><img src="./images/icons8-Menu-48.png" id="sidebar-icon"></div>-->
<!--            <div id="title">BoosTrack</div>-->
<!--            <div id="third-col"></div>-->
<!--        </div>-->
<!--        <!-- #toolbar-wrapper -->


        <nav class="navbar navbar-default titlebar" style="border: none">
            <div class="container-fluid">
                <div class="pull-right collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <button type="button" class="btn btn-default btn-lg" id="logout-button">
                        Logout
                    </button>
                </div>
            </div>
        </nav>

        <noscript>
            <p style="margin-left: 10px">JavaScript is not enabled.</p>
        </noscript>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 id="home-page-title"></h1>
                    <p>Welcome into this bus booking system, on the left menu you can find a form to submit your booking and a form to delete a booking</p>
                    <!--<p>This template has a responsive menu toggling system. The menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will appear/disappear. On small screens, the page content will be pushed off canvas.</p>
                    <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>.</p>-->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p>
                        <button class="btn btn-primary" id="collapse-button" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Reserve Seats!
                        </button>
                    </p>
                    <div class="collapse booking-div container" id="collapseExample">
                        <form id="booking-form" class="form-inline">

                            <div class="row row-style" style="text-align: center"><h3><b>Seats Booking</b></h3></div>

                                    <div class="row row-style" id="departure-form" >
                                        <span>Departure address	&nbsp;	&nbsp;</span>
                                        <div class="input-group" style="margin-right: 2%">
                                            <span class="input-group-addon">
                                                <input id="departure-1" type="radio" aria-label="...">
                                            </span>
                                            <select id="departure-select" class="form-control">
                                            </select>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <input id="departure-2" type="radio" aria-label="...">
                                            </span>
                                            <input id="departure-box" type="text" class="form-control" aria-label="...">
                                        </div>
                                    </div>

                                    <div class="row row-style" id="arrival-form">
                                        <span>Arrival address	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;</span>
                                        <div class="input-group" style="margin-right: 2%">
                                        <span class="input-group-addon">
                                            <input id="arrival-1" type="radio" aria-label="..." >
                                        </span>
                                            <select id="arrival-select" class="form-control" >
                                            </select>
                                        </div>
                                        <div class="input-group">
                                        <span class="input-group-addon">
                                            <input id="arrival-2" type="radio" aria-label="...">
                                        </span>
                                            <input id="arrival-box" type="text" class="form-control" aria-label="...">
                                        </div>
                                    </div>


                                <div class="row row-style" >
<!--                                    <div>-->
<!--                                        <input id="seats-number" type="text" class="form-control" placeholder="seats number" aria-label="...">-->
<!--                                    </div>-->
<!--                                    <div class='action-box'>-->
<!--                                        <div id="reservation-button" class="submit-btn">-->
<!--                                            <a href="#">Purchase!</a>-->
<!--                                        </div>-->
<!--                                    </div>-->
                                    <div class="form-group" style="margin-right: 7%">
                                        <input id="seat-number" type="text" class="form-control" placeholder="Seats number">
                                    </div>
                                    <button id="reservation-button" type="submit" class="btn btn-default">Submit</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12" id="list-div">
                    <div>
                          <?php
                                require_once "model/db_request.php";
                                require_once "model/class/Exceptions.php";
                                require_once "model/class/ShowBooking.php";
                                require_once "model/class/RouteInfo.php";

//                                ini_set('display_errors', 'On');
//                                error_reporting(E_ALL);
                                 error_reporting(E_ERROR | E_PARSE);

                                session_start();

                                $mysql_conn = new mysqli(db_host,db_user, db_pwd, db_name);

                                if ($mysql_conn->connect_errno) {
                                    echo "<div class='panel panel-default'>";
                                    echo "<div class='panel-heading'><h3>Database error</h3></div>";
                                    echo "<div class='panel-body'></div>";
                                    echo "</div>";
                                } else {

                                    // TODO retrieve the username from the database
                                    $username = $_SESSION["s239846_user"];
                                    $show_booking = new ShowBooking($mysql_conn);

                                    try {
                                        // show all the routes
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
                                            echo "<div class='panel-heading' style='text-align: center'><b>Minibus routes<b><span class='pull-right glyphicon glyphicon-repeat' aria-hidden='true'></span></div>";
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

                                                $user = $show_booking->getUserPerRoute($begin_address, $end_address);
                                                $user_iterator = $user->getIterator();

                                                // print the table row into the screen
                                                echo "<tr data-toggle='collapse' data-target='#".$counter."' class='accordion-toggle'>";
                                                echo "<td>" . $counter . "</td>";
                                                echo "<td>" . $begin_address . "</td>";
                                                echo "<td>" . $end_address . "</td>";
                                                echo "<td>" . $booked_seats . "</td>";
                                                echo "<td><span class='glyphicon glyphicon-chevron-down'></span></td>";
                                                echo "</tr>";

                                                echo "<tr>";
                                                echo "<td colspan='6' style='padding: 0'>";
                                                echo "<div class='accordion-body collapse' id='".$counter."'>";

                                                while ($user_iterator->valid()) {

                                                    echo "<p><b>User: </b>".$user_iterator->current()->getUsername();
                                                    echo "	&nbsp;	&nbsp;";
                                                    echo "<b>Booked seats: </b>".$user_iterator->current()->getBookedSeats()."</p>";

                                                    $user_iterator->next();
                                                }

                                                echo "</div>";
                                                echo "</td>";
                                                echo "</tr>";

                                                $i->next();
                                            }

                                            echo "</table>";
                                            echo "</div>";
                                            echo "</div>";
                                        }
                                    } catch (DatabaseException $de) {
                                        echo "<div class='panel panel-default'>";
                                        echo "<div class='panel-heading'><h3>Database error</h3></div>";
                                        echo "<div class='panel-body'></div>";
                                        echo "</div>";
                                    }

                                    try {
                                        // show the booking made by the single user
                                        $result1 = $show_booking->showUserBooking($username);

                                        if ($result1->count() == 0) {
                                            // TODO show something
                                            echo "<div class='panel panel-default'>";
                                            echo "<div class='panel-heading'><h2>no booking</h2></div>";
                                            echo "<div class='panel-body'><p>no booking</p></div>";
                                            echo "</div>";

                                        } else {
                                            $j = $result1->getIterator();
                                            $counter = 0;
                                            echo "<div class='panel panel-default'>";
                                            echo "<div class='panel-heading' style='text-align: center'><b>Booking Table</b></div>";
                                            echo "<div class='panel-body'>";
                                            echo "<table class='table'>";

                                            echo "<tr class='row-style'>";
                                            echo "<td><b>#</b></td>";
                                            echo "<td><b>Booking ID</b></td>";
                                            echo "<td><b>Reserved Seats</b></td>";
                                            echo "</tr>";

                                            while($j->valid()) {

                                                $counter++;
                                                echo "<tr class='row-style'>";
                                                echo "<td>".$counter."</td>";
                                                echo "<td>".$j->current()->getBookingId()."</td>";
                                                echo "<td>".$j->current()->getReservedSeats()."</td>";
                                                echo "<td><span id='".$j->current()->getBookingId()."' class='pull-right glyphicon glyphicon-remove' aria-hidden='true'></span></td>";
                                                echo "</tr>";
                                                $j->next();
                                            }

                                            echo "</table>";
                                            echo "</div>";
                                            echo "</div>";

                                        }

                                    } catch (DatabaseException $de){
                                        echo "<div class='panel panel-default'>";
                                        echo "<div class='panel-heading'><h3>Database error</h3></div>";
                                        echo "<div class='panel-body'></div>";
                                        echo "</div>";
                                    }

                                    //close the connection
                                    $mysql_conn->close();
                                }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<script type="text/javascript" src="./js/booking_manager.js"></script>

<script type="text/javascript" src="./js/login.js"></script>

<script type="text/javascript" src="./js/DOM_controller_user_page.js"></script>

<script type="text/javascript" src="./js/dom_controller.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        var departure_radio1 = $("#departure-1");
        var departure_radio2 = $("#departure-2");
        var arrival_radio1 = $("#arrival-1");
        var arrival_radio2 = $("#arrival-2");

        var arrivalForm = $("#arrival-form");
        var departureForm = $("#departure-form");

        $("#reservation-button").click(function() {
            console.log("cioa");
            reserveSeats(departureForm, arrivalForm);
        });

        $("#booking-form").keydown(function(e) {
            if (e.keyCode === 13)
                reserveSeats(departureForm, arrivalForm);
        });

        $("#logout-button").click(function() {
            logout();
        });

        $(".glyphicon-repeat").click(function() {
            $("#list-div").load("./home.php #list-div");
            console.log("table reloaded")
        });


        $(".glyphicon-remove").click(function() {
            var booking_id = $(this).attr("id");
            submitDeletion(booking_id);
        });

        $("#login-btn").click(function () {
            loginSubmit();
        });

        $("#login-form").keydown(function(e) {
            if (e.keyCode === 13)
                loginSubmit();
        });

        $("#collapse-button").click(function() {
            var departureSelect = departureForm.find("#departure-select");
            var arrivalSelect = arrivalForm.find("#arrival-select");

            // before adding the new options delete the old one
            departureSelect.find('option').remove().end();
            arrivalSelect.find('option').remove().end();

            addOptionToSelect(departureSelect, arrivalSelect);
        });

        departureForm.find("#departure-1").click(function() {
            departure_radio1.prop("checked", true);
            departure_radio2.prop("checked", false);
        });

        departureForm.find("#departure-2").click(function() {
            departure_radio1.prop("checked", false);
            departure_radio2.prop("checked", true);
        });

        arrivalForm.find("#arrival-1").click(function() {
            arrival_radio1.prop("checked", true);
            arrival_radio2.prop("checked", false);
        });

        arrivalForm.find("#arrival-2").click(function() {
            arrival_radio1.prop("checked", false);
            arrival_radio2.prop("checked", true);
        });

        $("#close-login").click( function() {
            restoreOldValues();
        });

        $("#close-booking").click(function() {
            // todo da inserirre
        });

        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            console.log(decodedCookie);
            var ca = decodedCookie.split(';');
            for(var i = 0; i <ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }


        var value = getCookie("user_cookie");
        console.log(value);
        $("#home-page-title").val("Welcome " + value);

        /* The leanModal library is used to show a popup login or reg form */
        $("a[rel*=leanModal]").leanModal({top : 150, overlay : 0.6, closeButton: ".modalclose" });
    })
</script>

<script type="text/javascript">
    var x = navigator.cookieEnabled;
    var disable_page = "<div style='position: fixed; top: 0px; left: 0px; z-index: 3000; "+
        "height: 100%; width: 100%; background-color: #FFFFFF'>"+
        "<p style='margin-left: 10px'>Cookies are not enabled. To continue this page enable cookies</p>"+
        "</div>";
    if (x == false) {
        document.body.innerHTML = disable_page;
    }
</script>

</body>

</html>