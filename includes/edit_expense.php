<section class="edit-expenses-container">
  <?php
  if(isset($_GET['edit'])){
      $edit_id = $_GET['edit'];
      $edit_query = mysqli_query($connection, "SELECT * FROM `expenses` WHERE id = $edit_id");
      if(mysqli_num_rows($edit_query) > 0){
        while($fetch_edit = mysqli_fetch_assoc($edit_query)){
  ?>
  <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_id" value="<?php echo $fetch_edit['id']; ?>">
      <label for="update_name">Expenses Name</label>
      <input type="text" class="box" required name="update_expenses_name" value="<?php echo $fetch_edit['expenses_name']; ?>">
      <label for="update_amount">Amount</label>
      <input type="number" class="box" required name="update_amount" value="<?php echo $fetch_edit['expenses_amount']; ?>">
      <label for="update_date">Date stored</label>
      <input type="date" class="box" required name="update_date" value="<?php echo $fetch_edit['expenses_date']; ?>">
      <label for="update_name">Spender Name</label>
      <input type="text"  class="box" required name="update_name" value="<?php echo $fetch_edit['spender_name']; ?>">
      <label for="update_category">Category</label>
      <select name="update_category_id" required>
        <?php
        $categories_query = mysqli_query($connection, "SELECT * FROM categories");
        while($category = mysqli_fetch_assoc($categories_query)){
            $selected = ($category['id'] == $fetch_edit['category_id']) ? 'selected' : '';
            echo '<option value="'.$category['id'].'" '.$selected.'>'.$category['category_name'].'</option>';
        }
        ?>
      </select>
      <input type="submit" value="update" name="update_expenses" class="expenses-update-btn">
      <input type="reset" value="cancel" id="close-edit" class="expenses-cancel-btn">
  </form>
  <?php
            };
        };
        echo "<script>document.querySelector('.edit-expenses-container').style.display = 'flex';</script>";
      };
  ?>
</section>