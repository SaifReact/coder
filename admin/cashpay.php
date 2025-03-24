<?php
   session_start();
   include('include/config.php');
   if(strlen($_SESSION['alogin'])==0)
   	{	
   header('location:index.php');
   }
   else{
   	
   if(isset($_POST['submit']))
   {
   	$user = $_POST['user'];
   	$mobile = $_POST['mobile'];
   	$amount = $_POST['amount'];

   
   $sql=mysqli_query($con,"update  users set cashback='$amount' where id='$user' and contactno = '$mobile' ");
   $_SESSION['msg']="Cash Pay Inserted Successfully !!";
   
   } 
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include('include/head.php');?>
      <script>
         function getMobile(val) {
         	$.ajax({
         	type: "POST",
         	url: "get_mobile.php",
         	data:'id='+val,
         	success: function(data){
         		$("#mobile").html(data);
         	}
         	});
         }
         
      </script>	

   </head>
   <body>
      <?php include('include/header.php');?>
      <div class="wrapper">
         <div class="container">
            <div class="row">
               <?php include('include/sidebar.php');?>				
               <div class="span9">
                  <div class="content">
                     <div class="module">
                        <div class="module-head">
                           <h3>Cash Pay to Users</h3>
                        </div>
                        <div class="module-body">
                           <?php if(isset($_POST['submit']))
                              {?>
                           <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">×</button>
                              <strong>Well done!</strong>	<?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?>
                           </div>
                           <?php } ?>
                           <?php if(isset($_GET['del']))
                              {?>
                           <div class="alert alert-error">
                              <button type="button" class="close" data-dismiss="alert">×</button>
                              <strong>Oh snap!</strong> 	<?php echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?>
                           </div>
                           <?php } ?>
                           <br />
                           <form class="form-horizontal row-fluid" name="insertproduct" method="post" enctype="multipart/form-data">
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">User Name</label>
                                 <div class="controls">
                                    <select name="user" class="span8 tip" onChange="getMobile(this.value);"  required>
                                       <option value="">Select Users</option>
                                       <?php $query=mysqli_query($con,"select * from users");
                                          while($row=mysqli_fetch_array($query))
                                          {?>
                                       <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                                       <?php } ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Mobile No.</label>
                                 <div class="controls">
                                    <select   name="mobile"  id="mobile" class="span8 tip" required>
                                    </select>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Amount(Tk.)</label>
                                 <div class="controls">
                                    <input type="text"    name="amount"  placeholder="Enter Amont" class="span8 tip" required>
                                 </div>
                              </div>
                              
                              <div class="control-group">
                                 <div class="controls">
                                    <button type="submit" name="submit" class="btn btn-primary">Insert</button>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
                  <!--/.content-->
               </div>
               <!--/.span9-->
            </div>
         </div>
         <!--/.container-->
      </div>
      <!--/.wrapper-->
      <?php include('include/footer.php');?>
      <?php include('include/js.php');?>
   </body>
   <?php } ?>