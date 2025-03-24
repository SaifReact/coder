<section class="body-content outer-top-xs">
            <div class="container" >
               <div class="info-boxes wow fadeInUp">
                  <div class="info-boxes-inner">
                     <div class="row">
					 <?php
                   $sql=mysqli_query($con,"select * from images where imageSelect = 'LA' and status = 'Active'");
                	while($row=mysqli_fetch_array($sql))
                	{	?>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                           <img src="admin/images/<?php echo $row['id'];?>/<?php echo $row['images'];?>" height="75px" width="200px"/>
                        </div>
                        <?php } ?>
                     </div>
                  </div>
               </div>
            </div>
         </section>