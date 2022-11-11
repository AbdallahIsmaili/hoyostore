<?php 

// Includes
include "../app/classes/databaseClass.php";
include "../app/classes/loginClass.php"; 
include "../app/classes/verificationClass.php"; 

// Declared Variables
$email = '';
$error = "";
$validationError = '';
$isValid = false;
$verificationNumber = '';
$sent = 'false';

if(isset($_GET['email'])){
  $e = $_GET['email'];
}else{
  $e = '';
}

if(isset($_POST['email'])){   
    $email = trim($_POST['email']);

    $checkValidation = new Verification();
  
    $result = $checkValidation->isValid($email);
    if($result == 0){
      $isValid = false;
      $valid = "f";
      header("Location: ../login.php?email=$email&v=false");

    }else if($result == 1){
      $isValid = true;
      $valid = "t";

    }else{
      $isValid = "No user registered with that email.";
    }

}else{
  $email = '';
  $isValid = false;
}

// Log in to your account testing and validation
$restore = new Login();

if(isset($_POST['Restore'])){

      // Checking the felids
      if(empty($email) || !preg_match("/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/", $email)){
        $error .= "Please enter a valid email address <br>";

      }else if($error == "" && $isValid == true){

          $result = $restore->findUser($email);
          if($result == 1){
              
              // Resend new verification link
              $Verification = new Verification();

              $verificationNumber = rand(100000,1000000);

              $result = $Verification->updateVerificationNumber($verificationNumber, $email);

              if($result == 1){

                $to = $email;
                $verification_link = "<b><u>$verificationNumber</u></b>";
                $subject = "Password restoration key.";
                $message = "
                    
                    Hello $name <br>

                    Please enter the following code to complete your verification:<br>

                    $verification_link
                    <br><br>

                    After you enter that code you'll be able to change your password.<br>

                    See you there!<br><br>

                    <strong>Best regards, the <u>HoyoStore</u> team.</strong>
                ";

                $headers = "From: aismaili690@gmail.com \r\n";
                $headers .= "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                mail($to, $subject, $message, $headers);

                $sent = 'true';

                header("Location: verify-key.php?e=$email&s=$sent&v=$valid");

                $validationError = "We sent a new verification link to your email $email.";

              }else{
                $validationError = "Something went wrong, try again later.";

              }
          }

          if($result == 2){
              $error = "Sorry, we didn't found any account registered with that email. Please make sure to check your email first ten try again.";
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
  <title>HoyoStore - Restore password</title>

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
          <p>Forgot your password? don't worry!</p>
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
            <h3 class="section-title">Let's start our mission!</h3>
            <br>

            <center>

              <p class='validation-error'><?php echo $validationError; ?></p>
              <h4 style="color: red"><?php echo $error; ?></h4>

            </center>
            <br>

            <form action="restore-password.php" method="POST">

              <p class='inputName'>Email :</p>
                  
                  
                  <?php
                    if(isset($_GET['email'])){
                      echo "<input type='email' name='email' class='register_field' value='$e' placeholder='Enter your email' readonly>";
                    }else{
                      echo "<input type='email' name='email' class='register_field' value='$e' placeholder='Enter your email'>";
                    }
                  ?>
<!-- 
                }else if(isset($_GET['s']) && $_GET['s'] == 'true'){
                  echo "<form action='' method='POST'>

                  <p class='inputName'>Enter the key we just sent to your email:</p>
                  <input type='number' name='keyNumber' class='register_field' value='' placeholder='Enter your code'>
                  
                  </form>";

                  echo "<br>";

                  echo "<form action='' method='post'>
                    <button type='submit' id='resendVerificationCode' name='resend-verification-code'>Resend verification code</button> 
                  </form>";

                }else{
                  echo "<p class='inputName'>Email :</p>
                  <input type='email' name='email' class='register_field' value='' placeholder='Enter your email'>";
                } -->

                <br>
                    <br>
                    

                    <?php
                    if(isset($_GET['email'])){
                      echo "<button type='submit' name='Restore' class='btn btn-primary'>Change my password</button>";
                    }else{
                      echo "<button type='submit' name='Restore' class='btn btn-primary'>Restore my password</button>";
                    }
                  ?>

                    <?php

                      // if(isset($_GET['s']) && isset($_GET['e']) && $_GET['s'] == 'true' && $isValid == true){
                      //   echo "<button type='submit' name='ChangePassword' class='btn btn-primary'>Change my password</button>";

                      // }

                    ?>


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