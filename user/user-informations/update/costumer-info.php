<?php

include "../../../app/classes/databaseClass.php";
include "../../../app/classes/profileClass.php"; 

session_start();

if(isset($_SESSION['user_url'])){
    
    $userURL = $_SESSION['user_url'];
    $oldEmail = $_SESSION['user_email'];
    $oldUsername = $_SESSION['user_name'];
    $username = $_SESSION['user_name'];
    $phoneNumber = $_SESSION['user_phone'];
    $userAddress = $_SESSION['user_address'];

  }else{

    $userURL = "";
    $oldEmail = "";
    $oldUsername = "";
    $username = "";
    $phoneNumber = "";
    $userAddress = "";
  }

$profileUpdate = new Profile();

$error = "";
$validationError = "";

if(isset($_POST['update-info'])){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['confirmation_password']);
    $userAddress = trim($_POST['address']);
    $phoneNumber = trim($_POST['phone']);

    if(empty($email) && empty($name) && empty($password) && empty($confirm_password)){
        $error .= "Please make sure to fill in all the boxes <br>";

    }else if(empty($email) || !preg_match("/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/", $email)){
        $error .= "Please enter a valid email address <br>";

    }else if(empty($name) || !preg_match("/^[a-zA-Z_ ]*$/", $name)){
        $error .= "Please enter a valid name <br>";

    }else if(empty($password)){
        $error .= "Please enter your password <br>";

    }else if(strlen($password) < 8){
        $error .= "Password must be at least 8 characters long <br>";

    }

    if(empty($error)){
        $password = hash("sha1", $password);

        $result = $profileUpdate->updateUserInfo($name, $userURL, $email, $phoneNumber, $userAddress, $password);

        if($result == 1){
            session_unset();
            session_destroy();
            echo "<script>window.open('../../../login.php','_self')</script>";
        }

        if($result == 2){
            $validationError .= "The password is wrong. <br>";
        }

        if($result == 3){
            $validationError .= "Oops, Something went wrong. <br>";
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
    <title>HoyoStore - My account</title>

  <!-- 
    - favicon
  -->
    <link rel="shortcut icon" href="../../../favicon.svg" type="image/svg+xml">

  <!-- 
    - custom css link
  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../app/theme/assets/css/style.css?v1.41">

  <!-- 
    - google font link
  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
    />

    <script src="/icons/dist/boxicons.js" type="text/javascript"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

 </head>
 <body>

 <header class="header mb-0" data-header>

<div class="our-infos">
  <p>hoyostore@store.com,</p>
  <p>Welcome <?php echo ucfirst($username); ?></p>
  <p>flag</p>
</div>

</div>

<br>

<div class="container mb-0">

<div class="overlay" data-overlay></div>

<div class="header-search">
<input type="search" name="search" placeholder="Search Product..." class="input-field">

<button class="search-btn" aria-label="Search">
  <ion-icon name="search-outline"></ion-icon>
</button>
</div>

<a href="#" class="logo">
<img src="../../../app/theme/assets/images/logo.svg" alt="Casmart logo" width="130" height="31">
</a>

<div class="header-actions">

<?php 
  if(isset($_SESSION['user_url'])){
    $username = $_SESSION['user_name'];
    $userURL = $_SESSION['user_url'];

    echo "<a href='./user/cart.php?u=$userURL' class='header-action-btn'>
    <ion-icon name='cart-outline' aria-hidden='true'></ion-icon>

    <p class='header-action-label'>Cart</p>
    <div class='btn-badge green' aria-hidden='true'>3</div>
  </a>";
  
  }else{
    echo "";
  }
?>

</div>

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

<?php

  if(isset($_SESSION['user_url'])){

?>

    <div class="container">
        
        <br>
        <section class="register-form">
            <h4 class="section-subtitle">Update personal information.</h4>
            <h6 style="color: red"><?php echo $validationError; ?></h6>
            <h6 style="color: red"><?php echo $error; ?></h6>
            <br>
            <div class="form-control">
                
                <form action="costumer-info.php" method="POST">
                    
                    <p class="inputName">Name :</p> 
                    <input type="text" name="name" class="register_field" placeholder="Enter your name" value="<?=$oldUsername?>">
                    <br>

                    <p class="inputName">Email :</p> 
                    <input type="email" name="email" value='<?=$oldEmail?>' class="register_field" placeholder="Enter your email">
                    
                    <br>
                    <p class="inputName">Enter your phone number:</p>
                    <input id="phone" class="register_field w-100"  type="tel" value="<?=$phoneNumber?>" name="phone" />

                    <br>

                    <p class="inputName">Address :</p> 
                    <input type="text" name="address" class="register_field" value="<?=$userAddress?>" placeholder="Enter your address">

                    <br>

                    <p class="inputName">Enter your password :</p> 
                    <input type="password" name="confirmation_password" class="register_field" placeholder="Enter your password">

                    <br>
                    <div class="form-group">
                        <button type="submit" name="update-info" class="btn btn-primary">Update my information</button>
                    </div>
                </form>
                <br>
                
            </div>
        </section>

    </div>

    <script>
        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            utilsScript:
            "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });

        function getIp(callback) {
        fetch('https://ipinfo.io/json?token=<your token>', { headers: { 'Accept': 'application/json' }})
        .then((resp) => resp.json())
        .catch(() => {
            return {
            country: 'us',
            };
        })
        .then((resp) => callback(resp.country));
        }

        // const phoneInput = window.intlTelInput(phoneInputField, {
        // initialCountry: "auto",
        // geoIpLookup: getIp,
        // utilsScript:
        // "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        // });

        // const phoneInput = window.intlTelInput(phoneInputField, {
        // preferredCountries: ["us", "co", "in", "de"],
        // utilsScript:
        //     "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        // });

    </script>

    
<?php

}else{
?>

<h1 class="container mt-5">Hello &#128149; </h1>
<div class="container mx-auto p-5 text-white bg-black fs-4">
    <p>Please make sure to Log in if you already have an account, or please join us by creating an account.</p>

    <div class="btn-group-vertical w-100" role="group" aria-label="Vertical button group">
      <a href="../../../login.php" class="btn btn-dark fs-5">Log in &nbsp; <i class='bx bx-log-in'></i></a>
      <a href="../../../register.php" class="btn btn-dark fs-5"> Register &nbsp; <i class='bx bxs-user-plus'></i> </a>
    </div>
</div>


<?php
}

?>

 </body>
</html>