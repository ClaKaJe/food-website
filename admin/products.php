<?php
$title = 'Products';
$page = 'products.php';

include '../components/admin_header.php';

if (isset($_POST['add_product'])) {
   $description = $_POST['description'];
   $name = $_POST['name'];
   $price = $_POST['price'];
   $category = $_POST['category'];

   $select_category_id = $conn->prepare("SELECT * FROM `categories` WHERE name = ?");
   $select_category_id->execute([$category]);

   $category_id = $select_category_id->fetch(PDO::FETCH_ASSOC)['id'];

   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/' . $image;

   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if ($select_products->rowCount() > 0) {
      $message[] = 'product name already exists!';
   } else {
      if ($image_size > 2000000) {
         $message[] = 'image size is too large';
      } else {
         move_uploaded_file($image_tmp_name, $image_folder);

         $insert_product = $conn->prepare("INSERT INTO `products`(name, categories_id, price, image, description) VALUES(?,?,?,?,?)");
         $insert_product->execute([$name, $category_id, $price, $image, $description]);

         $message[] = 'new product added!';
      }
   }
}

if (isset($_GET['delete'])) {

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/' . $fetch_delete_image['image']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart->execute([$delete_id]);
   header('location:products.php');
}

?>

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>add product</h3>
      <input type="text" required placeholder="enter product name" name="name" maxlength="100" class="box">
      <input type="number" min="0" max="9999999999" required placeholder="enter product price" name="price" onkeypress="if(this.value.length == 10) return false;" class="box">
      <textarea type="text" placeholder="enter product's description" name="description" maxlength="500" cols="10" class="box"></textarea>
      <select name="category" class="box" required>
         <option value="" disabled selected>select category --</option>
         <option value="main dish">main dish</option>
         <option value="fast food">fast food</option>
         <option value="drinks">drinks</option>
         <option value="desserts">desserts</option>
      </select>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      <input type="submit" value="add product" name="add_product" class="btn">
   </form>

</section>

<section class="show-products" style="padding-top: 0;">

   <div class="box-container">

      <?php
      $show_products = $conn->prepare("SELECT * FROM `products`");
      $show_products->execute();
      if ($show_products->rowCount() > 0) {
         while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {
      ?>
            <div class="box">
               <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
               <div class="flex">
                  <div class="price"><span>$</span><?= $fetch_products['price']; ?><span>/-</span></div>
                  <div class="category">
                     <?php
                     $categories = $conn->prepare("SELECT * FROM `categories` WHERE id = ?");
                     $categories->execute([$fetch_products['categories_id']]);

                     echo $categories->fetch(PDO::FETCH_ASSOC)['name'];
                     ?>
                  </div>
               </div>
               <div class="name"><?= $fetch_products['name']; ?></div>
               <div class="flex-btn">
                  <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>
                  <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
               </div>
            </div>
      <?php
         }
      } else {
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>

   </div>

</section>

<script src="../js/admin_script.js"></script>

</body>

</html>