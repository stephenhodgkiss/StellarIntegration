<?php 

session_start();

$_SESSION["loggedin"] = true;
$_SESSION["page"] = 1;

if (isset($_POST["network_status"]) && is_numeric($_POST["network_status"])) {
	$_SESSION["network_status"] = $_POST["network_status"];
}

?>