<?php 

// Includes
include "app/classes/databaseClass.php";
include "app/classes/loginClass.php"; 
include "app/classes/verificationClass.php"; 

// Declared Variables
$error = "";
$password = "";
$email = '';
$validationError = '';
$isValid = true;
$verificationKey = '';
$name = '';

// Getting user email
if(isset($_GET['email'])){
    $email = $_GET['email'];
}else{
    $email = '';
}

// Checking if the user email is verified or not
if(isset($_GET['v'])){
  $checkValidation = new Verification();
  
  $result = $checkValidation->isValid($email);
  if($result == 0){
    $isValid = false;
  }else if($result == 1){
    $isValid = true;
  }else{
    $isValid = "No user registered with that email.";
  }
}



// Cookie for remembering password
if (isset($_COOKIE['email']) and isset($_COOKIE['password'])) 
{
    $password = $_COOKIE['password'];

}

// Log in to your account testing and validation
$login = new Login();

if(isset($_POST['login'])){

    // Getting informations from the form
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Checking the felids
    if(empty($email) && empty($name) && empty($password) && empty($confirm_password)){
        $error .= "Please make sure to fill in all the boxes <br>";

    }else if(empty($email) || !preg_match("/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/", $email)){
        $error .= "Please enter a valid email address <br>";

    }else if(strlen($password) < 8){
        $error .= "Password must be at least 8 characters long <br>";

    }else if(empty($password)){
        $error .= "Please enter a password <br>";

    }else if($error == ""){
      
      // Setting up the cookies
        if(isset($_POST['remember']) and $_POST['remember'] == 'on'){
          setcookie('email', $email, time() + (86400 * 30), "/", $domain = "", $secure = false, $httponly = false );
          setcookie('password', $password, time() + (86400 * 30), "/", $domain = "", $secure = false, $httponly = false );
        }

        $password = hash("sha1", $password);

        $result = $login->loginUser($email, $password);
        if($result == 1){
            
            echo "<script>window.open('index.php','_self')</script>";
        }

        if($result == 2){
            echo "<script>alert('Wrong password!')</script>";
        }

        if($result == 3){
            echo "<script>alert('No user found with that email!')</script>";
            echo "<script>window.open('register.php','_self')</script>";
        }

        if($result == 4){
            $isValid = false;
            echo "<script>alert('Please make sure your email is verified!')</script>";
        }
        
    }
    
}

// Messaging you if your account is not verified
if($isValid == false){
    $validationError = 'We just sent a verification link to your email address <u>'. $email .'</u>, Please verify your email address before you can access your account.';
}


// Resend new verification link
$Verification = new Verification();

