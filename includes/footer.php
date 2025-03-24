<footer class="footer color-bg">
<div class="links-social inner-top-sm">
   <div class="container">
      <div class="row">
         <div class="col-xs-12 col-sm-6 col-md-4">
            <!-- ============================================================= CONTACT INFO ============================================================= -->
            <div class="contact-info">
               <div class="footer-logo">
                  <div class="logo">
                     <a href="index.php">
                        <h3><?php if(isset($compName)){ echo $compName;}?></h3>
                     </a>
                  </div>
                  <!-- /.logo -->
               </div>
               <!-- /.footer-logo -->
               <div class="module-body m-t-20">
                  <p class="about-us"><?php if(isset($compDescription)){ echo $compDescription;}?></p>
                  <div class="social-icons"> <a href="<?php if(isset($facebook)){ echo $facebook;}?>" class='active'><i class="icon fa fa-facebook"></i></a>
                     <a href="<?php if(isset($twitter)){ echo $twitter;}?>"><i class="icon fa fa-twitter"></i></a>
                     <a href="<?php if(isset($linkedin)){ echo $linkedin;}?>"><i class="icon fa fa-linkedin"></i></a>
                  </div>
                  <!-- /.social-icons -->
               </div>
               <!-- /.module-body -->
            </div>
            <!-- /.contact-info -->
            <!-- ============================================================= CONTACT INFO : END ============================================================= -->
         </div>
         <!-- /.col -->
         <div class="col-xs-12 col-sm-6 col-md-4">
            <!-- ============================================================= CONTACT TIMING============================================================= -->
            <div class="contact-timing">
               <div class="module-heading">
                  <h4 class="module-title">opening time</h4>
               </div>
               <!-- /.module-heading -->
               <div class="module-body outer-top-xs">
                  <div class="table-responsive">
                     <table class="table">
                        <tbody>
                           <tr>
                              <td>Monday-Friday:</td>
                              <td class="pull-right">08.00AM To 10.00PM</td>
                           </tr>
                           <tr>
                              <td>Saturday:</td>
                              <td class="pull-right">09.00AM To 10.00PM</td>
                           </tr>
                           <tr>
                              <td>Sunday:</td>
                              <td class="pull-right">10.00AM To 10.00PM</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
                  <!-- /.table-responsive -->
               </div>
               <!-- /.module-body -->
            </div>
            <!-- /.contact-timing -->
            <!-- ============================================================= CONTACT TIMING : END ============================================================= -->
         </div>
         <!-- /.col -->
         <div class="col-xs-12 col-sm-6 col-md-4">
            <!-- ============================================================= INFORMATION============================================================= -->
            <div class="contact-information">
               <div class="module-heading">
                  <h4 class="module-title">info</h4>
               </div>
               <!-- /.module-heading -->
               <div class="module-body outer-top-xs">
                  <ul class="toggle-footer" style="">
                     <li class="media">
                        <div class="pull-left"> <span class="icon fa-stack fa-lg">
                           <i class="fa fa-circle fa-stack-2x"></i>
                           <i class="fa fa-map-marker fa-stack-1x fa-inverse"></i>
                           </span>
                        </div>
                        <div class="media-body">
                           <p><?php if(isset($address)){ echo $address;}?></p>
                        </div>
                     </li>
                     <li class="media">
                        <div class="pull-left"> <span class="icon fa-stack fa-lg">
                           <i class="fa fa-circle fa-stack-2x"></i>
                           <i class="fa fa-mobile fa-stack-1x fa-inverse"></i>
                           </span>
                        </div>
                        <div class="media-body">
                           <p><?php if(isset($phone1)){ echo $phone1;}?>
                           <br><?php if(isset($phone2)){ echo $phone2;}?>
                           </p>
                        </div>
                     </li>
                     <li class="media">
                        <div class="pull-left"> <span class="icon fa-stack fa-lg">
                           <i class="fa fa-circle fa-stack-2x"></i>
                           <i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
                           </span>
                        </div>
                        <div class="media-body"> <span><a href="#"><?php if(isset($email)){ echo $email;}?></a></span>
                        </div>
                     </li>
                  </ul>
               </div>
               <!-- /.module-body -->
            </div>
            <!-- /.contact-timing -->
            <!-- ============================================================= INFORMATION : END ============================================================= -->
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container -->
</div>
<div class="container" style="background:#000; padding-top:10px; color:#FFF;">
      <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-6"><p>
                                © 2021 BrandsCollecction - All Reserved</p></div>
          <div class="col-xs-12 col-sm-12 col-md-6"><p style="text-align:right; ">Design & Developed By: <a href="http://coderhome.org/" target="_blank">CoderHome</a></p></div>
    </div>
</div>
<!-- /.links-social -->
</footer>