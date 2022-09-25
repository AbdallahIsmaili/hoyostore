<?php

    $message = "Something went wrong, please make sure to enter again via the link we sent to your email address.";
    include "../app/classes/databaseClass.php";
    include "../app/classes/verificationClass.php"; 

    $Verification = new Verification();

    if(isset($_GET['k'])){
        $key = trim($_GET['k']);

        $result = $Verification->validMyEmail($key);

        if($result == 1){
            $message = "Your account is already verified";
        }
        if($result == 2){
            $message = "Your account has been verified successfully, you can now back to <a href='../login.php'>Login page</a>. Thank you";
        }
        if($result == 3){
            $message = "Something went wrong, please make sure to enter again via the link we sent to your email address.";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HoyoStore - Verification link</title>

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="../app/theme/assets/css/style.css?v1.11">

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

      </nav>

    </div>
  </header>


    <div class="container">
        <center>

            <h3 class="verification-error"><?php echo $message ?></h3>
            <br>
            <p>you'll be back to login after 5 seconds.</p>

        </center>

    </div>

    <br>
    <br>


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
         setTimeout(function(){
            window.location.href = '../login.php';
         }, 5000);
    </script>

</body>

</html>