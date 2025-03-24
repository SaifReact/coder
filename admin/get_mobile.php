<?php
   include('include/config.php');
   if(!empty($_POST["id"])) 
   {
    $id=intval($_POST['id']);
   $query=mysqli_query($con,"SELECT * FROM users WHERE id=$id");
   ?>
<?php
   while($row=mysqli_fetch_array($query))
   {
    ?>
<option value="<?php echo htmlentities($row['contactno']); ?>"><?php echo htmlentities($row['contactno']); ?></option>
<?php
   }
   }
   ?>