if(isset($_POST['resend-verification-code'])){

  $verificationKey = md5(time(). $email);

  $result = $Verification->updateVerificationCode($verificationKey, $email);

  if($result == 1){
    $path = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] ."/hoyostore/validation/registration-verify.php?k=$verificationKey";

    $to = $email;
    $verification_link = "<a href='$path'>Your account verification link</a>";
    $subject = "Your email verification.";
    $message = "
        
        Hello $name <br>

        Are you ready to gain access to all of the assets we prepared for clients of HoyoStore?<br>

        First, you must complete your registration by clicking on the link below:<br><br>

        $verification_link
        <br><br>

        This link will verify your email address, and then you’ll officially be a part of our community.<br>

        See you there!<br><br>

        <strong>Best regards, the <u>HoyoStore</u> team.</strong>
    ";

    $headers = "From: aismaili690@gmail.com \r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    mail($to, $subject, $message, $headers);

    $validationError = "We sent a new verification link to your email $email.";

  }else{
    $validationError = "Something went wrong, try again later.";

  }

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HoyoStore - Login</title>

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="./app/theme/assets/css/style.css?v1.10.2">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

  <!-- 
    - #HEADER
  -->

  <header class="header" data-header>

        <div class="our-infos">
          <p>hoyostore@store.com,</p>
          <p>Welcome here traveler!</p>
        </div>

    </div>

    <br>

    <div class="container">

      <div class="overlay" data-overlay></div>

      <a href="#" class="logo">
        <img src="./app/theme/assets/images/logo.svg" alt="Casmart logo" width="130" height="31">
      </a>

      <button class="nav-open-btn" data-nav-open-btn aria-label="Open Menu">
        <span></span>
        <span></span>
        <span></span>
      </button>

      <nav class="navbar" data-navbar>

        <div class="navbar-top">

          <a href="#" class="logo">
            <img src="./app/theme/assets/images/logo.svg" alt="Casmart logo" width="130" height="31">
          </a>

          <button class="nav-close-btn" data-nav-close-btn aria-label="Close Menu">
            <ion-icon name="close-outline"></ion-icon>
          </button>

        </div>

        <ul class="navbar-list">

            <li>
            <a href="#home" class="navbar-link">Login</a>
          </li>

          <li>
            <a href="#home" class="navbar-link">Home</a>
          </li>

          <li>
            <a href="#" class="navbar-link">Shop</a>
          </li>

          <li>
            <a href="#" class="navbar-link">About</a>
          </li>

          <li>
            <a href="#blog" class="navbar-link">Blog</a>
          </li>

          <li>
            <a href="#" class="navbar-link">Contact</a>
          </li>

        </ul>

      </nav>

    </div>
  </header>


  <div class="container">
        
        <br>
        <section class="login-form">
            <h3 class="section-title">Hello and welcome, one more tap to go!</h3>
            <br>

            <center>

              <p class='validation-error'><?php echo $validationError; ?></p>

              <?php

                if($isValid == false){
                  echo "<form action='' method='post'>
                  <button type='submit' id='resendVerificationCode' name='resend-verification-code'>Resend verification link</button> 
                </form>";
                }

              ?>

              <h4 style="color: red"><?php echo $error; ?></h4>

            </center>
            <br>

            <form action="login.php" method="POST">

                <p class="inputName">Email :</p>
                <input type="email" name="email" class="register_field" value="<?=$email?>" placeholder="Enter your email">

                <p class="inputName">Password :</p>
                <input type="password" name="password" value="" class="register_field" placeholder="Enter your password">

            <br>

                <p class="inputName">Remember me? </p>
                <input class="register_field" type="checkbox" name="remember">

                <br>
                <br>
                <br>
                    <button type="submit" name="login" class="btn btn-primary">Login</button>
                      <p><a href="user/restore-password.php">forgot you password?</a></p>

            </form>
            <br>
            <br>
            
            <p>Don't have an account? <a href="register.php">Register now!</a></p>

        </section>

    </div>

    <br>
    <br>

  
  <!-- 
    - #FOOTER
  -->

  <footer class="footer">

    <div class="footer-top">
      <div class="container">

        <div class="footer-brand">

          <a href="#" class="logo">
            <img src="./app/theme/assets/images/logo.svg" alt="Casmart logo">
          </a>

          <p class="footer-text">
            Casmart is a fashion theme for presents a complete wardrobe of uniquely crafted Ethnic Wear, Casuals, Edgy
            Denims, &
            Accessories inspired from the most contemporary
          </p>

          <ul class="social-list">

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-facebook"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-twitter"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-instagram"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-pinterest"></ion-icon>
              </a>
            </li>

          </ul>

        </div>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Information</p>
          </li>

          <li>
            <a href="#" class="footer-link">About Company</a>
          </li>

          <li>
            <a href="#" class="footer-link">Payment Type</a>
          </li>

          <li>
            <a href="#" class="footer-link">Awards Winning</a>
          </li>

          <li>
            <a href="#" class="footer-link">World Media Partner</a>
          </li>

          <li>
            <a href="#" class="footer-link">Become an Agent</a>
          </li>

          <li>
            <a href="#" class="footer-link">Refund Policy</a>
          </li>

        </ul>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Category</p>
          </li>

          <li>
            <a href="#" class="footer-link">Handbags & Wallets</a>
          </li>

          <li>
            <a href="#" class="footer-link">Women's Clothing</a>
          </li>

          <li>
            <a href="#" class="footer-link">Plus Sizes</a>
          </li>

          <li>
            <a href="#" class="footer-link">Complete Your Look</a>
          </li>

          <li>
            <a href="#" class="footer-link">Baby Corner</a>
          </li>

          <li>
            <a href="#" class="footer-link">Man & Woman Shoe</a>
          </li>

        </ul>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Help & Support</p>
          </li>

          <li>
            <a href="#" class="footer-link">Dealers & Agents</a>
          </li>

          <li>
            <a href="#" class="footer-link">FAQ Information</a>
          </li>

          <li>
            <a href="#" class="footer-link">Return Policy</a>
          </li>

          <li>
            <a href="#" class="footer-link">Shipping & Delivery</a>
          </li>

          <li>
            <a href="#" class="footer-link">Order Tranking</a>
          </li>

          <li>
            <a href="#" class="footer-link">List of Shops</a>
          </li>

        </ul>

      </div>
    </div>

    <div class="footer-bottom">
      <div class="container">

        <p class="copyright">
          &copy; 2022 <a href="#">codewithsadee</a>. All Rights Reserved
        </p>

        <ul class="footer-bottom-list">

          <li>
            <a href="#" class="footer-bottom-link">Privacy Policy</a>
          </li>

          <li>
            <a href="#" class="footer-bottom-link">Terms & Conditions</a>
          </li>

          <li>
            <a href="#" class="footer-bottom-link">Sitemap</a>
          </li>

        </ul>

        <div class="payment">
          <p class="payment-title">We Support</p>

          <img src="./app/theme/assets/images/payment-img.png" alt="Online payment logos" class="payment-img">
        </div>

      </div>
    </div>

  </footer>





  <!-- 
    - custom js link
  -->
  <script src="./app/theme/assets/js/script.js"></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    
  <script>
    const togglePassword = document.querySelector('#togglePassword');
    const toggleCPassword = document.querySelector('#toggleCPassword');
    const password = document.querySelector('#password');
    const Cpassword = document.querySelector('#Cpassword');

    
    // function sendAgain() {
    //   document.getElementById("resendVerificationCode").disabled = true;
    //   setTimeout(function() {
    //       document.getElementById("resendVerificationCode").disabled = false;
    //   }, 5000);
    // }
    // document.getElementById("resendVerificationCode").addEventListener("click", sendAgain);

    togglePassword.addEventListener('click', function (e) {
      // toggle the type attribute
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      // toggle the eye slash icon
      this.classList.toggle('fa-eye-slash');
    });

    toggleCPassword.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = Cpassword.getAttribute('type') === 'password' ? 'text' : 'password';
        Cpassword.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });

  </script>

</body>

</html>