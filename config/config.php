<?php

define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'coder');

// Mysqli connection
//$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

/*if (!$con) {
	if (mysqli_connect_errno()){ echo "Failed to connect to MySQL: " . mysqli_connect_error();} 
}*/

//PDO Connection

try {
    $dsn = "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Connection successful!<br>";

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
    WHERE a.id = :compId AND a.status = 'A'";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':compId', $compId, PDO::PARAM_INT);
    $stmt->execute();

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $companyId        = $row['company_id'];
        $basicId          = $row['basic_id'];
        $companyName      = $row['companyName'];
        $companyName_bn   = $row['companyName_bn'];
        $description      = $row['description'];
        $address          = $row['address'];
        $logo             = $row['logo'];
        $currency         = $row['currency'];
        $phone            = $row['phone'];
        $office_phone     = $row['office_phone'];
        $email            = $row['email'];
        $facebook         = $row['facebook'];
        $twitter          = $row['twitter'];
        $linkedin         = $row['linkedin'];
        $delivery_method  = $row['delivery_method'];
        $messanger_group  = $row['messanger_group'];
        $whatapps_group   = $row['whatapps_group'];

        // You can echo or return this data here
		
		// echo json_encode($row, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

    }

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
