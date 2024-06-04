<?php
$title = 'Placed orders';
$page = 'placed_orders.php';

include '../components/admin_header.php';

if (isset($_POST['update_payment'])) {
   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   $update_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_status->execute([$payment_status, $order_id]);
   $message[] = 'payment status updated!';
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
}

?>

<!-- placed orders section starts  -->

<section class="placed-orders">

   <h1 class="heading">placed orders</h1>

   <div class="box-container">

      <?php
      $select_orders = $conn->prepare("SELECT * FROM `orders` ORDER BY placed_on ASC");
      $select_orders->execute();
      if ($select_orders->rowCount() > 0) {
         while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
            $user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $user->execute([$fetch_orders['user_id']]);
            $fetch_user = $user->fetch(PDO::FETCH_ASSOC);
      ?>
            <div class="box">
               <p> placed on : <span><?= $fetch_orders['placed_on']; ?></span> </p>
               <p> name : <span><?= $fetch_user['name']; ?></span> </p>
               <p> email : <span><?= $fetch_user['email']; ?></span> </p>
               <p> number : <span><?= $fetch_user['number']; ?></span> </p>
               <p> address :
                  <span>
                     <?php
                     $address = $conn->prepare("SELECT * FROM `address` WHERE id = ?");
                     $address->execute([$fetch_user['address_id']]);
                     $fetch_address = $address->fetch(PDO::FETCH_ASSOC);

                     $address_str = $fetch_address['country_name'] . ', ' . $fetch_address['state_name'] . ', ' . $fetch_address['city_name'] . ' - ' . $fetch_address['pin_code'];

                     echo $address_str;
                     ?>
                  </span>
               </p>
               <p> total products : <span><?= $fetch_orders['total_products']; ?></span> </p>
               <p> total price : <span>$<?= $fetch_orders['total_price']; ?>/-</span> </p>
               <p> payment method :
                  <span>
                     <?php
                     $payment_method = $conn->prepare("SELECT * FROM `payment_method` WHERE id = ?");
                     $payment_method->execute([$fetch_orders['payment_method_id']]);

                     echo $payment_method->fetch(PDO::FETCH_ASSOC)['name'];
                     ?>
                  </span>
               </p>
               <form action="" method="POST">
                  <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                  <select name="payment_status" class="drop-down">
                     <option value="" selected disabled><?= $fetch_orders['payment_status']; ?></option>
                     <option value="pending">pending</option>
                     <option value="completed">completed</option>
                  </select>
                  <div class="flex-btn">
                     <input type="submit" value="update" class="btn" name="update_payment">
                     <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">delete</a>
                  </div>
               </form>
            </div>
      <?php
         }
      } else {
         echo '<p class="empty">no orders placed yet!</p>';
      }
      ?>

   </div>

</section>

<!-- placed orders section ends -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>

</html>