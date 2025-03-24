<head>
   <!-- Meta -->
   <meta charset="utf-8">
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
   <meta name="description" content="">
   <meta name="author" content="">
   <meta name="keywords" content="MediaCenter, Template, eCommerce">
   <meta name="robots" content="all">
   <title>BrandsCollection</title>
   <!-- Bootstrap Core CSS -->
   <link rel="stylesheet" href="assets/css/bootstrap.min.css">
   <!-- Customizable CSS -->
   <link rel="stylesheet" href="assets/css/main.css">
   <!--<link rel="stylesheet" href="assets/css/green.css">-->
   <link rel="stylesheet" href="assets/css/owl.carousel.css">
   <link rel="stylesheet" href="assets/css/owl.transitions.css">
   <!--<link rel="stylesheet" href="assets/css/owl.theme.css">-->
   <link href="assets/css/lightbox.css" rel="stylesheet">
   <link rel="stylesheet" href="assets/css/animate.min.css">
   <link rel="stylesheet" href="assets/css/rateit.css">
   <link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
   <!-- Demo Purpose Only. Should be removed in production -->
   <link rel="stylesheet" href="assets/css/config.css">
   <link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
   <link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
   <link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
   <link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
   <link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">
   <link rel="stylesheet" href="assets/css/font-awesome.min.css">
   <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
   
   <!--Magnify-->
   <link type="text/css" href="magnify/magnifier.css" rel="stylesheet">
	<script type="text/javascript" src="magnify/magnifier.js"></script>
   <!-- Favicon 
      <link rel="shortcut icon" href="assets/images/favicon.ico">-->
   <script type="text/javascript">
      function valid()
      {
       if(document.register.password.value!= document.register.confirmpassword.value)
      {
      alert("Password and Confirm Password Field do not match  !!");
      document.register.confirmpassword.focus();
      return false;
      }
      return true;
      }
   </script>
   <script>
      function userAvailability() {
      $("#loaderIcon").show();
      jQuery.ajax({
      url: "check_availability.php",
      data:'email='+$("#email").val(),
      type: "POST",
      success:function(data){
      $("#user-availability-status1").html(data);
      $("#loaderIcon").hide();
      },
      error:function (){}
      });
      }
   </script>
   <script type="text/javascript">
      function valid()
      {
      if(document.chngpwd.cpass.value=="")
      {
      alert("Current Password Filed is Empty !!");
      document.chngpwd.cpass.focus();
      return false;
      }
      else if(document.chngpwd.newpass.value=="")
      {
      alert("New Password Filed is Empty !!");
      document.chngpwd.newpass.focus();
      return false;
      }
      else if(document.chngpwd.cnfpass.value=="")
      {
      alert("Confirm Password Filed is Empty !!");
      document.chngpwd.cnfpass.focus();
      return false;
      }
      else if(document.chngpwd.newpass.value!= document.chngpwd.cnfpass.value)
      {
      alert("Password and Confirm Password Field do not match  !!");
      document.chngpwd.cnfpass.focus();
      return false;
      }
      return true;
      }
   </script>
   <script language="javascript" type="text/javascript">
      var popUpWin=0;
      function popUpWindow(URLStr, left, top, width, height)
      {
       if(popUpWin)
      {
      if(!popUpWin.closed) popUpWin.close();
      }
      popUpWin = open(URLStr,'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+600+',height='+600+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
      }
      
   </script>
</head>