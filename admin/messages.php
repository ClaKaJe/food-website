<?php
$title = 'Messages';

include '../components/connect.php';

include '../components/admin_header.php';

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   header('location:messages.php');
}

?>

<section class="messages">

   <h1 class="heading">messages</h1>

   <div class="box-container">

      <?php
      $select_messages = $conn->prepare("SELECT * FROM `messages`");
      $select_messages->execute();
      if ($select_messages->rowCount() > 0) {
         while ($fetch_messages = $select_messages->fetch(PDO::FETCH_ASSOC)) {
            $users = $conn->prepare("SELECT * FROM `users` WHERE id = (SELECT user_id FROM `messages` WHERE id = ?) ");
            $users->execute([$fetch_messages['id']]);
            $fetch_user = $users->fetch(PDO::FETCH_ASSOC);
      ?>
            <div class="box">
               <p> name : <span><?= $fetch_user['name'] ?></span> </p>
               <p> number : <span><?= $fetch_user['number']; ?></span> </p>
               <p> email : <span><?= $fetch_user['email']; ?></span> </p>
               <p> message : <span><?= $fetch_messages['message']; ?></span> </p>
               <a href="messages.php?delete=<?= $fetch_messages['id']; ?>" class="delete-btn" onclick="return confirm('delete this message?');">delete</a>
            </div>
      <?php
         }
      } else {
         echo '<p class="empty">you have no messages</p>';
      }
      ?>

   </div>

</section>

<script src="../js/admin_script.js"></script>

</body>

</html>