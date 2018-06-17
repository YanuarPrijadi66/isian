<?php
date_default_timezone_set('America/Los_Angeles');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            Welcome to FreiChat
        </title>
<link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />

<!--===========================FreiChat=======START=========================-->
	<!--
	For uninstalling ME , first remove/comment all FreiChat related code i.e below code
	Then remove FreiChat tables frei_session & frei_chat if necessary
	The best/recommended way is using the module for installation
	-->

<head>

	<?php
	setcookie("userid", 'Admin', time()+3600, "/"); // *do not change -> freichat code
	$_SESSION['username'] = 'Admin';
	$ses=null;
	$username = $_SESSION['username'];
	if($username != '')
	{ 
		$ses = 'Admin'; //tell freichat the userid of the current user
		setcookie("freichat_user", "LOGGED_IN", time()+3600, "/"); // *do not change -> freichat code
	}
	else 
	{
		$ses = null; //tell freichat that the current user is a guest
		setcookie("freichat_user", null, time()+3600, "/"); // *do not change -> freichat code
	}
	if(!function_exists("freichatx_get_hash"))
	{
		function freichatx_get_hash($ses)
		{
			if(is_file("C:/xampp/htdocs/freichat/hardcode.php"))
			{
				require "C:/xampp/htdocs/freichat/hardcode.php";
				$temp_id =  $ses . $uid;
				return md5($temp_id);
			}
			else
			{
				echo "<script>alert('module freichatx says: hardcode.php file not found!');</script>";
			}

			return 0;
		}
	}
	?>
	<script type="text/javascript" language="javascipt" src="http://localhost/freichat/client/main.php?id=<?php echo $ses;?>&xhash=<?php echo freichatx_get_hash($ses); ?>"></script>
	<link rel="stylesheet" href="http://localhost/freichat/client/jquery/freichat_themes/freichatcss.php" type="text/css">
<!--===========================FreiChatX=======END=========================-->            
    
        <style type="text/css">
            * {
                margin: 0;
            }
            html, body {
                height: 100%;
            }
            .wrapper {
                min-height: 100%;
                height: auto !important;
                height: 100%;
                margin: 0 auto -2em;
            }
            .footer, .push {
                height: 0em;
            }


            .adminbutton {
                -moz-box-shadow:inset 0px 0px 0px 0px #bbdaf7;
                -webkit-box-shadow:inset 0px 0px 0px 0px #bbdaf7;
                box-shadow:inset 0px 0px 0px 0px #bbdaf7;
                background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #79bbff), color-stop(1, #378de5) );
                background:-moz-linear-gradient( center top, #79bbff 5%, #378de5 100% );
                filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#79bbff', endColorstr='#378de5');
                background-color:#79bbff;
                -moz-border-radius:10px;
                -webkit-border-radius:10px;
                border-radius:10px;
                border:2px solid #84bbf3;
                display:inline-block;
                color:#ffffff;
                font-family:Arial;
                font-size:28px;
                font-weight:bold;
                padding:10px 42px;
                text-decoration:none;
                text-shadow:1px 0px 0px #528ecc;
            }.adminbutton:hover {
                background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #378de5), color-stop(1, #79bbff) );
                background:-moz-linear-gradient( center top, #378de5 5%, #79bbff 100% );
                filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#378de5', endColorstr='#79bbff');
                background-color:#378de5;
            }.adminbutton:active {
                position:relative;
                top:1px;
            }
          


            .installbutton {
                -moz-box-shadow:inset 0px 0px 0px 0px #caefab;
                -webkit-box-shadow:inset 0px 0px 0px 0px #caefab;
                box-shadow:inset 0px 0px 0px 0px #caefab;
                background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #77d42a), color-stop(1, #5cb811) );
                background:-moz-linear-gradient( center top, #77d42a 5%, #5cb811 100% );
                filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#77d42a', endColorstr='#5cb811');
                background-color:#77d42a;
                -moz-border-radius:10px;
                -webkit-border-radius:10px;
                border-radius:10px;
                border:2px solid #268a16;
                display:inline-block;
                color:#306108;
                font-family:Arial;
                font-size:28px;
                font-weight:bold;
                padding:10px 76px;
                text-decoration:none;
                text-shadow:1px 0px 0px #aade7c;
            }.installbutton:hover {
                background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #5cb811), color-stop(1, #77d42a) );
                background:-moz-linear-gradient( center top, #5cb811 5%, #77d42a 100% );
                filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#5cb811', endColorstr='#77d42a');
                background-color:#5cb811;
            }.installbutton:active {
                position:relative;
                top:1px;
            }
.logo{

text-align:center;
}


        </style>
    </head>
    <body>


        <div class="wrapper">
            <div class="logo">

                <a href="http://codologic.com"><img src="administrator/admin_files/home/head.png" height=100  /></a>
            </div>


            <div style="text-align:center"> 
            <div style="padding-top:40px"><a href = 'installation/index.php' class='installbutton'>Install</a></div>


            <div style="padding-top:100px"><a  href = 'administrator/index.php' class='adminbutton'>administer</a></div>
            </div>
        <div class="push"></div>
    </div>



    <div class="footer">
  <p style="text-align:center;font-size:8pt;">
    &#169;<?php echo date('Y'); ?> <a style="color: blue" href="http://codologic.com">Codologic.com</a> 
    - <a  style="color: blue" href="installation/license.txt" target="_blank">Terms & Conditions</a>
</p>
    </div>
</body>
</html>
