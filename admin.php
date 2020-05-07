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
if($row['admin'] == 0){
                header('location: home.php');               
            }

$error_log=false;
if(isset($_POST['update'])){
    $email = trim($_POST['email']);
    $email = htmlspecialchars(strip_tags($email));

    $value = trim($_POST['value']);
    $value = (int)$value;

    if(empty($email)){
        $error_log = true;
        $errorEmail = 'Please input email';
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error_log = true;
        $errorEmail = 'Please enter a valid email address';
    }

    if(empty($value)){
        $error_log = true;
        $errorValue = 'Please enter value';
    }

    if(!$error_log){
      
        $sql = "select * from users where email='$email' ";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);
        if($count==1){
            $value = $row['score']+ $value;           
            $sql_up="UPDATE users SET score='".$value."' ,up_time='".date("Y-m-d H:i:s")."' WHERE email='".$row['email']."'";
            mysqli_query($conn, $sql_up);
            $errorMsg = "User updated";
            
        }
        else{
            $errorMsg = "User not found";
        }
       

    }
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
                            <h2>Admin</h2>
                            <h4 class="mb-5">Update Score</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- - - - - -end- - - - -  -->
        <section class="ftco-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="x_title">
                            <h3>Update Score</h3>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                            <div class="card-body pb-4 pt-2">
                                <?php
                                                if(isset($errorMsg)){echo $errorMsg; }
                                                if(isset($errorEmail)){ echo $errorEmail;} 
                                                if(isset($errorValue)){ echo $errorValue;}
                                            ?>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="ion-ios-contact"></i>
                                        </span>
                                    </div>
                                    <input type="email" class="form-control" placeholder="Email" name="email" required>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="ion-ios-add-circle"></i>
                                        </span>
                                    </div>
                                    <input type="number" class="form-control" placeholder="Value..." name="value" required>
                                </div>
                            </div>
                            <div class="footer text-center mb-2">
                                <input type="submit" value="update" name="update" class="btn btn-primary btn-round px-5">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-6">
                        <div class="x_title">
                            <h3>Search Record</h3>
                            <div class="clearfix">Enter Email or Reg. No. Below</div>
                        </div>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                            <div class="card-body pb-4 pt-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="ion-ios-contact"></i>
                                        </span>
                                    </div>
                                    <input type="email" class="form-control" placeholder="Email" name="emailf">
                                </div>
                            </div>
                            <div class="clearfix text-center">OR</div>
                            <div class="card-body pb-4 pt-2">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="ion-ios-contact"></i>
                                        </span>
                                    </div>
                                    <input type="number" class="form-control" placeholder="Reg. No." name="reg_nof">
                                </div>
                            </div>
                            <div class="footer text-center mb-2">
                                <input type="submit" value="Search" name="search" class="btn btn-primary btn-round px-5">
                                <input type="submit" value="Reset" name="reset" class="btn btn-primary btn-round px-5 ml-5">
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <?php
                            $error_log=false;
                            $countf=0;
                            if(isset($_POST['search'])){
                                $emailf = trim($_POST['emailf']);
                                $emailf = htmlspecialchars(strip_tags($emailf));

                                $reg_nof = trim($_POST['reg_nof']);
                                $reg_nof = htmlspecialchars(strip_tags($reg_nof));

                                if(empty($emailf) && empty($reg_nof)){
                                    $error_log = true;
                                    $errorMsg = 'Please input email / reg. no.';
                                }elseif(!empty($emailf) && !filter_var($emailf, FILTER_VALIDATE_EMAIL)){
                                    $error_log = true;
                                    $errorMsg = 'Please enter a valid email address';
                                }

                                if(!$error_log){

                                    $sqlf = "select * from users where email='$emailf' or reg_no='$reg_nof' ";
                                    $resultf = mysqli_query($conn, $sqlf);
                                    $countf = mysqli_num_rows($resultf);
                                    $rowf = mysqli_fetch_assoc($resultf);
                                    if($countf==1){
                                        $errorMsg = "User Found";
                                        echo '
                                            <div class="card" style="width: 20rem; margin: auto">
                                            <img class="card-img-top" src="'.$rowf['img_path'].'" alt="Card image cap">
                                            <div class="card-body bg-dark">
                                            <h5 class="card-title">Name: '.$rowf['username'].'</h5>
                                            <p class="card-text">
                                                Reg. No: '.$rowf['reg_no'].' <br/>
                                                Score: '.$rowf['score'].' <br/>
                                                Email: '.$rowf['email'].' <br/>
                                                Mob. No: '.$rowf['mob_no'].' <br/>
                                                College: '.$rowf['college'].' <br/>
                                                City: '.$rowf['city'].' <br/>
                                            </p>
                                            </div>
                                            </div>';
                                    }
                                    else{
                                        $errorMsg = "User not found";
                                    }
                                    echo '<div class="text-center">'; if(isset($errorMsg) && $countf == 0){echo $errorMsg; } echo '</div>';
                                    
                                    }
                                }
                                if(isset($_POST['reset'])){
                                    $error_log=false;
                                    $countf=0;
                                }
                        ?>
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
