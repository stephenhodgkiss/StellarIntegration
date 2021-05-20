<?php 

#error_reporting(E_ALL);
#ini_set('display_errors', 'On');

include("/var/www/vhosts/blockchainstack.net/restricted/stellar_integration_functions.php");

$errorStatus = "An error has occured";
$_SESSION["loggedin"] = false;

if (isset($_POST['username']) && isset($_POST['password'])) {

	$username = str_replace(" ","",strip_tags($_POST['username']));
	$password = str_replace(" ","",strip_tags($_POST['password']));
	
	$username = $mysqli2->real_escape_string($username);
	$password = $mysqli2->real_escape_string($password);

	// select members 

	$sql = "SELECT * FROM admin_users WHERE username='$username'";

	$resultMember = $mysqli2->query($sql);

	if ($resultMember->num_rows > 0) {

		while($rowMember = $resultMember->fetch_assoc()) {

			$memberID = $rowMember["id"];
			$password = md5($password);
			$passwordHash = $rowMember["password"];
			$stellar_token = $rowMember["stellar_token"];
			$stellar_address = $rowMember["stellar_address"];

			if ($password == $passwordHash && $stellar_token != "") {
				$errorStatus = "ok";
				$_SESSION["loggedin"] = true;
				$_SESSION["stellar_token"] = $stellar_token;
				$_SESSION["stellar_address"] = $stellar_address;
			} else {
				$errorStatus = "Admin password invalid";
			}
			
		}
		
	} else {
		$errorStatus = "Admin username does not exist";
	}
	
} else {
	
	$errorStatus = "Call invalid";
	
}

echo $errorStatus;

$mysqli2->close();