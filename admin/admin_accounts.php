<?php
$title = 'Admin Account';
$page = 'admin_accounts';

include '../components/admin_header.php';

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_admin = $conn->prepare("DELETE FROM `admin` WHERE id = ?");
   $delete_admin->execute([$delete_id]);
   header('location:admin_accounts.php');
}

?>

<!-- admins accounts section starts  -->

<section class="accounts">

   <h1 class="heading">admins account</h1>

   <div class="box-container">

      <div class="box">
         <p>register new admin</p>
         <a href="register_admin.php" class="option-btn">register</a>
      </div>

      <?php
      $select_account = $conn->prepare("SELECT * FROM `admin`");
      $select_account->execute();
      if ($select_account->rowCount() > 0) {
         while ($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)) {
      ?>
            <div class="box">
               <p> admin id : <span><?= $fetch_accounts['id']; ?></span> </p>
               <p> username : <span><?= $fetch_accounts['name']; ?></span> </p>
               <div class="flex-btn">
                  <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn" onclick="return confirm('delete this account?');">delete</a>
                  <?php
                  if ($fetch_accounts['id'] == $admin_id) {
                     echo '<a href="update_profile.php" class="option-btn">update</a>';
                  }
                  ?>
               </div>
            </div>
      <?php
         }
      } else {
         echo '<p class="empty">no accounts available</p>';
      }
      ?>

   </div>

</section>

<!-- admins accounts section ends -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>

</html>