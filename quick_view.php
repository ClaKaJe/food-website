<?php
$title = 'Quick View';
$page = 'quick_view.php';

include 'components/user_header.php';

include 'components/add_cart.php';
?>

<section class="quick-view">

   <h1 class="title">quick view</h1>

   <?php
   $pid = $_GET['pid'];
   $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $select_products->execute([$pid]);
   if ($select_products->rowCount() > 0) {
      while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
   ?>
         <form action="" method="post" class="box">
            <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
            <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
            <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
            <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
            <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
            <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
            <div class="name"><?= $fetch_products['name']; ?></div>
            <div class="flex">
               <div class="price"><span>$</span><?= $fetch_products['price']; ?></div>
               <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
            </div>
            <div class="name">
               <?= $fetch_products['description'] ?>
            </div>

            <button type="submit" name="add_to_cart" class="cart-btn">add to cart</button>
         </form>
   <?php
      }
   } else {
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

</section>

<?php include 'components/footer.php'; ?>