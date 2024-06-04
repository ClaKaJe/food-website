<?php
$title = 'Category';

include 'components/user_header.php';

include 'components/add_cart.php';
?>

<section class="products">

   <h1 class="title">food category</h1>

   <div class="box-container">

      <?php
      $category = $_GET['category'];
      // $select_products = $conn->prepare("SELECT * FROM `products` WHERE category = ?");
      $select_products = $conn->prepare(
         "SELECT *
         FROM `products`
         WHERE categories_id = (SELECT id FROM categories WHERE name = ?)");
      $select_products->execute([$category]);
      if ($select_products->rowCount() > 0) {
         while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
      ?>
            <form action="" method="post" class="box">
               <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
               <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
               <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
               <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
               <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
               <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
               <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
               <div class="name"><?= $fetch_products['name']; ?></div>
               <div class="flex">
                  <div class="price"><span>$</span><?= $fetch_products['price']; ?></div>
                  <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
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