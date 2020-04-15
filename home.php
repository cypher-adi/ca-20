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
    <script type="text/javascript">
        function ch_pic() {
            var x = document.getElementById("upload").innerHTML;
            document.getElementById("pic_but").innerHTML = x;
        }

    </script>

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
                            <h2>Profile</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- - - - - -end- - - - -  -->
        <section class="ftco-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <div class="image-wrap">
                            <img src="<?php echo $row['img_path'];?>" alt="Thumbnail Image" class="img-raised rounded-circle thumbnail img-fluid image">
                        </div>
                        <h2 class="heading-section mb-4">
                            <h3><strong style="text-transform: capitalize;"><?php echo $row['username'];?></strong></h3>
                        </h2>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled user_data">
                            <li>
                                <h5><strong>Registraion No. :&nbsp;</strong><span style="color:grey;"><?php echo "CA".$row['reg_no'];?></span></h5>
                            </li>
                            <li>
                                <h5><strong>Score :&nbsp; </strong><span style="color:#0f0;"><?php echo $row['score'];?></span></h5>
                            </li>
                            <li>
                                <h5><strong>Mobile No. :&nbsp; </strong><span style="color:grey;"><?php echo $row['mob_no'];?></span></h5>
                            </li>

                            <li>
                                <h5><strong>Email :&nbsp; </strong><span style="color:grey;"><?php echo $row['email'];?></span></h5>
                            </li>

                            <li>
                                <h5><strong>College :&nbsp; </strong><span style="color:grey;"><?php echo $row['college'];?></span></h5>
                            </li>

                            <li>
                                <h5><strong>City :&nbsp; </strong><span style="color:grey;"><?php echo $row['city'];?></span></h5>
                            </li>
                        </ul>
                        <div id="pic_but">
                            <button class="btn btn-round btn-primary" onclick="ch_pic()">Change Profile Picture</button>
                        </div>
                        <div id="upload" class="invisible">
                            <form action="upload.php" method="post" enctype="multipart/form-data">
                                <h4><strong>Select an image to upload</strong></h4>
                                <input type="file" name="fileToUpload" id="fileToUpload" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage"> <br>
                                Maximum size of Image should be 5MB.
                                <br><br><button class="btn btn-round btn-primary" type="submit" value="Upload Image" name="submit">Upload Image</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row row-content">
                    <div class="col-12">
                        <h2 class="text-center">POINTS SYSTEM</h2>
                        <div class="table-responsive">
                            <table class="table table-striped bg-light">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="text-center">S. No.</th>
                                        <th>Task</th>
                                        <th class="text-center">Points</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="text-center">1.</th>
                                        <td>Share our posts on your Facebook timeline and groups</td>
                                        <td class="text-info text-center">10/Share</td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">2.</th>
                                        <td>Put our posts (with caption and also tag @techsrijan.mmmut) as your
                                            Instagram Story</td>
                                        <td class="text-info text-center">20/Story</td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">3.</th>
                                        <td>Put our posts as your WhatsApp Status</td>
                                        <td class="text-info text-center">15/Status</td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">4.</th>
                                        <td>Share our posts on your WhatsApp Groups</td>
                                        <td class="text-info text-center">10/Share</td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">5.</th>
                                        <td>Display our posters on notice boards in your college campus</td>
                                        <td class="text-info text-center">50 Pts.</td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">6.</th>
                                        <td>Get students to register for techSRIJAN’20</td>
                                        <td class="text-info text-center">30/Register</td>
                                    </tr>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <td class="text-muted">50 or more registrations per day</td>
                                        <td class="text-info text-center">300 Pts. extra</td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">7.</th>
                                        <td>Get students to pay for techSRIJAN'20</td>
                                        <td class="text-info text-center">70/Payment</td>
                                    </tr>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <td class="text-muted">25 payments</td>
                                        <td class="text-info text-center">300 Pts. extra</td>
                                    </tr>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <td class="text-muted">50 payments</td>
                                        <td class="text-info text-center">500 Pts. extra</td>
                                    </tr>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <td class="text-muted">100 payments</td>
                                        <td class="text-info text-center">1000 Pts. extra</td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">8.</th>
                                        <td>Give us contact details of students/professors
                                            in charge of technical activities</td>
                                        <td class="text-info text-center">50/Contact</td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">9.</th>
                                        <td>Organize a briefing for your college students to inform them about
                                            techSRIJAN’20 (Video proof needed)</td>
                                        <td class="text-info text-center">150 Pts.</td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">10.</th>
                                        <td>Arrange for our publicity coordinator to meet with your Tech Group</td>
                                        <td class="text-info text-center">100 Pts.</td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">10.</th>
                                        <td>Send a mass mail to your college and bcc to the mail id
                                            email@gmail.com</td>
                                        <td class="text-info text-center">100 Pts.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <footer>
                            <span class="text-info">Note:- </span>
                            Mail all the screenshots at email@gmail.com (under the subject:
                            ”Screenshots of techSRIJAN tasks” ) so that we can evaluate all the points along with your Registration No.
                            (Example - CA2020XXXX).
                        </footer>
                    </div>
                    <div class="col-12 col-sm-3"></div>
                </div>
            </div>
        </section>

        <footer class="ftco-section ftco-section-2">
            <div class="col-md-12 text-center">
                <p><a href="#"><i class="ion-ios-arrow-up"></i></a></p>
                <p class="mb-0">
                    Copyright &copy;<script>
                        document.write(new Date().getFullYear());

                    </script> All rights reserved | Designed with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://cypher-resume.herokuapp.com" target="_blank">Cypher</a>
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
