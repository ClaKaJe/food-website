<?php
session_start();

include 'components/connect.php';

setcookie("redirect_page", $page, time() + 3600);
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

echo $message;

if (isset($message)) {
   foreach ($message as $msg) {
      echo '
      <div class="message">
         <span>' . $msg . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" href="images/logo2.png" type="image/png">
   <title><?= $title ?></title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <header class="header">

      <section class="flex">

         <a href="/" class="logo"><!-- <img src="images/logo2.png" alt="logo"> -->Nyam nyam 😋</a>

         <nav class="navbar">
            <a href="/">home</a>
            <a href="about.php">about</a>
            <a href="menu.php">menu</a>
            <a href="orders.php">orders</a>
            <a href="contact.php">contact</a>
         </nav>

         <div class="icons">
            <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_items = $count_cart_items->rowCount();
            ?>
            <a href="search.php"><i class="fas fa-search"></i></a>
            <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_items; ?>)</span></a>
            <div id="user-btn" class="fas fa-user"></div>
            <div id="menu-btn" class="fas fa-bars"></div>
         </div>

         <div class="profile">
            <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if ($select_profile->rowCount() > 0) {
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
               <p class="name"><?= $fetch_profile['name']; ?></p>
               <div class="flex">
                  <a href="profile.php" class="btn">profile</a>
                  <a href="components/user_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
               </div>
               <p class="account">
                  <a href="login.php">login</a> or
                  <a href="register.php">register</a>
               </p>
            <?php
            } else {
            ?>
               <p class="name">please login first!</p>
               <a href="login.php" class="btn">login</a>
            <?php
            }
            ?>
         </div>

      </section>

   </header>