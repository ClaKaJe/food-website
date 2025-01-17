<?php
$title = 'Home';

include 'components/user_header.php';

include 'components/add_cart.php';
?>

<section class="hero">

   <div class="swiper hero-slider">

      <div class="swiper-wrapper">

         <div class="swiper-slide slide">
            <div class="content">
               <span>order online</span>
               <h3>delicious pizza</h3>
               <a href="menu.php" class="btn">see menus</a>
            </div>
            <div class="image">
               <img src="images/home-img-1.png" alt="">
            </div>
         </div>

         <div class="swiper-slide slide">
            <div class="content">
               <span>order online</span>
               <h3>chezzy hamburger</h3>
               <a href="menu.php" class="btn">see menus</a>
            </div>
            <div class="image">
               <img src="images/home-img-2.png" alt="">
            </div>
         </div>

         <div class="swiper-slide slide">
            <div class="content">
               <span>order online</span>
               <h3>rosted chicken</h3>
               <a href="menu.php" class="btn">see menus</a>
            </div>
            <div class="image">
               <img src="images/home-img-3.png" alt="">
            </div>
         </div>

      </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

<section class="category">

   <h1 class="title">food category</h1>

   <div class="box-container">

      <a href="category.php?category=fast food" class="box">
         <img src="images/cat-1.png" alt="">
         <h3>fast food</h3>
      </a>

      <a href="category.php?category=main dish" class="box">
         <img src="images/cat-2.png" alt="">
         <h3>main dishes</h3>
      </a>

      <a href="category.php?category=drinks" class="box">
         <img src="images/cat-3.png" alt="">
         <h3>drinks</h3>
      </a>

      <a href="category.php?category=desserts" class="box">
         <img src="images/cat-4.png" alt="">
         <h3>desserts</h3>
      </a>

   </div>

</section>




<section class="products">

   <h1 class="title">latest dishes</h1>

   <div class="box-container">

      <?php
      $select_products = $conn->prepare("SELECT * FROM `products` ORDER BY created_at DESC LIMIT 6");
      $select_products->execute();
      if ($select_products->rowCount() > 0) {
         while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            $select_category_name = $conn->prepare("SELECT * FROM `categories` WHERE id = ?");
            $select_category_name->execute([$fetch_products['categories_id']]);
            $category = $select_category_name->fetch(PDO::FETCH_ASSOC)['name'];
      ?>
            <form action="" method="post" class="box">
               <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
               <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
               <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
               <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
               <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
               <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
               <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
               <a href="category.php?category=<?= $category; ?>" class="cat"><?= $category; ?></a>
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

   <div class="more-btn">
      <a href="menu.php" class="btn">veiw all</a>
   </div>

</section>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script>
   var swiper = new Swiper(".hero-slider", {
      loop: true,
      grabCursor: true,
      effect: "flip",
      pagination: {
         el: ".swiper-pagination",
         clickable: true,
      },
   });
</script>


<?php include 'components/footer.php'; ?>