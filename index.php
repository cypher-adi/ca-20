<?php
session_start();


include_once('dbconnection.php');
if(isset($_SESSION['reg_no']))
{
    header('location:home.php');
}
function encrypt_decrypt($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'key';
    $secret_iv = 'iv';

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}
$error_reg=false;
if(isset($_POST['register'])){
    
     $username = $_POST['username'];
    $username = strip_tags($username);
    $username = htmlspecialchars($username);

    $email = $_POST['email'];
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $password = $_POST['password'];
    $password = strip_tags($password);
    $password = htmlspecialchars($password);
    
    $mob_no = trim($_POST['mob_no']);
    $mob_no = htmlspecialchars(strip_tags($mob_no));
    $year = trim($_POST['year']);
    $year = htmlspecialchars(strip_tags($year));
    $college = trim($_POST['college']);
    $college = htmlspecialchars(strip_tags($college));
    $city = trim($_POST['city']);
    $city = htmlspecialchars(strip_tags($city));
   

    //validate
    if(empty($username)){
        $error_reg = true;
        $errorUsername = 'Please input username';
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error_reg = true;
        $errorEmail = 'Please a valid input email';
    }

    if(empty($password)){
        $error_reg = true;
        $errorPassword = 'Please password';
    }elseif(strlen($password) < 6){
        $error_reg = true;
        $errorPassword = 'Password must at least 6 characters';
    }
    if(empty($mob_no)){
        $error_reg = true;
        $errormob_no = 'Please input mob_no';
    }elseif(is_numeric($mob_no)) {
       if(strlen($mob_no) !=10)
       {
        $error_reg = true;
        $errormob_no = 'Mobile Number must of 10 digits';
       }
    }else{
         $error_reg = true;
        $errormob_no = 'Mobile Number must be a numerical value';
    }
    
    
    if(empty($year)){
        $error_reg = true;
        $erroryear = 'Please select year';
    }
     
    if(empty($college)){
        $error_reg = true;
        $errorcollege = 'Please input college';
    }
     
    if(empty($city)){
        $error_reg = true;
        $errorcity = 'Please input city';
    }
    $hash=md5($password);
    //insert data if no error
    if(!$error_reg){
        
        $sql1 = "select * from users where email='$email' ";
        $result = mysqli_query($conn, $sql1);
        $count = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);
        if($count==1)
        { 
            $msg= "This email has already been registerd.";
                     
        }
        elseif($count==0) 
        {
        $sql = "insert into users(username, email ,password,mob_no,year,college,city,hash)
                values('$username', '$email', '$password','$mob_no','$year','$college','$city','$hash')";
            $msg= "You are succesfully registered login now.";
        if(mysqli_query($conn, $sql))
           {
             $reg_no=mysqli_query($conn,"select * from users where email='$email'");
            $reg_no=mysqli_fetch_assoc($reg_no);
            $reg_no=$reg_no['reg_no'];
            $reg_no=encrypt_decrypt('encrypt',$reg_no);
            
        mysqli_query($conn,"UPDATE users SET active='1' WHERE email='$email'") or die(mysqli_error);
        }
        }
     }
}
$error_log=false;
if(isset($_POST['login'])){
    $email = trim($_POST['email']);
    $email = htmlspecialchars(strip_tags($email));

    $password = trim($_POST['password']);
    $password = htmlspecialchars(strip_tags($password));

    if(empty($email)){
        $error_log = true;
        $errorEmail1 = 'Please input email';
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error_log = true;
        $errorEmail1 = 'Please enter a valid email address';
    }

    if(empty($password)){
        $error_log = true;
        $errorPassword1 = 'Please enter password';
    }elseif(strlen($password)< 6){
        $error_log = true;
        $errorPassword1 = 'Invalid Email or Password';
    }

    if(!$error_log){
      
        $sql = "select * from users where email='$email' ";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);
        $row['username']=strtoupper($row['username']);
        if($count==1 && $row['password'] == $password && $row['active']==1){
            $_SESSION['username'] = $row['username'];
            $_SESSION['reg_no']=$row['reg_no'];
            if($row['dp_status']==0){
                header('location: prof_pic.php');               
            }else{
                header('location:home.php');
            }
            
        }elseif ($count==1 && $row['password'] == $password && $row['active']==0) {
         echo "Please activate your account. Contact Admin.";
        }else {
           
                   $errorMsg = 'Invalid Email or Password';
        }
       

    }
}

?>




