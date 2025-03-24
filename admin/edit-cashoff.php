<?php
   session_start();
   include('include/config.php');
   if(strlen($_SESSION['alogin'])==0)
   	{	
   header('location:index.php');
   }
   else{
   	$cid=intval($_GET['id']);
   if(isset($_POST['submit']))
   {
   	$cashoff=$_POST['cashoff'];
   	$value=$_POST['value'];
   	$status=$_POST['status'];
   	
   $sql=mysqli_query($con,"update cashoffpayment set cashoff='$cashoff', value='$value', status='$status' where id='$cid' ");
   $_SESSION['msg']="Data Updated Successfully !!";
   
   }
   
   
   ?>
<!DOCTYPE html>
<html lang="en">
    <?php include('include/head.php');?>
    <script type="text/javascript" src="//code.jquery.com/jquery-1.10.2.js"></script>
      <script type="text/javascript">
         function sum() {
             var price = document.getElementById('cashoff').value;
             var result = (parseInt(price)/100);
         if (!isNaN(result)) {
                 document.getElementById('value').value = result;
             }
        
         }
      </script>
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
                           <h3>Edit Images</h3>
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
                              <?php 
                                 $query=mysqli_query($con,"select * from cashoffpayment where id='$cid'");
                                 $cnt=1;
                                 while($row=mysqli_fetch_array($query))
                                 {                                 ?>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Cashoff</label>
                                 <div class="controls">
                                    <input type="text"    name="cashoff"  id="cashoff"  placeholder="Enter Cashoff" value="<?php echo htmlentities($row['cashoff']);?>" class="span8 tip" onkeyup=sum(); required>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Value</label>
                                 <div class="controls">
                                    <input type="text"    name="value" id="value"  placeholder="Enter Value" value="<?php echo htmlentities($row['value']);?>" class="span8 tip" readonly>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Status</label>
                                 <div class="controls">
                                    <select   name="status"  id="status" class="span8 tip" required>
                                       <option value="<?php echo htmlentities($row['status']);?>"><?php echo htmlentities($row['status']);?></option>
                                       <option value="Active">Active</option>
                                       <option value="Inactive">Inactive</option>
                                    </select>
                                 </div>
                              </div>
                              <?php } ?>
                              <div class="control-group">
                                 <div class="controls">
                                    <button type="submit" name="submit" class="btn btn-success">Update</button>
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