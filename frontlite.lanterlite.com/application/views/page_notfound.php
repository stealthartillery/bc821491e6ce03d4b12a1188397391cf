<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="icon" href="<?php echo BASE_URL; ?>assets/lite.img/icon.gif">
	<title>Page Not Found! - Lanterlite</title>

	<style type="text/css">
		* {
		  margin: 0;
		  padding: 0;
		}

		html,code {
		  font: 15px/22px arial,sans-serif;
		}

		html {
		  background: #1a1a1a;
		  color: #222;
		  padding: 15px;
		}

		body {
		  margin: 7% auto 0;
		  max-width: 390px;
		  min-height: 180px;
		  padding: 30px 0 15px;
		}

		table {
			margin: auto;
		}

		td {
			padding: 10px;
			text-align: center;
		}

		h1 {
			color: goldenrod;
			font-size: 70px;
		}
		div {
			color: goldenrod;
	    width: fit-content;
      font-size: 25px;
		}
		.img {
			background: url(<?php echo BASE_URL; ?>assets/lite.img/gray-lamp.png) no-repeat 100% 100%;
			background-size: 100% 100%;
	    cursor: pointer;
	    border: none;
	    width: 75px;
	    height: 100px;
	    margin: 50px auto;
		}
		.home {
	    margin: 20px auto;
	    color: lightgray;
	    font-size: 14px;
	    cursor: pointer;
	    text-decoration: none;
		}
		.home:hover {
	    color: goldenrod;
		}
	</style>
</head>

	<body bgcolor="#1a1a1a">
		<table>
			<tr>
				<td>
					<div class='img'></div>
				</td>
			</tr>
			<tr>
				<td>
					<h1>404</h1>
				</td>
			</tr>
			<tr>
				<td>
					<div>Page Not Found!</div>
				</td>
				<td>
				</td>
			</tr>
			<tr>
				<td style="height: 70px">
					<a href="<?php echo HOME_URL; ?>" class="home">Back To Home</a>
				</td>
				<td>
				</td>
			</tr>
			
		</table>
	</body>

</html>