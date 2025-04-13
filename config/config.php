<?php

define('DB_SERVER','localhost');
define('DB_USER','root');
define('DB_PASS' ,'');
define('DB_NAME', 'coder');

$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

if (!$con) {
	if (mysqli_connect_errno()){ echo "Failed to connect to MySQL: " . mysqli_connect_error();} 
}

$compId = 1;

$sql = "SELECT 
    a.id AS company_id,
    a.companyName,
    a.companyName_bn,
    a.status,
    b.id AS basic_id,
    b.logo,
    b.currency,
    b.phone,
    b.office_phone,
    b.email,
    b.facebook,
    b.twitter,
    b.linkedin,
    b.delivery_method,
    b.messanger_group,
    b.whatapps_group,
    b.description,
    b.address
FROM COMPANY a
INNER JOIN BASIC b ON a.id = b.compId
WHERE a.id = ? AND a.status = 'A'";


$stmt = $con->prepare($sql);
$stmt->bind_param("i", $compId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $companyId = $row['company_id'];
    $basicId = $row['basic_id'];
    $companyName = $row['companyName'];
    $companyName_bn = $row['companyName_bn'];
    $description = $row['description'];
    $address = $row['address'];
    $logo = $row['logo'];
    $currency = $row['currency'];
    $phone = $row['phone'];
    $office_phone = $row['office_phone'];
    $email = $row['email'];
    $facebook = $row['facebook'];
    $twitter = $row['twitter'];
    $linkedin = $row['linkedin'];
    $delivery_method = $row['delivery_method'];
    $messanger_group = $row['messanger_group'];
    $whatapps_group = $row['whatapps_group'];
}

$stmt->close();
?>
