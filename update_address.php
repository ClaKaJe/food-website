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
$postal_code = $fetch_address['postal_code'];

if (isset($_POST['submit'])) {

   $_POST['flat'] === '' ? $flat = null : $flat = $_POST['flat'];
   $_POST['building'] === '' ? $building = null : $building = $_POST['building'];
   $area = $_POST['area'];
   $city = $_POST['city'];
   $postal_code = $_POST['postal_code'];

   $update_address = $conn->prepare("UPDATE `address` SET flat_no = ?, building_no = ?, area_name = ?, city_name = ?, postal_code = ? WHERE id = ?");
   $update_address->execute([$flat, $building, $area, $city, $postal_code, $fetch_profile['address_id']]);

   header('location:/profile.php');

   $message[] = 'address saved!';
}
?>

<section class="form-container">

   <form action="" method="post">
      <h3>your address</h3>
      <input type="number" class="box" placeholder="flat number." value="<?= $flat; ?>" maxlength="10" name="flat">
      <input type="number" class="box" placeholder="building number." value="<?= $building; ?>" maxlength="10" name="building">
      <input type="text" class="box" placeholder="area name" value="<?= $area; ?>" required maxlength="45" name="area">
      <input type="text" class="box" placeholder="city name" value="<?= $city; ?>" required maxlength="45" name="city">
      <input type="number" class="box" placeholder="postal code" value="<?= $postal_code; ?>" required max="999999" name="postal_code">
      <input type="submit" value="save address" name="submit" class="btn">
   </form>

</section>

<?php include 'components/footer.php' ?>