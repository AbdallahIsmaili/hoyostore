<?php
  include "../app/classes/databaseClass.php";
  include "../app/classes/loginClass.php"; 
  include "../app/classes/profileClass.php"; 
  include "../public/define.php";

  session_start();
  
  if(isset($_SESSION['user_url'])){
    
    $userProfilePicture = $_SESSION['user_image'];
    $email = $_SESSION['user_email'];
    $username = ucfirst($_SESSION['user_name']);
    $userEmail = $_SESSION['user_email'];
    $userRank = ucfirst($_SESSION['user_rank']);
    $userPhoneNumber = $_SESSION['user_phone'];
    $userAddress = $_SESSION['user_address'];

  }else{
    $userProfilePicture = "";
    $email = "";
    $username = '';
    $userEmail = '';
    $userRank = '';
    $userPhoneNumber = '';
    $userAddress = '';
  }

  $logout = new Login();

  if(isset($_POST['logout'])){
    $result = $logout->logoutUser();

    if(isset($result) and $result == true){
      echo "<script>window.open('../index.php','_self')</script>";
    }
  }

  $getProfile = new Profile();

  $result = $getProfile->getProfileName($email);
  if($result != 0){
    $user_image = $result;
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
  <link rel="shortcut icon" href="../favicon.svg" type="image/svg+xml">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../app/theme/assets/css/style.css?v1.4">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<script src="/icons/dist/boxicons.js" type="text/javascript"></script>
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
  <img src="../app/theme/assets/images/logo.svg" alt="Casmart logo" width="130" height="31">
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

<div class="container mb-5">

    <div class="user mt-3">
      <h2>Welcome <u><?php echo ucfirst($username); ?></u></h2>
      <h5>> <?php echo $userEmail; ?></h5>

      <?php
        if($userPhoneNumber != 'no phone'){
          echo "<h5> > $userPhoneNumber </h5>";
        }else{
          echo "<a href='./user-informations/update/costumer-info.php?u=$userURL'> > Add your phone number</a>";
        }
        if($userAddress != 'no address'){
          echo "<h5> > $userAddress </h5>";
        }else{
          echo "<a href='./user-informations/update/costumer-info.php?u=$userURL'> > Add your address</a>";
        }
      ?>

    </div>

        <div class="row">
          <div class="col-md-6">
            <div class="profile-links fs-4">

                <img src='uploads/images/<?= $user_image ?>' id='userProfilePicture'>
                <p id="errorMessage"></p>

                <form action="./user-informations/update/updateImage.php" method="post" id='updatePictureForm' enctype="multipart/form-data">

                    <label id="pplabel" for="newImagePicture">Choose a photo</label>
                    <input name="uploaded-image" id="newImagePicture" class="fileInput" type="file">
                    
                    <input type="submit" id="submitProfilePicture" name="update-profile" value="Upload picture" class="btn mx-auto btn-primary"
                      style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">

                  </form>

                <li><a href="../">Home</a> <i class='bx bxs-home-smile text-light'></i> </li>
                <li><a href="../shop.php">Shop <i class='bx bxs-store-alt text-light'></i></a></li>
                <li><a href="cart.php">Cart <i class='bx bxs-cart text-light'></i></a></li>
                <li><a href="wishlist.php">Wishlist <i class='bx bxs-bookmark-heart text-light'></i> </a></li>
                <li><a href="../blog.php">Blog <i class='bx bxs-book-bookmark text-light'></i> </a></li>
                <li><a href="../contact.php">Contact <i class='bx bxs-message-square-edit text-light'></i> </a></li>
              </div>
            </div>
            <div class="col-md-6">

              <h3 class="mt-5 mb-3">My account</h3>
              <div class="btn-group-vertical w-100" role="group" aria-label="Vertical button group">
                <button type="button" class="btn btn-primary fs-5">Orders &nbsp; <i class='bx bx-cart-add fs-4'></i> </button>
                <button type="button" class="btn btn-primary fs-5">Messages &nbsp; <i class='bx bx-message-square-error fs-4'></i></button>
                <button type="button" class="btn btn-primary fs-5">My comments &nbsp; <i class='bx bxs-inbox fs-4'></i></button>
                <button type="button" class="btn btn-primary fs-5">Coupons &nbsp; <i class='bx bxs-discount fs-4'></i></button>
                <button type="button" class="btn btn-primary fs-5">Search line &nbsp; <i class='bx bx-file-find fs-4'></i></button>
              </div>

              <h3 class="mt-5 mb-3">Settings</h3>
              <div class="btn-group-vertical w-100" role="group" aria-label="Vertical button group">
                <?php 
                  if(isset($_SESSION['user_rank']) && $_SESSION['user_rank'] == 'admin'){
                      echo "<a href='../app/admin/theme/index.php' class='btn btn-primary fs-5'>Admin Dashboard &nbsp; <i class='bx bxs-objects-horizontal-left fs-4'></i></a>";
                  }
                ?>
                <button type="button" class="btn btn-dark fs-5">My Address &nbsp; <i class='bx bxs-objects-horizontal-left fs-4'></i></button>
                <a href="./user-informations/update/costumer-info.php" class="btn btn-dark fs-5">Account management &nbsp; <i class='bx bxs-message-square-edit fs-4'></i> </a>
                <button type="button" class="btn btn-dark fs-5">Close your account &nbsp; <i class='bx bx-window-close fs-4' ></i></button>
              </div>
                
                <form action="" method="post">

                  <div class="btn-group-vertical w-100" role="group" aria-label="Vertical button group">
                    <button type="submit" name='logout' class="btn btn-danger fs-5">Log out &nbsp; <i class='bx bx-log-out-circle fs-4' ></i></button>
                  </div>
                  
                </form>

            </div>
        </div>
    </div>
    
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>

    <script>
      $(document).ready(function(){
        $("#submitProfilePicture").click(function(e){
          e.preventDefault();

          let form_data = new FormData();
          let imgProfile = $("#newImagePicture")[0].files;

          if(imgProfile.length > 0){
            form_data.append("newImagePicture", imgProfile[0]);

            $.ajax({
              url: './user-informations/update/updateImage.php',
              type: 'post',
              data: form_data,
              contentType: false,
              processData: false,
              success: function(res){
                const data = JSON.parse(res);

                if(data.error != 1){
                  let path = "./uploads/images/" + data.src;
                  $("#userProfilePicture").attr("src", path);
                  $("#userProfilePicture").fadeOut(1).fadeIn(1000);

                }else{
                  $("#errorMessage").text(data.em);
                }

              }
            });
            
          }else{
            $("#errorMessage").text("Please select an image.");
          }

        })
      });
    </script>
    
    <!-- 
      - custom js link
    -->
    <script src="	https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<?php

      }else{

?>

  <h1 class="container mt-5">Hello &#128149; </h1>
  <div class="container mx-auto p-5 text-white bg-black fs-4">
          <p>Please make sure to Log in if you already have an account, or please join us by creating an account.</p>

          <div class="btn-group-vertical w-100" role="group" aria-label="Vertical button group">
            <a href="../login.php" class="btn btn-dark fs-5">Log in &nbsp; <i class='bx bx-log-in'></i></a>
            <a href="../register.php" class="btn btn-dark fs-5"> Register &nbsp; <i class='bx bxs-user-plus'></i> </a>
          </div>
  </div>


<?php
      }

?>
  

</body>

</html>
