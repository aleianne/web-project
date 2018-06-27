<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Skipass purchase system</title>

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
</head>

<body>

<div id="wrapper">

    <!-- shadow anchor to activate the leanModal -->
    <a href="#login-container" rel="leanModal" style="display: none" id="login-trigger"></a>

<!--    <!-- Gift SkiPass -->-->
<!--    <div id="delete-container" class="popup-container" style="display: none;">-->
<!--        <header>-->
<!--            <div id="header-div">-->
<!--                <div>-->
<!--                </div>-->
<!--                <div class="popup-title">-->
<!--                    Gift SkiPass-->
<!--                </div>-->
<!--                <div>-->
<!--                    <a class="modalclose" href="#"></a>-->
<!--                </div>-->
<!--        </header>-->
<!--        <section>-->
<!--            <form id="gift-form">-->
<!--                <div class="error-box"></div>-->
<!--                <div id="user-gift-input-box">-->
<!--                    <input title="" type="text" name="username" placeholder="username of the gift receiver"><br>-->
<!--                </div>-->
<!--                <div id="gift-action-box">-->
<!--                    <div id="gift-button" class="submit-btn" >-->
<!--                        <a href="#" id="delete" >Delete</a>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </form>-->
<!--        </section>-->
<!--    </div>-->
<!--    <!-- end delete form -->-->

    <!-- purchase Skipass -->
    <div id="booking-container" class="popup-container" style="display: none;">
        <header>
            <div id="header-div">
                <div>
                </div>
                <div class="popup-title">
                    Purchase SkiPass
                </div>
                <div>
                    <a class="modalclose" href="#"></a>
                </div>
        </header>
        <section>
            <form id="booking-form" class="form-inline">
                <span class="label label-info">Departure</span>
                <div id="departure-form">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <input id="departure-1" type="radio" aria-label="...">
                        </span>
                        <select id="departure-select" class="form-control">
                            <option>AA</option>
                            <option>BB</option>
                            <option>DD</option>
                            <option>EE</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <input id="departure-2" type="radio" aria-label="...">
                        </span>
                        <input id="departure-box" type="text" class="form-control" aria-label="...">
                    </div>
                </div>
                <span class="label label-info">Arrival</span>
                <div id="arrival-form">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <input id="arrival-1" type="radio" aria-label="...">
                        </span>
                       <select id="arrival-select" class="form-control">
                           <option>AA</option>
                           <option>BB</option>
                           <option>DD</option>
                           <option>EE</option>
                       </select>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <input id="arrival-2" type="radio" aria-label="...">
                        </span>
                        <input id="arrival-box" type="text" class="form-control" aria-label="...">
                    </div>
                </div>
                <div>
                    <input id="seats-number" type="text" class="form-control" placeholder="seats number" aria-label="...">
                </div>
                <div id="reservation-button" class="submit-btn">
                    <a href="#">Purchase!</a>
                </div>
            </form>
        </section>
    </div>
    <!-- end booking form -->

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="#">
                    MENU
                </a>
            </li>
            <li>
                <a href="#" id="logout">Logout<img src="./images/icons8-Forward-48.png" id="arrow2"></a>
            </li>
            <li>
                <a href="#booking-container" id="seats-booking" rel="leanModal">Booking Seats<img src="./images/icons8-Forward-48.png" id="arrow2"></a>
            </li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <!-- #toolbar -->
        <div id="titlebar">
            <div id="first-col"><img src="./images/icons8-Menu-48.png" id="sidebar-icon"></div>
            <div id="second-col">
                <form class="form-inline" style=" float: right; margin-right: 5px; margin-top: 5px;">
                    <div class="form-group">
                        <label class="sr-only" for="exampleInputAmount"></label>
                        <div class="input-group">
                            <div class="input-group-addon">User logged</div>
                            <input type="text" class="form-control" id="username-box" readonly>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- #toolbar-wrapper -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Exam call registration system</h1>
                    <p>Welcome to this exam booking system, on the left menu you can find a form to submit your booking and a form to delete a booking</p>
                    <!--<p>This template has a responsive menu toggling system. The menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will appear/disappear. On small screens, the page content will be pushed off canvas.</p>
                    <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>.</p>-->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12" id="list-div">
                    <h1>Students registered</h1>
                    <div>
                          <?php
//
//                        include("./model/db_request.php");
//                        define ("tot_num_call", 3);
//
//                        /* query the database to*/
//                        try {
//
//                            $mysql_conn = new mysqli(db_host,db_user, db_pwd, db_name);
//
//                            if ($mysql_conn->connect_errno) {
//                                throw new Exception("Problem during the db connection");
//                            }
//
//                            $total_booked = 0;
//
//                            for ($i = 1; $i <= tot_num_call ; $i++) {
//
//                                $list = request_list($mysql_conn, $i);
//                                if (empty($list)) {
//                                    /* div with no data */
//                                    echo "<div class='panel panel-default'>";
//                                    echo "<div class='panel-heading'><h3>call n°".$i."</h3></div>";
//                                    echo "<div class='panel-body'><p>no seats booked for this call</p></div>";
//                                    echo "</div>";
//                                    continue;
//                                }
//
//                                echo "<div class='panel panel-default' style='margin 10px;'>";
//                                echo "<div class='panel-heading'><h3>call n°".$i."</h3></div>";
//                                echo "<div class='panel-body'>";
//                                $j = 0;
//                                foreach($list as $value) {
//                                    $j++;
//                                    echo "<p>".$j."   ".$value."</p><br>";
//                                }
//                                $call_booked = sizeof($list);
//
//                                echo "<p class='string1'>Number of students for this call: ".$call_booked."</p>";
//                                echo "</div>";
//                                echo "</div>";
//
//                                $total_booked += $call_booked;
//                            }
//
//                            echo "<h2>Total number of students: ".$total_booked."</h2>";
//
//                            $mysql_conn->close();
//
//                        } catch (Exception $e) {
//                            $mysql_conn->close();
//                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->



<!-- Bootstrap Core JavaScript -->
<script type="text/javascript"src="./js-library/bootstrap.min.js"></script>

<script type="text/javascript" src="js/booking_manager.js"></script>

<script type="text/javascript" src="./js/login.js"></script>

<script type="text/javascript" src="./js/DOM_controller_user_page.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        var departure_radio1 = $("#departure-1");
        var departure_radio2 = $("#departure-2");
        var arrival_radio1 = $("#arrival-1");
        var arrival_radio2 = $("#arrival-2");

        $("#reservation-button").click(function() {
            reserveSeats();
        });

        $("#logout").click(function() {
            logout();
        });

        departure_radio1.click(function() {
            departure_radio1.prop("checked", true);
            departure_radio2.prop("checked", false);
        });

        departure_radio2.click(function() {
            departure_radio1.prop("checked", false);
            departure_radio2.prop("checked", true);
        })

        arrival_radio1.click(function() {
            arrival_radio1.prop("checked", true);
            arrival_radio2.prop("checked", false);
        })

        arrival_radio2.click(function() {
            arrival_radio1.prop("checked", false);
            arrival_radio2.prop("checked", true);
        })

        $(".modalclose").click(restoreOldValues2());
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