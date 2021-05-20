<?php
#error_reporting(E_ALL);
#ini_set('display_errors', 'On');

session_start();

session_destroy();
$_SESSION = array();

?>

<script>
	window.addEventListener('load', function () {
		document.location.href = '/admin_login.php';
	})
</script>
