<?php
$title = 'Orders';
$page = 'orders.php';

include "components/user_header.php";

if ($user_id === '') {
   header('location:/login.php');
}
?>

<div class="heading">
   <h3>orders</h3>
   <p><a href="/">home</a> <span> / orders</span></p>
</div>

<section class="orders">

   <h1 class="title">your orders</h1>

   <div class="box-container">

      <?php
      if ($user_id == '') {
         echo '<p class="empty">please login to see your orders</p>';
      } else {
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if ($select_orders->rowCount() > 0) {
            while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
      ?>
               <div class="box">
                  <p>placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
                  <p>name : <span><?= $fetch_profile['name']; ?></span></p>
                  <p>email : <span><?= $fetch_profile['email']; ?></span></p>
                  <p>number : <span><?= $fetch_profile['number']; ?></span></p>
                  <p>address :
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
                  <p>payment method :
                     <span>
                        <?php
                        $payment_method = $conn->prepare("SELECT * FROM `payment_method` WHERE id = ?");
                        $payment_method->execute([$fetch_orders['payment_method_id']]);
                        $fetch_payment_method = $payment_method->fetch(PDO::FETCH_ASSOC);
            
                        echo $fetch_payment_method['name']; 
                        ?>
                     </span>
                  </p>
                  <p>your orders : <span><?= $fetch_orders['total_products']; ?></span></p>
                  <p>total price : <span>$<?= $fetch_orders['total_price']; ?>/-</span></p>
                  <p> payment status : <span style="color:
                  <?php if ($fetch_orders['payment_status'] == 'pending') {
                     echo 'red';
                  } else {
                     echo 'green';
                  }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
               </div>
      <?php
            }
         } else {
            echo '<p class="empty">no orders placed yet!</p>';
         }
      }
      ?>

   </div>

</section>

<?php include 'components/footer.php'; ?>