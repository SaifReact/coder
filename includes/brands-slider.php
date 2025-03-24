<div class="col-xs-12 col-sm-12 col-md-12">
    <div id="brands-carousel" class="logo-slider wow fadeInUp">
        <div class="section-title">
                  <h2>Our Brands</h2>
        </div>
   <div class="logo-slider-inner">
      <div id="brand-slider" class="owl-carousel brand-slider custom-carousel owl-theme">
         <?php $ret=mysqli_query($con, "select * from brands"); while ($row=mysqli_fetch_array($ret)) { ?>
         <div class="item">
            <a href="admin/brandsimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['brandsImage']);?>" data-lightbox="image-1" data-title="<?php echo htmlentities($row['brandsName']);?>">
               <img data-echo="admin/brandsimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['brandsImage']);?>" width="80px" height="80px" alt="<?php echo htmlentities($row['brandsName']);?>">
               <div class="zoom-overlay"></div>
            </a>
         </div>
         <?php } ?>
      </div>
      <!-- /.owl-carousel #logo-slider -->
   </div>
   <!-- /.logo-slider-inner -->	
</div>
</div>
