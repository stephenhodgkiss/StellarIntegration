<?php 

#error_reporting(E_ALL);
#ini_set('display_errors', 'On');

include("/var/www/vhosts/blockchainstack.net/restricted/stellar_integration_functions.php");

?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title><?=$SITE_NAME?></title>

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
		  background-image: url(/images/unsplash2.jpg); position: fixed; top: 0; left: 0; min-width: 100%; min-height: 100%;
		}
		h1, h3, small {
				color: white;
		}
	</style>
</head>
<body class="blank">

<div class="color-line"></div>

<div class="login-container" style="padding-top:10px">

    <div class="row">
        <div class="col-md-12">
            <div class="text-center m-b-md">
				<h1><?=$SITE_NAME?></h1>
                
				<h3>Administrator Login</h3>
				
            </div>
            <div class="hpanel">
				
                <div class="panel-body">

					<div class="form-group" style="font-size:18px">
					
						<div for="username" style="font-weight:bold">Username</div>
						<div style="font-size:16px" for="username">(Only lowercase letters and numbers allowed)</div>
						
						<div><input id=user autofocus="autofocus" type=text class=ftext value="" placeholder="Your admin username" class="form-control" style="background-color:#A9D2F6"></div>
						<br>
						<div for="password" style="font-weight:bold">Password</div>
						
						<div><input id=password autofocus="autofocus" type=text class=ftext value="" placeholder="Your admin password" class="form-control" style="background-color:#A9D2F6"></div>
						
						<div><a href=# onclick="authLogin(); return false;" class="btn btn-success btn-block" style="font-size:16px">Login</a></div>
						
						<div id=errormsg style="color:red">&nbsp;</div>
						
					</div>
						
                </div>

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