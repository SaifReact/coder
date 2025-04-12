<?php
define('DB_SERVER','localhost');
define('DB_USER','root');
define('DB_PASS' ,'');
define('DB_NAME', 'coder');

$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully!";
}

$compId = 1;
$stmt = $con->prepare("SELECT * FROM COMPANY a LEFT JOIN BASIC b ON a.id = b.compId WHERE a.id = ? AND a.status = 'A'");
$stmt->bind_param("i", $compId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
		$id = $row['id'];
		$companyName = $row['companyName'];
		$companyName_bn = $row['companyName_bn'];
		$compId = $row['compId'];
		$description=$row['description'];
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

$stmt->close();
mysqli_close($con);
?>
