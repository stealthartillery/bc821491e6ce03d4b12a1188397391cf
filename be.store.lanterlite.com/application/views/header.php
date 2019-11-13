<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE HTML>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Lanterlite</title>
		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css"/>
		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/navbar.css"/>
		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/header.css"/>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/header.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/general.js"></script>
	</head>

	<body background="<?php echo base_url(); ?>assets/images/bgimage.jpg">
	<div class="header">
		<table>
			<tr>
				<td class="header-col-logo" rowspan="2"> <a href="#link"><img id="header-logo" src="<?php echo base_url(); ?>assets/images/blog-header.png"/> </td></a>
				<td rowspan="2"> <a class="menu-bar" href="<?php echo base_url(); ?>">Home</a> </td>
				<td rowspan="2"> <a class="menu-bar" href="<?php echo base_url(); ?>product">Product</a> </td>
				<td rowspan="2"> <a class="menu-bar" href="<?php echo base_url(); ?>about">About</a> </td>
				<td rowspan="2"> <a class="menu-bar" href="<?php echo base_url(); ?>donate">Donate</a> </td>
				<td rowspan="2" width="100%"></td>

				<form id="signin_form" onsubmit="return signIn()">

				<td id="header-col-email" style="display: none"> <input class="signin_box" id="email" autocomplete="off" type="text" placeholder="Email"
					> </td>
				<td id="header-col-username" style="display: none"> <label id="header-username"></label> </td>
				<td id="header-col-pass" style="display: none"> <input class="signin_box" id="password" type="password" placeholder="Password"> </td>

				<td id="header-col-image" style="display: none">
					<div class="dropdown" id="userimg_div" >
						<img id="user_img">
						<div class="dropdown-content">
							<a onclick="logout()">Logout</a>
						</div>
					</div>
				</td>

				<td id="header-col-signin-btn" style="display: none"> <button class="brown-btn" id="signin_btn" type="submit" name="submit" value="save">Sign In</button> </td>

				</form>
			</tr>
			<tr>
				<td id="header-col-signin-warn" style="display: none"> <label id="signin_warn_lbl"></label> </td>
				<td id="header-col-show-pass" style="display: none">
					<!-- <label id="warn_pass_txt"></label> -->
					<div class="inline-field" id="showpass_cbox" >
						<input type="checkbox" id="pass_cbx" onclick="showPassword()">
					 	<label id="pass_cbx_txt" for="checkbox">Show Password</label>
					</div>
				</td>

				<td id="header-col-signup-btn" style="display: none"> <button class="brown-btn" id="signup_btn" onclick="location.href='<?php echo base_url(); ?>signup';" name="signupbtn">Sign Up</button> </td>

			</tr>			
		</table>
	</div>
	</body>
	
	<script type="text/javascript"> onLoad(); </script>
</html> 