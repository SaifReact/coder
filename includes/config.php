<?php
   define('DB_SERVER','localhost');
   define('DB_USER','root');
   define('DB_PASS' ,'');
   define('DB_NAME', 'ecodermart');
   $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
   // Check connection
   if (mysqli_connect_errno())
   {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }
   

	$sql=mysqli_query($con,"select * from basic where id='1'");
	while($row=mysqli_fetch_array($sql))
	{	
	    $id=$row['id'];
		$currency=$row['currency'];
		$compName=$row['compName'];
		$compName=$row['compName_en'];
		$compDescription=$row['compDescription'];
		$address=$row['address'];
		$logo=$row['logo'];
		$phone1=$row['phone'];
		$phone2=$row['office_phone'];
		$email=$row['email'];
		$facebook=$row['facebook'];
		$twitter=$row['twitter'];
		$linkedin=$row['linkedin'];
	}
	
	
?>