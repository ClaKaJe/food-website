<?php
$title = 'Menu';

include 'components/user_header.php';

include 'components/add_cart.php';
?>

<div class="heading">
   <h3>our menu</h3>
   <p><a href="/">home</a> <span> / menu</span></p>
</div>

<!-- menu section starts  -->

<section class="products">

   <h1 class="title">latest dishes</h1>

   <div class="box-container">

      <?php
      $select_products = $conn->prepare("SELECT * FROM `products`");
      $select_products->execute();
      if ($select_products->rowCount() > 0) {
         while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            $select_category = $conn->prepare("SELECT * FROM `categories` WHERE id = ?");
            $select_category->execute([$fetch_products['categories_id']]);
            $category = $select_category->fetch(PDO::FETCH_ASSOC);
      ?>
            <form action="" method="post" class="box">
               <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
               <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
               <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
               <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
               <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
               <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
               <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
               <a href="category.php?category=<?= $category['name'] ?>" class="cat"><?= $category['name'] ?></a>
               <div class="name"><?= $fetch_products['name']; ?></div>
               <div class="flex">
                  <div class="price"><span>$</span><?= $fetch_products['price']; ?></div>
                  <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2"">
         </div>
      </form>
      <?php
         }
      } else {
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>

   </div>

</section>

<?php include 'components/footer.php'; ?>