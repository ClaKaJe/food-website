<?php
$title = 'Users Accounts';
$page = 'users_accounts.php';

include '../components/admin_header.php';

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_users = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_users->execute([$delete_id]);
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
   $delete_order->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart->execute([$delete_id]);
   header('location:users_accounts.php');
}
?>

<section class="accounts">

   <h1 class="heading">users account</h1>

   <div class="box-container">

      <?php
      $select_account = $conn->prepare("SELECT * FROM `users` ORDER BY registered_at DESC");
      $select_account->execute();
      if ($select_account->rowCount() > 0) {
         while ($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)) {
      ?>
            <div class="box">
               <p> <i class="fas fa-user"></i> username : <span><?= $fetch_accounts['name']; ?></span> </p>
               <p> <i class="fas fa-phone"></i> number : <span><?= $fetch_accounts['number']; ?></span> </p>
               <p> <i class="fas fa-envelope"></i> email : <span><?= $fetch_accounts['email']; ?></span> </p>
               <p> <i class="fas fa-map-marker-alt"></i> address : <span>
                     <?php
                     $address = $conn->prepare("SELECT * FROM `address` WHERE id = ?");
                     $address->execute([$fetch_accounts['address_id']]);
                     $fetch_address = $address->fetch(PDO::FETCH_ASSOC);

                     $address_str = $fetch_address['city_name'] . ' - ' . $fetch_address['postal_code'] . ', ' . $fetch_address['area_name'];

                     echo $address_str;
                     ?>
                  </span> </p>
               <a href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn" onclick="return confirm('delete this account?');">delete</a>
            </div>
      <?php
         }
      } else {
         echo '<p class="empty">no accounts available</p>';
      }
      ?>

   </div>

</section>

<script src="../js/admin_script.js"></script>

</body>

</html>