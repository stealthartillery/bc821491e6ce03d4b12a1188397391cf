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
		background: url(<?php echo base_url(); ?>assets/lite.img/gray-lamp.png) no-repeat 5px 5px;
    background-size: 40px 50px;
    cursor: pointer;
    border: none;
    width: 50px;
    height: 60px;
		}
	</style>
</head>

	<body bgcolor="#1a1a1a">
		<table>
			<tr>
				<td>
					<h1>404</h1>
				</td>
				<td rowspan="2">
					<div class='img'></div>
				</td>
			</tr>
			<tr>
				<td>
					<div>Page Not Found!</div>
				</td>
				<td>
				</td>
			</tr>
			
		</table>
	</body>

</html>