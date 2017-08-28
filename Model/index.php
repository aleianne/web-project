<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Exam prenotation system</title>

    <!-- Bootstrap Ccss CSS -->
    <link href="/Layout/css/bootstrap.min.css" rel="stylesheet">

    <!-- Cuscss CSS -->
    <link href="/Layout/css/simple-sidebar.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>



    <div id="wrapper">

        <!-- login form -->
        <div id="login-container" class="popupContainer" style="display: none;">
            <header>
                <div id="header-div">
                    <div>
                    </div>
                    <div class="popup-title">
                        Login
                    </div>
                    <div>
                        <a class="modalclose" href="#"></a>
                    </div>
            </header>
            <section>
                <form id="login-form">
                    <div class="error-box"></div>
                    <div id="log-input-box">
                        <input title="" type="text" name="email" placeholder="Email address"><br>
                        <input title="" type="text" name="pwd" placeholder="Password"><br>
                    </div>
                    <div id="log-action-box">
                        <div id="login-btn" class="submit-btn">
                            <a href="#">Login</a>
                        </div>
                    </div>
                </form>
            </section>
        </div>
        <!-- end login form -->

        <!-- register form -->
        <div id="registration-container" class="popupContainer" style="display: none;">
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
                    <div class="error-box">
                    </div>
                    <div id="reg-input-box">
                        <input title="" type="text" name="name" placeholder="Name"><br>
                        <input title="form-label" type="text" name="surname" placeholder="Surname"><br>
                        <input title="" type="text" name="email" placeholder="Email address"><br>
                        <input title="" type="text" name="1-pwd" placeholder="Password"><br>
                        <div id="pwd-strength" style="display: none;">
                            <p id="strength-str"></p>
                        </div>
                        <input title="" type="text" name="2-pwd" placeholder="Repeat password"><br>
                    </div>
                    <div id="reg-action-box" style="clear: both">
                        <div id="register-btn" class="submit-btn">
                            <a class="register-link" href="#" >Sign-up</a>
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
                    <a href="#login-container" id="login-form" rel="leanModal">Login <img src="/Layout/image/icons8-Forward-48.png" id="arrow"></a>
                </li>
                <li>
                    <a href="#registration-container" id="registration-form" rel="leanModal">Registration<img src="/Layout/image/icons8-Forward-48.png" id="arrow"></a>
                </li>
                <li>
                    <a href="#">Contacts<img src="/Layout/image/icons8-Forward-48.png" id="arrow"></a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">

            <!-- #toolbar -->
            <div id="titlebar">
                <div id="first-col"><img src="/Layout/image/icons8-Menu-48.png" id="sidebar-icon"></div>
                <div id="title">Exam call booking</div>
                <div id="third-col"></div>
            </div>
            <!-- #toolbar-wrapper -->

            <div class="container-fluid">
                <!-- #first row: brief explanation  -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1> Welcome! </h1>
                        <p>This web side is developed for "Programmazione distribuita I" course of Politecnico di Torino. <br>
                            The system can book the exam call of a generic IT course</p>
                        <!--<p>This template has a responsive menu toggling system. The menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will appear/disappear. On small screens, the page content will be pushed off canvas.</p>
                        <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>.</p>-->
                    </div>
                </div>
                <!-- #sencond row: list the data retrieved from the server -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Students registered</h1>
                        <div>
                            <?php

                            include ("db_request.php");
                            define ("tot_num_call", 3);

                            /* query the database to retrive the list of username*/
                            try {

                                $mysql_conn = new mysqli(db_host,db_user, db_pwd, db_name, db_port );

                                if ($mysql_conn->connect_errno) {
                                    throw new Exception("Problem during the db connection");
                                }

                                $total_booked = 0;

                                for ($i = 1; $i <= tot_num_call ; $i++) {

                                    $list = request_list($mysql_conn, $i);
                                    if (empty($list)) {
                                        /* div with no data */
                                        echo "<div class='panel panel-default'>";
                                        echo "<div class='panel-heading'><h3>call n°".$i."</h3></div>";
                                        echo "<div class='panel-body'><p>no seats booked for this call</p></div>";
                                        echo "</div>";
                                        continue;
                                    }

                                    echo "<div class='panel panel-default' style='margin 10px;'>";
                                    echo "<div class='panel-heading'><h3>call n°".$i."</h3></div>";
                                    echo "<div class='panel-body'>";
                                    $j = 0;
                                    foreach($list as $value) {
                                        $j++;
                                        echo "<p>".$j."   ".$value."</p><br>";
                                    }

                                    $call_booked = sizeof($list);

                                    echo "<p class='string1'>Number of students for this call: ".$call_booked."</p>";
                                    echo "</div>";
                                    echo "</div>";

                                    $total_booked +=  $call_booked;
                                }

                                echo "<h2>Total number of students: ".$total_booked."</h2>";

                                $mysql_conn->close();

                            } catch (Exception $e) {
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

    <!-- jQuery -->
    <script type="text/javascript" src="/Logic/jquery.js"></script>

    <!--leanModal library -->
    <script type="text/javascript" src="/Logic/jquery.leanModal.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/Logic/bootstrap.min.js"></script>

    <!-- DOM object controller -->
    <script type="text/javascript" src="/Logic/DOM_controller.js"></script>

    <!--login js  -->
    <script type="text/javascript" src="/Logic/login.js"></script>

    <script type="text/javascript">
        var x = navigator.cookieEnabled;
        var disable_page = "<div style='position: fixed; top: 0px; left: 0px; z-index: 3000; "+
        "height: 100%; width: 100%; background-color: #FFFFFF'>"+
        "<p style='margin-left: 10px'>Cookies are not enabled. To continue to use the page enable the cookies</p>"+
        "</div>";
        if (x == false) {
            document.body.innerHTML = disable_page;
        }

    </script>

</body>

</html>
