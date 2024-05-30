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
      $select_account = $conn->prepare("SELECT * FROM `users`");
      $select_account->execute();
      if ($select_account->rowCount() > 0) {
         while ($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)) {
      ?>
            <div class="box">
               <p> user id : <span><?= $fetch_accounts['id']; ?></span> </p>
               <p> username : <span><?= $fetch_accounts['name']; ?></span> </p>
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

<!-- user accounts section ends -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>

</html>