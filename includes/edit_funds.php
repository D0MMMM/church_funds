<section class="edit-funds-container">
  <?php
  if(isset($_GET['edit'])){
      $edit_id = $_GET['edit'];
      $edit_query = mysqli_query($connection, "SELECT * FROM `funds` WHERE id = $edit_id");
      if(mysqli_num_rows($edit_query) > 0){
        while($fetch_edit = mysqli_fetch_assoc($edit_query)){
  ?>
  <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_id" value="<?php echo $fetch_edit['id']; ?>">
      <label for="update_amount">Amount</label>
      <input type="number" class="box" required name="update_amount" value="<?php echo $fetch_edit['amount']; ?>">
      <label for="update_date">Date stored</label>
      <input type="date" class="box" required name="update_date" value="<?php echo $fetch_edit['date']; ?>">
      <label for="update_name">Collector Name</label>
      <input type="text"  class="box" required name="update_name" value="<?php echo $fetch_edit['depositor_name']; ?>">
      <input type="submit" value="update" name="update_funds" class="funds-update-btn">
      <input type="reset" value="cancel" id="close-funds-edit" class="funds-cancel-btn">
  </form>
  <?php
            };
        };
        echo "<script>document.querySelector('.edit-funds-container').style.display = 'flex';</script>";
      };
  ?>
</section>