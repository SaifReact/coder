<section class="body-content outer-top-xs">
            <div class="container" >
                     <div class="row">
					 <?php $query=mysqli_query($con,"select * from ticket");
                                    $cnt=1;
                                    while($row=mysqli_fetch_array($query))
                                    {
                                    ?>	
                        <div class="col-xs-12 col-sm-12 col-md-4">
                           <img src="admin/ticketimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['ticketImg']);?>" data-echo="admin/ticketimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['ticketImg']);?>" width="360px" height="160px">
                        </div>
						<?php } ?>
                     </div>
            </div>
         </section>