<?php 

#error_reporting(E_ALL);
#ini_set('display_errors', 'On');

include("/var/www/vhosts/blockchainstack.net/restricted/stellar_integration_functions.php");

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]) {
} else {
	header("Location: /");
	exit;
}

$_SESSION["loggedin"] = true;
$_SESSION["page"] = 1;

?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title><?=$SITE_NAME?> Dashboard</title>

    <!-- Place favicon.png and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" type="image/ico" href="/images/favicon.png">

    <!-- Vendor styles -->
    <link rel="stylesheet" href="/assets/common/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="/assets/common/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="/assets/common/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="/assets/common/vendor/bootstrap/dist/css/bootstrap.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="/assets/common/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="/assets/common/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="/assets/common/styles/style.css">
	<style>
		body #canvas-wrapper {
		  position: fixed;
		  top: 0;
		  left: 0;
		  right: 0;
		  bottom: 0;
		  width: 100%;
		  height: 100%;
		}
		body {
		  overflow: hidden;
		  background: url("/assets/common/images/1.jpg") no-repeat top center #2d494d;
		}
		h1, h3, small {
				color: white;
		}
	</style>
</head>
<body class="blank">

<div class="color-line"></div>

<div style="padding-top:10px">

    <div class="row">
        <div class="col-md-12">
            <div class="text-center">
				<h1><?=$SITE_NAME?></h1>
                
				<h3>Admin Dashboard</h3>

            </div>
			
           <div class="row">

				<div class="col-md-3"></div>
				
				<table class="col-md-6">
					<tr style="width:100%; text-center">
						<td style="width:100%; padding:10px"><a href="/admin_logout.php" class="btn btn-warning btn-block" style="font-size:16px; text-decoration:underline">IMPORTANT: CLICK TO LOGOUT</a></td>
					</tr>
				</table>
				
				<div class="col-md-3"></div>

            </div>
			
            <div class="row">

				<div class="col-md-3"></div>
				
				<table class="col-md-6">
					<tr style="width:100%; text-center">
						<td style="width:5%; padding:10px">&nbsp;</td>td>
						<td style="width:30%; padding:10px"><a href="admin_balance.php" class="btn btn-success btn-block" style="font-size:16px; text-decoration:underline">Asset Balances</a></td>
						<td style="width:30%; padding:10px"><a href="admin_changetrust.php" class="btn btn-success btn-block" style="font-size:16px; text-decoration:underline">Change Trust</a></td>
						<td style="width:30%; padding:10px"><a href="admin_token_payment.php" class="btn btn-success btn-block" style="font-size:16px; text-decoration:underline">Asset Payment</a></td>
						<td style="width:5%; padding:10px">&nbsp;</td>td>
					</tr>
				</table>
				
				<div class="col-md-3"></div>

            </div>
			
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center"><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        </div>
    </div>
</div>


<!-- Vendor scripts -->
<script src="/assets/common/vendor/jquery/dist/jquery.min.js"></script>
<script src="/assets/common/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="/assets/common/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="/assets/common/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/assets/common/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="/assets/common/vendor/iCheck/icheck.min.js"></script>
<script src="/assets/common/vendor/sparkline/index.js"></script>
<script type="text/javascript" src="/assets/common/vendor/login/EasePack.min.js"></script>
<script type="text/javascript" src="/assets/common/vendor/login/rAF.js"></script>
<script type="text/javascript" src="/assets/common/vendor/login/TweenLite.min.js"></script>

<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>

<?php 
include("admin_footer.php");
?>

</body>
</html>

<?php 
$mysqli2->close();
?>