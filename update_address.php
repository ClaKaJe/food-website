<?php
$title = 'Update Address';
$page = 'update_address.php';

include "components/user_header.php";

if ($user_id === '') {
   header('location:/login.php');
}

$get_address = $conn->prepare("SELECT * FROM `address` WHERE id = ?");
$get_address->execute([$fetch_profile['address_id']]);
$fetch_address = $get_address->fetch(PDO::FETCH_ASSOC);

$flat = $fetch_address['flat_no'];
$building = $fetch_address['building_no'];
$area = $fetch_address['area_name'];
$city = $fetch_address['city_name'];
$state = $fetch_address['state_name'];
$country = $fetch_address['country_name'];
$pin_code = $fetch_address['pin_code'];

if (isset($_POST['submit'])) {

   $flat = $_POST['flat'];
   $building = $_POST['building'];
   $area = $_POST['area'];
   $city = $_POST['city'];
   $state = $_POST['state'];
   $country = $_POST['country'];
   $pin_code = $_POST['pin_code'];

   $update_address = $conn->prepare("UPDATE `address` SET flat_no = ?, building_no = ?, area_name = ?, city_name = ?, state_name = ?, country_name = ?, pin_code = ? WHERE id = ?");
   $update_address->execute([$flat, $building, $area, $city, $state, $country, $pin_code, $fetch_profile['address_id']]);

   header('location:/profile.php');

   $message[] = 'address saved!';
}

echo $message;
?>

<section class="form-container">

   <form action="" method="post">
      <h3>your address</h3>
      <input type="text" class="box" placeholder="flat number." value="<?= $flat; ?>" required maxlength="50" name="flat">
      <input type="text" class="box" placeholder="building number." value="<?= $building; ?>" required maxlength="50" name="building">
      <input type="text" class="box" placeholder="area name" value="<?= $area; ?>" required maxlength="50" name="area">
      <input type="text" class="box" placeholder="city name" value="<?= $city; ?>" required maxlength="50" name="city">
      <input type="text" class="box" placeholder="state name" value="<?= $state; ?>" required maxlength="50" name="state">
      <input type="text" class="box" placeholder="country name" value="<?= $country; ?>" required maxlength="50" name="country">
      <input type="number" class="box" placeholder="pin code" value="<?= $pin_code; ?>" required max="999999" min="0" maxlength="6" name="pin_code">
      <input type="submit" value="save address" name="submit" class="btn">
   </form>

</section>

<?php include 'components/footer.php' ?>