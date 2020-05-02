<?php
session_start();
include('dbconnection.php');
if(!isset($_SESSION['reg_no'])){
    header('location:index.php');
}
$reg_no=$_SESSION['reg_no'];
$sql="select * from users where reg_no='$reg_no'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if($row['dp_status']==0){
                header('location: prof_pic.php');               
            }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>techSRIJAN'20 | Campus Ambassador</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="title" content="techSRIJAN'20 | Campus Ambassador">
    <meta name="description" content="The campus Ambassador website for techSRIJAN'20 conducted by IEEE student branch, MMMUT Gorakhpur.">
    <meta name="keywords" content="techsrijan, ca, campus ambassasdor, ieee, mmmut, gorkahpur">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    <meta name="revisit-after" content="1 days">
    <meta name="author" content="Aditya Kumar">
    <link rel="apple-touch-icon" sizes="57x57" href="images/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="60x60" href="images/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="72x72" href="images/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="76x76" href="images/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="114x114" href="images/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="120x120" href="images/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="144x144" href="images/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="152x152" href="images/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/favicon.ico">
    <link rel="icon" type="image/png" sizes="192x192" href="images/favicon/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon.ico">
    <link rel="icon" type="image/png" sizes="96x96" href="images/favicon/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon.ico">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="css/nouislider.css">

    <link rel="stylesheet" href="css/celtig.css">
    <link rel="stylesheet" href="css/abadon.css">
    <link rel="stylesheet" href="css/aunchanted.css">


    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="main-section">

        <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
            <div class="container">
                <a class="navbar-brand" href="index.html">
                    CA | <img src="images/favicon/ts_w.png" alt="">'20
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="oi oi-menu"></span> Menu
                </button>
                <div class="collapse navbar-collapse" id="ftco-nav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item d-flex">
                            <a class="nav-link d-flex align-items-center" href="home.php">Profile</a>
                        </li>
                        <li class="nav-item d-flex">
                            <a class="nav-link d-flex align-items-center" href="leaderboard.php">Leaderboard</a>
                        </li>
                        <?php
                                    if($reg_no == 2020000)
                                        echo '
                        <li class="nav-item d-flex">
                            <a class="nav-link d-flex align-items-center" href="admin.php">Admin</a>
                        </li>';
                        ?>
                        <li class="nav-item cta">
                            <a href="logout.php" class="btn btn-danger px-3 py-3 mb-2"><i class="ion-ios-power mr-2"></i>Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- END nav -->

        <section class="hero-wrap" style="background-image: url(images/home1.jpg);" data-stellar-background-ratio="0.5">
            <div class="overlay"></div>
            <div class="container">
                <div class="row description align-items-center justify-content-center">
                    <div class="col-md-8 text-center">
                        <div class="text">
                            <h2>Leaderboard</h2>
                            <h4 class="mb-5">Check your scores below</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- - - - - -end- - - - -  -->
        <section class="ftco-section text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover text-left" style="color: #fff;">
                                <thead>
                                    <tr style="font-size:20px;">
                                        <th>Rank</th>
                                        <th>Name</th>
                                        <th>College</th>
                                        <th>Year</th>
                                        <th>Score</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size:17px;">
                                    <?php 
                                    $_SESSION["result"]=mysqli_query($conn,"SELECT * FROM users ORDER BY score DESC, up_time ASC");
	                               if($_SESSION["result"])
	                               {
		                              $r=mysqli_num_rows($_SESSION["result"]);
	                               }
	                                   else die("Some error occured, please try later");
	                                   $t=1;
							         for($i=0;$i<555;$i++)
							         if($r)
							         {	$row=mysqli_fetch_array($_SESSION["result"],MYSQLI_ASSOC);
						              echo'<tr>
						              <td>'.$t.'</td>
						              <td>'.$row["username"].'</td>
						              <td>'.$row["college"].'</td>
						              <td>'.$row["year"].'</td>
						              <td>'.$row["score"].'</td>
						              </tr>';
						              $r--;
						              $t++;
							         }
                                    ?>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="ftco-section ftco-section-2">
            <div class="col-md-12 text-center">
                <p><a href="#"><i class="ion-ios-arrow-up"></i></a></p>
                <p class="mb-0">
                    Cypher &copy;<script>
                        document.write(new Date().getFullYear());

                    </script> All rights reserved | Designed with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://cypher-resume.herokuapp.com" target="_blank">Aditya</a>
                </p>
            </div>
        </footer>

    </div>

    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" /></svg></div>


    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/aos.js"></script>

    <script src="js/nouislider.min.js"></script>
    <script src="js/moment-with-locales.min.js"></script>
    <script src="js/bootstrap-datetimepicker.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>
