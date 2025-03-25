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
		$compName=$row['compName'];
		$compName_en=$row['compName_en'];
		$address=$row['address'];
		$logo=$row['logo'];
		$currency=$row['currency'];
		$phone=$row['phone'];
		$office_phone=$row['office_phone'];
		$email=$row['email'];
		$facebook=$row['facebook'];
		$twitter=$row['twitter'];
		$linkedin=$row['linkedin'];
		$delivery_method=$row['delivery_method'];
		$messanger_group=$row['messanger_group'];
		$whatapps_group=$row['whatapps_group'];
	}
	
	
?>