<?php
$title = 'Profile';
$page = 'profile.php';

include "components/user_header.php";

if ($user_id === '') {
   header('location:/login.php');
}
?>

<section class="user-details">

   <div class="user">
      <?php

      ?>
      <img src="images/user-icon.png" alt="">
      <p><i class="fas fa-user"></i><span><span><?= $fetch_profile['name']; ?></span></span></p>
      <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number']; ?></span></p>
      <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email']; ?></span></p>
      <a href="update_profile.php" class="btn">update info</a>
      <p class="address"><i class="fas fa-map-marker-alt"></i><span><?php if ($fetch_profile['address'] == '') {
                                                                        echo 'please enter your address';
                                                                     } else {
                                                                        echo $fetch_profile['address'];
                                                                     } ?></span></p>
      <a href="update_address.php" class="btn">update address</a>
   </div>

</section>

<?php include 'components/footer.php'; ?>