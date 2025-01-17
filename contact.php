<?php
$title = 'Contact';

include "components/user_header.php";

if ($user_id === '') {
   header('location:/login.php');
}

if (isset($_POST['send'])) {

   $msg = $_POST['msg'];

   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE user_id = ? AND message = ?");
   $select_message->execute([$user_id, $msg]);

   if ($select_message->rowCount() > 0) {
      $message[] = 'already sent message!';
   } else {

      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, message) VALUES(?,?)");
      $insert_message->execute([$user_id, $msg]);

      $message[] = 'sent message successfully!';
   }
}

?>

<div class="heading">
   <h3>contact us</h3>
   <p><a href="home.php">home</a> <span> / contact</span></p>
</div>

<!-- contact section starts  -->

<section class="contact">

   <div class="row">

      <div class="image">
         <img src="images/contact-img.svg" alt="">
      </div>

      <form action="" method="post">
         <h3>tell us something!</h3>
         <input type="text" name="name" disabled maxlength="50" class="box" value="<?= $fetch_profile['name']; ?>" placeholder="enter your name" required>
         <input type="text" name="number" disabled class="box" value="<?= $fetch_profile['number']; ?>" placeholder="enter your number" required maxlength="20">
         <input type="email" name="email" disabled maxlength="50" class="box" placeholder="enter your email" value="<?= $fetch_profile['email']; ?>" required>
         <textarea name="msg" class="box" required placeholder="enter your message" maxlength="500" cols="30" rows="10"></textarea>
         <input type="submit" value="send message" name="send" class="btn">
      </form>

   </div>

</section>

<?php include 'components/footer.php'; ?>