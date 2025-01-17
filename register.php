<?php
$title = 'Register';

include "components/user_header.php";

if (isset($_POST['submit'])) {

   $name = $_POST['name'];
   $email = $_POST['email'];
   $number = $_POST['number'];
   $pass = sha1($_POST['pass']);
   $cpass = sha1($_POST['cpass']);

   $_POST['flat_no'] === '' ? $flat = null : $flat = $_POST['flat_no'];
   $_POST['building_no'] === '' ? $building = null : $building = $_POST['building_no'] ;
   $area = $_POST['area_name'];
   $city = $_POST['city_name'];
   $state = $_POST['state_name'];
   $country = $_POST['country_name'];
   $postal_code = $_POST['postal_code'];

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? OR number = ?");
   $select_user->execute([$email, $number]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if ($select_user->rowCount() > 0) {
      $message[] = 'email or number already exists!';
   } else {
      if ($pass != $cpass) {
         $message[] = 'confirm password not matched!';
      } else {
         $insert_user = $conn->prepare("INSERT INTO `address`(flat_no, building_no, area_name, city_name, postal_code) VALUES(?,?,?,?,?)");
         $insert_user->execute([$flat, $building, $area, $city, $postal_code]);

         $address_id = $conn->lastInsertId();

         $insert_user = $conn->prepare("INSERT INTO `users`(name, email, number, password, address_id) VALUES(?,?,?,?,?)");
         $insert_user->execute([$name, $email, $number, $cpass, $address_id]);
         $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
         $select_user->execute([$email, $pass]);
         $row = $select_user->fetch(PDO::FETCH_ASSOC);
         if ($select_user->rowCount() > 0) {
            $_SESSION['user_id'] = $row['id'];
            header('location:/');
         }
      }
   }
}

?>

<section class="form-container">

   <form action="" method="post">
      <h3>register now</h3>
      <input type="text" name="name" required placeholder="enter your name" class="box" maxlength="20">
      <input type="email" name="email" required placeholder="enter your email" class="box" maxlength="50">
      <input type="text" name="number" required placeholder="enter your number" class="box" maxlength="20">
      <input type="password" name="pass" required placeholder="enter your password" class="box" maxlength="50">
      <input type="password" name="cpass" required placeholder="confirm your password" class="box" maxlength="50">

      <input type="number" name="flat_no" placeholder="enter your flat number" class="box" maxlength="10">
      <input type="number" name="building_no" placeholder="enter your building number" class="box" maxlength="10">
      <input type="text" name="area_name" required placeholder="enter your area name" class="box" maxlength="45">
      <input type="text" name="city_name" required placeholder="enter your city name" class="box" maxlength="45">
      <input type="number" name="postal_code" required placeholder="enter your postal code" class="box" maxlength="10">
      <input type="submit" value="register now" name="submit" class="btn">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>

</section>

<?php include 'components/footer.php'; ?>