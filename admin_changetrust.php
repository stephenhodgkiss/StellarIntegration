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

if (isset($_SESSION["network_status"]) && is_numeric($_SESSION["network_status"])) {
	$network_status = $_SESSION["network_status"];
} else {
	$network_status = "0";
	$_SESSION["network_status"] = $network_status;
}

$testnetButtonColor = "none";
$publicButtonColor = "none";

if ($network_status == 0) {
	$testnetButtonColor = "green";
} else {
	$publicButtonColor = "green";
}

?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title><?=$SITE_NAME?> ChangeTrust</title>

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
		  
		  background: url("/assets/common/images/1.jpg") no-repeat top center #2d494d;
		}
		h1, h3, small {
				color: white;
		}
		.noHover{
			pointer-events: none;
		}
		.button-borders {
			border:solid 1px white;
		}
		.button-margins {
			margin-top:5px;
			margin-bottom:5px;
		}
	</style>
</head>
<body id="main_body" class="blank">

<div class="color-line"></div>

<div style="padding-top:10px">

    <div class="row">
        <div class="col-md-12">
            <div class="text-center">
				<h1><?=$SITE_NAME?></h1>
                
				<h3>Change Trust</h3>

            </div>
			
           <div class="row">

				<div class="col-md-3"></div>
				
				<table class="col-md-6">
					<tr style="width:100%">
						<td style="width:30%; padding:10px"><a href="/dashboard.php" class="btn btn-warning btn-block button-margins" style="font-size:16px; text-decoration:underline">ADMIN DASHBOARD</a></td>
						<td style="width:70%; padding:10px"><a href="/admin_logout.php" class="btn btn-warning btn-block button-margins" style="font-size:16px; text-decoration:underline">IMPORTANT: CLICK TO LOGOUT</a></td>
					</tr>
				</table>
				
				<div class="col-md-3"></div>

            </div>

            <div class="row">

				<div class="col-md-3"></div>
				
				<table class="col-md-6">
					<tr style="width:100%">
						<td class="table-borders" style="padding:5px"><a href=# onclick="ChangeNetwork('0'); return false;" class="button-borders btn btn-block button-margins" style="color:white; background-color:<?=$testnetButtonColor?>; font-size:14px; text-decoration:underline">Testnet</a></td>
						<td class="table-borders" style="padding:5px"><a href=# onclick="ChangeNetwork('1'); return false;" class="button-borders btn btn-block button-margins" style="color:white; background-color:<?=$publicButtonColor?>; font-size:14px; text-decoration:underline">Public</a></td>
					</tr>
				</table>
				
				<div class="col-md-3"></div>
				
			</div>

			<div class="row">

		        <div class="col-md-3"></div>
		        <div class="col-md-6">

					<table class="form-group" style="font-size:16px">
					
						<td for="seckey" style="font-weight:bold; width:200px; text-align:right">Receiver's Secret Key</td>
						<td style="padding-left:10px"><input id=seckey autofocus="autofocus" type=text class=ftext value="" placeholder="" class="form-control" size="60" style="background-color:#A9D2F6"></td>

					</table>

				</div>

				<div class="col-md-3"></div>

			</div>

			<div class="row">

		        <div class="col-md-3"></div>
		        <div class="col-md-6">

		        	<table class="form-group" style="font-size:16px">

						<td style="padding-left:10px"><a href=# onclick="changeTrust('<?=$network_status?>'); return false;" class="btn btn-success btn-block" style="font-size:16px">Submit</a></td>
						
					</table>

		        </div>

		        <div class="col-md-3"></div>

		    </div>

			<div class="row">

		        <div class="col-md-3"></div>

		        <div class="col-md-6" id=errormsg style="text-align:center; font-size:16px; color:white">&nbsp;</div>

		        <div class="col-md-3"></div>

		    </div>

		    <br /><br />

            <div class="row table-responsive">

            	<div class="col-md-3"></div>

				<div class="col-md-6" id="data_balances" style="text-align:center; color:white">&nbsp;</div>

				</table>
				
				<div class="col-md-3"></div>

            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center"><br>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/stellar-sdk/8.1.1/stellar-sdk.min.js"></script>

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