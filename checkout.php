<?php
$title = 'Checkout';
$page = 'checkout.php';

include 'components/user_header.php';

if ($user_id === '') {
   header('location:/login.php');
}

if (isset($_POST['submit'])) {

   $name = $_POST['name'];
   $number = $_POST['number'];
   $email = $_POST['email'];
   $method = $_POST['method'];
   $address = $_POST['address'];
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if ($check_cart->rowCount() > 0) {
      $payment_method = $conn->prepare("SELECT * from `payment_method` WHERE name = ?");
      $payment_method->execute([$method]);
      $fetch_payment_method = $payment_method->fetch(PDO::FETCH_ASSOC);

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, payment_method_id, total_products, total_price, payment_status) VALUES(?,?,?,?,?)");
      $insert_order->execute([$user_id, $fetch_payement_method['id'], $total_products, $total_price, 'pending']);

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'order placed successfully!';
   } else {
      $message[] = 'your cart is empty';
   }
}

?>

<div class="heading">
   <h3>checkout</h3>
   <p><a href="/">home</a> <span> / checkout</span></p>
</div>

<section class="checkout">

   <h1 class="title">order summary</h1>

   <form action="" method="post">

      <div class="cart-items">
         <h3>cart items</h3>
         <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if ($select_cart->rowCount() > 0) {
            while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
               $cart_items[] = $fetch_cart['name'] . ' (' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity'] . ') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
         ?>
               <p><span class="name"><?= $fetch_cart['name']; ?></span><span class="price">$<?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?></span></p>
         <?php
            }
         } else {
            echo '<p class="empty">your cart is empty!</p>';
         }
         ?>
         <p class="grand-total"><span class="name">grand total :</span><span class="price">$<?= $grand_total; ?></span></p>
         <a href="cart.php" class="btn">veiw cart</a>
      </div>

      <input type="hidden" name="total_products" value="<?= $total_products; ?>">
      <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
      <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
      <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
      <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
      <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">

      <div class="user-info">
         <h3>your info</h3>
         <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
         <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
         <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
         <a href="update_profile.php" class="btn">update info</a>
         <h3>delivery address</h3>
         <p>
            <i class="fas fa-map-marker-alt"></i>
            <span>
               <?php
               $address = $conn->prepare("SELECT * FROM `address` WHERE id = ?");
               $address->execute([$fetch_profile['address_id']]);
               $fetch_address = $address->fetch(PDO::FETCH_ASSOC);

               $address_str = $fetch_address['country_name'] . ', ' . $fetch_address['state_name'] . ', ' . $fetch_address['city_name'] . ' - ' . $fetch_address['pin_code'];

               echo $address_str;
               ?>
            </span>
         </p>
         <a href="update_address.php" class="btn">update address</a>
         <select name="method" class="box" required>
            <option value="" disabled selected>select payment method --</option>
            <option value="cash on delivery">cash on delivery</option>
            <option value="credit card">credit card</option>
            <option value="paytm">paytm</option>
            <option value="paypal">paypal</option>
         </select>
         <input type="submit" value="place order" class="btn" style="width:100%; background:var(--red); color:var(--white);" name="submit">
      </div>

   </form>

</section>

<?php include 'components/footer.php'; ?>