<?php
$title = 'Update Products';
$page = 'update_product.php';

include '../components/admin_header.php';

function get_category(PDO $conn, string $table): string
{
   $categories = $conn->prepare("SELECT * FROM `categories` WHERE id = (SELECT categories_id FROM `products` WHERE id = ?) ");
   $categories->execute([$_GET['update']]);

   return $categories->fetch(PDO::FETCH_ASSOC)[$table];
}

if (isset($_POST['update'])) {
   $pid = $_POST['pid'];
   $description = $_POST['description'];
   $name = $_POST['name'];
   $price = $_POST['price'];
   $category_id = get_category($conn, 'id');

   $update_product = $conn->prepare("UPDATE `products` SET name = ?, categories_id = ?, price = ?, description = ? WHERE id = ?");
   $update_product->execute([$name, $category_id, $price, $description, $pid]);

   $message[] = 'product updated!';

   $old_image = $_POST['old_image'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/' . $image;

   if (!empty($image)) {
      if ($image_size > 2000000) {
         $message[] = 'images size is too large!';
      } else {
         $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
         $update_image->execute([$image, $pid]);
         move_uploaded_file($image_tmp_name, $image_folder);
         unlink('../uploaded_img/' . $old_image);
         $message[] = 'image updated!';
      }
   }

   header('location:products.php');
}
?>

<section class="update-product">

   <h1 class="heading">update product</h1>

   <?php
   $update_id = $_GET['update'];
   $show_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $show_products->execute([$update_id]);
   if ($show_products->rowCount() > 0) {
      while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {
   ?>
         <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
            <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
            <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
            <span>update name</span>
            <input type="text" required placeholder="enter product name" name="name" maxlength="100" class="box" value="<?= $fetch_products['name']; ?>">
            <textarea type="text" placeholder="enter product's description" name="description" maxlength="300" class="box"><?= $fetch_products['description']; ?></textarea>
            <span>update price</span>
            <input type="number" min="0" max="9999999999" required placeholder="enter product price" name="price" onkeypress="if(this.value.length == 10) return false;" class="box" value="<?= $fetch_products['price']; ?>">
            <span>update category</span>
            <select name="category" class="box" required>
               <option selected value="<?= get_category($conn, 'name') ?>"><?= get_category($conn, 'name') ?></option>
               <option value="main dish">main dish</option>
               <option value="fast food">fast food</option>
               <option value="drinks">drinks</option>
               <option value="desserts">desserts</option>
            </select>
            <span>update image</span>
            <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
            <div class="flex-btn">
               <input type="submit" value="update" class="btn" name="update">
            </div>
         </form>
   <?php
      }
   } else {
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

</section>

<script src="../js/admin_script.js"></script>

</body>

</html>