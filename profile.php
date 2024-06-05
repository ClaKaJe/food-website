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
      <img src="images/user-icon.png" alt="">
      <p><i class="fas fa-user"></i><span><span><?= $fetch_profile['name']; ?></span></span></p>
      <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number']; ?></span></p>
      <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email']; ?></span></p>
      <a href="update_profile.php" class="btn">update info</a>
      <p class="address">
         <i class="fas fa-map-marker-alt"></i>
         <span>
            <?php
            $address = $conn->prepare("SELECT * FROM `address` WHERE id = ?");
            $address->execute([$fetch_profile['address_id']]);
            $fetch_address = $address->fetch(PDO::FETCH_ASSOC);

            $address_str = $fetch_address['city_name'] . ' - ' . $fetch_address['postal_code'] . ', ' . $fetch_address['area_name'];

            echo $address_str;
            ?>
         </span>
      </p>
      <a href="update_address.php" class="btn">update address</a>
   </div>

</section>

<?php include 'components/footer.php'; ?>