<!DOCTYPE html>
<html lang="en" style="scroll-behavior: smooth;">

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
                <button class=" navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="oi oi-menu"></span> Menu
                </button>
                <div class="collapse navbar-collapse" id="ftco-nav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item d-flex">
                            <a class="nav-link d-flex align-items-center" href="#">Home</a>
                        </li>
                        <li class="nav-item d-flex">
                            <a class="nav-link d-flex align-items-center" href="#faqs">FAQs</a>
                        </li>
                        <li class="nav-item d-flex">
                            <a class="nav-link d-flex align-items-center" href="#perks">Perks</a>
                        </li>
                        <li class="nav-item d-flex">
                            <a class="nav-link d-flex align-items-center" href="#response">Responsibilities</a>
                        </li>
                        <li class="nav-item d-flex">
                            <a class="nav-link d-flex align-items-center" href="#register">Register</a>
                        </li>
                        <li class="nav-item cta">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalCenter">Login</button>
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
                            <h2>Campus Ambassador</h2>
                            <h4 class="mb-5">Become the Leader of your College</h4>
                            <p>
                                <a href="#register" class="btn btn-primary px-5 py-4 mb-2"><i class="ion-ios-person mr-2"></i>Register</a>
                                <!--  						<a href="#" class="btn btn-dark px-5 py-4 mb-2"><i class="ion-ios-code mr-2"></i>Components</a>-->
                            </p> <br>
                            <p>
                                <a href="#faqs"><i class="ion-ios-arrow-down"></i></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END header -->


        <section class="ftco-section text-center" id="info">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-info">WHAT IS <span style="font-family: 'CELTG';text-transform: lowercase;" class="text-info">t<span style="font-family: 'Conv_abaddon'; " class="text-info">ech<span style="font-family: 'Conv_AunchantedBold';text-transform: uppercase;" class="text-info">SRIJAN </span></span></span>?</h2>
                        <p>
                            Madan Mohan Malaviya University of Technology, Gorakhpur has been a benchmark in imparting technical experience for the last 58 years. For the past 20 years the IEEE Student Branch along with SAE India Collegiate Club of the University has been organising the annual techno management fest of MMMUT, techsrijan to patronise technical excellence and innovation. techsrijan witnesses a footfall of over 3000 people across the nation.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- END intro -->


        <section class="ftco-section" id="faqs">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center text-info">FAQs</h2>
                        <div id="accordion" class="myaccordion w-100 text-center">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="d-flex align-items-center justify-content-between btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            What is CA?
                                            <i class="fa" aria-hidden="true"></i>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body text-left">
                                        <p>A campus ambassador is the one responsible for the outreach and publicity of the festival in their college. Simply put, you would be the face of the festival as well as MMMUT itself for the students in your college</p>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Who can become a Campus Ambassador?
                                            <i class="fa" aria-hidden="true"></i>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="card-body text-left">
                                        <p>Any College Student with a valid College Student Identity Card.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h2 class="mb-0">
                                        <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            How to become a College Ambassador?
                                            <i class="fa" aria-hidden="true"></i>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body text-left">
                                        <p>Simply login on the College Ambassador Portal. You can initiate your registration process by clicking on the "Register" button at the opening page.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h2 class="mb-0">
                                        <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            How many CAs can be there from a college?
                                            <i class="fa" aria-hidden="true"></i>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                                    <div class="card-body text-left">
                                        <p>Team techSRIJAN can appoint more than one College Ambassador from the same college if the student participation from that college is large enough. Your appointment will be confirmed via a call after the registrations close. Incase of multiple applications, Campus Ambassadors may be selected on the basis of their performance in a short task given by team techsrijan,2020.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h2 class="mb-0">
                                        <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                            What are the conditions under which I will get a CA Certificate?
                                            <i class="fa" aria-hidden="true"></i>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                                    <div class="card-body text-left">
                                        <p>In order to get a CA Certificate, College Ambassadors will have to earn more than the minimum Cut-off points which would be set by team techsrijan,MMMUT GORAKHPUR.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h2 class="mb-0">
                                        <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                            What if I fail to do my assigned task?
                                            <i class="fa" aria-hidden="true"></i>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
                                    <div class="card-body text-left">
                                        <p>The representation can be revoked at any time if the you fails to perform assigned task.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="text-center"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#rules">RULES</button></div><br>
        <!-- END FAQs -->

        <section class="ftco-section ftco-no-pt ftco-no-pb" id="carousel">
            <div class="container-fluid px-0" id="perks">
                <div class="row no-gutters justify-content-center">
                    <div class="col-md-12">
                        <h2 class="text-center text-info">Perks</h2>
                        <div id="demo" class="carousel slide" data-ride="carousel">

                            <!-- The slideshow -->
                            <div class="carousel-inner">
                                <div class="carousel-item active img">
                                    <div class="overlay"></div>
                                    <div class="container">
                                        <div class="row slider-text px-4 d-flex align-items-center justify-content-center">
                                            <div class="col-md-8 text w-100 text-center">
                                                <u>
                                                    <h3 class="mb-4">IMPROVE YOUR SKILLSET</h3>
                                                </u>
                                                <p>An opportunity to improve your communication skills by interacting with people coming from diverse fields. Click on the right button to know more about what you get!</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item img">
                                    <div class="overlay"></div>
                                    <div class="container">
                                        <div class="row slider-text px-4 d-flex align-items-center justify-content-center">
                                            <div class="col-md-8 text w-100 text-center">
                                                <u>
                                                    <h3 class="mb-4">ACCOMMODATION DURING THE FEST</h3>
                                                </u>
                                                <p>Campus Ambassador of various colleges will get free accommodation, boarding and lodging during techsrijan 2020.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item img">
                                    <div class="overlay"></div>
                                    <div class="container">
                                        <div class="row slider-text px-4 d-flex align-items-center justify-content-center">
                                            <div class="col-md-8 text w-100 text-center">
                                                <u>
                                                    <h3 class="mb-4">EARN CERTIFICATE</h3>
                                                </u>
                                                <p>Receive a Certificate of Organization from techsrijan, MMMUT Gorakhpur U.P authenticating your work as a College Ambassador.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item img">
                                    <div class="overlay"></div>
                                    <div class="container">
                                        <div class="row slider-text px-4 d-flex align-items-center justify-content-center">
                                            <div class="col-md-8 text w-100 text-center">
                                                <u>
                                                    <h3 class="mb-4">INCREASE YOUR CONTACTS</h3>
                                                </u>
                                                <p>Interact with people coming from diverse fields across the country to develop your network.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item img">
                                    <div class="overlay"></div>
                                    <div class="container">
                                        <div class="row slider-text px-4 d-flex align-items-center justify-content-center">
                                            <div class="col-md-8 text w-100 text-center">
                                                <u>
                                                    <h3 class="mb-4">FREE PASSES</h3>
                                                </u>
                                                <p>Top performers are entitled to registration and travel reimbursements, free coupons for food stalls and professional shows.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Left and right controls -->
                            <a class="carousel-control-prev" href="#demo" data-slide="prev">
                                <span class="ion-ios-arrow-round-back"></span>
                            </a>
                            <a class="carousel-control-next" href="#demo" data-slide="next">
                                <span class="ion-ios-arrow-round-forward"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END Perks -->

        <section class="ftco-section" id="typography">
            <div class="container" id="response">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center text-info">Responsibilities</h2>
                        <p class="text-center">As a campus ambassador,the primary task will be to coordinate with techsrijan to strategize campaigns to make the fest bigger and better, you will also have certain responsibilities like managing social media, publicity and organising workshops.
                            Click on the right arrow to know more!</p>
                        <hr style="color: #fff;">
                        <div class="typo">
                            <span class="typo-note">Social Media Platforms</span>
                            <p class="text-muted">
                                The campus ambassador has to maintain a strong social media presence on Facebook and Instagram to represent techsrijan and hence increase its popularity.
                            </p>
                        </div>
                        <div class="typo">
                            <span class="typo-note">Campus Publicity</span>
                            <p class="text-muted">
                                Publicity of techsrijan by sending route mails and messages on college WhatsApp & Facebook groups along with visual presentation of the fest through posters, fliers etc.
                            </p>
                        </div>
                        <div class="typo">
                            <span class="typo-note">Workshops</span>
                            <p class="text-muted">
                                Organising technical events & workshops in their college under the guidance of team techsrijan,MMMUT GORAKHPUR.
                            </p>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </section>
        <!-- - - - - -end- - - - -  -->

        <!-- Modal -->
        <section class="ftco-section ftco-section-2" id="javascriptsComponents">
            <div class="container">
                <div class="row">
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content" style="background-color:#160F45;">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Login</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form class="form-login" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                    <div class="modal-body">
                                        <div class="card-body pb-4 pt-2">
                                            <?php
                                                if(isset($errorMsg)){echo $errorMsg; }
                                                if(isset($errorEmail1)){ echo $errorEmail1;} 
                                                if(isset($errorPassword1)){ echo $errorPassword1;}
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
                                                        <i class="ion-ios-lock"></i>
                                                    </span>
                                                </div>
                                                <input type="password" class="form-control" placeholder="Password..." name="password" required>
                                            </div>
                                        </div>
                                        <div class="footer text-center mb-2">
                                            <input type="submit" value="login" name="login" class="btn btn-primary btn-round px-5">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="modal fade" id="rules" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content" style="background-color:#160F45;">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">POINTS SYSTEM</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <div class="row row-content">
                                        <div class="col-12">
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
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    Mail all the screenshots at email@gmail.com (under the subject:
                                    ”Screenshots of techSRIJAN tasks” ) so that we can evaluate all the points along with your Registration No.
                                    (Example - CA2020XXXX).
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- - - - - -end login pop-up - -  -->

        <section class="ftco-section ftco-section-2 section-signup page-header img" style="background-image: url(images/bg_2.jpg);" id="register">
            <div class="overlay"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                        <div class="card card-login py-4">
                            <form class="form-login" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                <div class="card-header card-header-primary text-center">
                                    <h4 class="card-title">Register</h4>
                                    <div class="social-line">
                                        <a href="https://www.facebook.com/techSRIJAN" target="_blank" class="btn-icon d-flex align-items-center justify-content-center">
                                            <i class="ion-logo-facebook"></i>
                                        </a>
                                        <a href="https://www.instagram.com/techsrijan.mmmut/" target="_blank" class="btn-icon d-flex align-items-center justify-content-center">
                                            <i class="ion-logo-instagram"></i>
                                        </a>
                                        <a href="https://www.linkedin.com/in/ieee-student-branch-madan-mohan-malaviya-university-of-technology-57a27b1a6/" target="_blank" class="btn-icon d-flex align-items-center justify-content-center">
                                            <i class="ion-logo-linkedin"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="footer text-center mb-2">
                                    <!--Error msg-->
                                    <span style="color: #fff ; background-color:red;">
                                        <?php
                                        if(isset($msg)){echo $msg;}
                                    ?>
                                    </span>
                                </div>
                                <div class="card-body pb-4 pt-2">

                                    <div class="footer text-center mb-2">
                                        <span style="color: #fff ; background-color:red;">
                                            <?php if(isset($errorUsername)){echo $errorUsername;} ?>
                                        </span>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="ion-ios-contact"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Username" name="username" required>
                                    </div>
                                    <div class="footer text-center mb-2">
                                        <span style="color: #fff ; background-color:red;">
                                            <?php if(isset($errorEmail)){echo $errorEmail;} ?>
                                        </span>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="ion-ios-mail"></i>
                                            </span>
                                        </div>
                                        <input type="email" class="form-control" placeholder="Email" name="email" required>
                                    </div>
                                    <div class="footer text-center mb-2">
                                        <span style="color: #fff ; background-color:red;">
                                            <?php if(isset($errorcollege)){echo $errorcollege;} ?>
                                        </span>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="ion-ios-contract"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="College" name="college" required>
                                    </div>
                                    <div class="footer text-center mb-2">
                                        <span style="color: #fff ; background-color:red;">
                                            <?php if(isset($errorcity)){echo $errorcity;} ?>
                                        </span>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="ion-ios-copy"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="City" name="city" required>
                                    </div>
                                    <div class="footer text-center mb-2">
                                        <span style="color: #fff ; background-color:red;">
                                            <?php if(isset($erroryear)){echo $erroryear;} ?>
                                        </span>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="ion-ios-calendar"></i>
                                            </span>
                                        </div>
                                        <input type="number" class="form-control" placeholder="Year of study" name="year" required>
                                    </div>
                                    <div class="footer text-center mb-2">
                                        <span style="color: #fff ; background-color:red;">
                                            <?php if(isset($errormob_no)){echo $errormob_no;} ?>
                                        </span>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="ion-ios-call"></i>
                                            </span>
                                        </div>
                                        <input type="number" class="form-control" placeholder="Mobile No." name="mob_no" required>
                                    </div>
                                    <div class="footer text-center mb-2">
                                        <span style="color: #fff ; background-color:red;">
                                            <?php if(isset($errorPassword)){echo $errorPassword;} ?>
                                        </span>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="ion-ios-lock"></i>
                                            </span>
                                        </div>
                                        <input type="password" class="form-control" placeholder="Password..." name="password" required>
                                    </div>
                                </div>
                                <div class="footer text-center mb-2">
                                    <input type="submit" value="register" name="register" class="btn btn-primary btn-round px-5">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- - - - - -end- - - - -  -->

        <section class="ftco-section ftco-section-2">
            <h2 class="text-center text-info">Contact</h2>
            <div class="container">
                <div class="row justify-content-center">

                    <div class="col-md-4 text-center">
                        <h2 class="heading-section mb-4">
                        </h2>
                        <div class="image-wrap">
                            <img src="images/shresth.jpg" alt="Circle Image" class="rounded-circle img-fluid image">
                            <div class="text">
                                <div class="img"></div>
                                <span class="position">Shresth Sahai <br>+91-8787080870 <br> Executive Member <br> IEEE Student Branch, MMMUT</span>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4 text-center">
                        <h2 class="heading-section mb-4">
                        </h2>
                        <div class="image-wrap">
                            <img src="images/kshitiz.jpeg" alt="Circle Image" class="rounded-circle img-fluid image">
                            <div class="text">
                                <div class="img"></div>
                                <span class="position">Kshitiz Srivastava <br>+91-9129992203 <br> Executive Member <br> IEEE Student Branch, MMMUT</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- - - - - -end- - - - -  -->


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
