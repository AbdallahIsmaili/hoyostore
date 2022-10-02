<?php 

// Includes
include "../app/classes/databaseClass.php";
include "../app/classes/loginClass.php"; 
include "../app/classes/verificationClass.php"; 

// Declared Variables
$error = "";
$password = "";
$email = '';
$validationError = '';
$isValid = true;
$verificationKey = '';

// Getting user email
if(isset($_GET['email'])){
    $email = $_GET['email'];
}else{
    $email = '';
}

if(isset($_GET['k'])){
    $myKey = $_GET['k'];
}else{
    $myKey = '';
}

// Checking if the user email is verified or not
if(isset($_GET['email'])){
  $checkValidation = new Verification();
  
  $result = $checkValidation->isValid($email);
  if($result == 0){
    $isValid = false;
    header("Location: ../login.php");

  }else if($result == 1){
    $isValid = true;
  }else{
    $isValid = "No user registered with that email.";
  }
}

if(isset($_GET['k'])){

    $checkKey = new Verification();

    $result1 = $checkKey->isKey($email, $myKey);
    if($result1 == 1){
        $isValid = true;
        
    }else if($result1 == 2){
        $isValid = false;
        header("Location: ../login.php");

    }else{
        $isValid = "Something went wrong.";
    }
}

if(!isset($_GET['k']) || !isset($_GET['email'])){
    $isValid = false;
}

if($isValid == false){
    header("Location: ../login.php");
}

$login = new Login();

if(isset($_POST['change'])){

    // Getting informations from the form
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['Cpassword']);

    // Checking the felids
    if(empty($password) && empty($confirm_password)){
        $error .= "Please make sure to fill in all the boxes <br>";

    }else if(strlen($password) < 8){
        $error .= "Password must be at least 8 characters long <br>";

    }else if(empty($password) || empty($confirm_password)){
        $error .= "Please enter a password <br>";

    }else if($password != $confirm_password){
        $error .= "Password doesn't match the confirmed password <br>";

    }else if($error == ""){

        $password = hash("sha1", $password);

        $result = $login->updatePassword($email, $password);
        if($result == 1){
            
            $path = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] ."/hoyostore/login.php";

            $to = $email;
            $verification_link = "<a href='$path'>HoyoStore login page</a>";
            $subject = "Your password has been changed.";
            $message = "
                Hello $email

                You have changed your password<br>

                Please go ahead and try to login again with your new password at the following page.<br>
                
                <b>$verification_link</b>
                <br>

                See you there!<br><br>

                <strong>Best regards, the <u>HoyoStore</u> team.</strong>
            ";

            $headers = "From: aismaili690@gmail.com \r\n";
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            mail($to, $subject, $message, $headers);

            echo "<script>alert('Your password has been reset. Try to login again!')</script>";
            echo "<script>window.open('../login.php','_self')</script>";
        }

        if($result == 2){
            echo "<script>alert('Something went wrong!')</script>";
        }
        
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
  <link rel="stylesheet" href="../app/theme/assets/css/style.css?v1.10.2">

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
        <img src="../app/theme/assets/images/logo.svg" alt="Casmart logo" width="130" height="31">
      </a>

      <button class="nav-open-btn" data-nav-open-btn aria-label="Open Menu">
        <span></span>
        <span></span>
        <span></span>
      </button>

      <nav class="navbar" data-navbar>

        <div class="navbar-top">

          <a href="#" class="logo">
            <img src="../app/theme/assets/images/logo.svg" alt="Casmart logo" width="130" height="31">
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

            <form action="" method="POST">

                <p class="inputName">New password :</p>
                <input type="password" name="password" id="password" class="register_field" value="" placeholder="Enter new password"><i class="far fa-eye" id="togglePassword" style="cursor: pointer; font-size: 13px;"> Show password</i><br><br>

                <p class="inputName">confirm password :</p>
                <input type="password" name="Cpassword" id="Cpassword" value="" class="register_field" placeholder="Confirm password"><i class="far fa-eye" id="toggleCPassword" style="cursor: pointer; font-size: 13px;"> Show password</i><br>

                <br>
                <br>
                <br>
                    <button type="submit" name="change" class="btn btn-primary">Update password</button>
                      
            </form>
            <br>
            <br>
            
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
            <img src="../app/theme/assets/images/logo.svg" alt="Casmart logo">
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

          <img src="../app/theme/assets/images/payment-img.png" alt="Online payment logos" class="payment-img">
        </div>

      </div>
    </div>

  </footer>





  <!-- 
    - custom js link
  -->
  <script src="../app/theme/assets/js/script.js"></script>

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